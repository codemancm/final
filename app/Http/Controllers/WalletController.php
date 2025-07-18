<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        if (is_null($wallet)) {
            // If the user does not have a wallet, create one
            $wallet = new Wallet();
            $user->wallet()->save($wallet);
            // Refresh the wallet variable
            $wallet = $user->fresh()->wallet;
        }

        if (is_null($wallet->deposit_address)) {
            $this->generateAddress();
            $wallet->refresh();
        }

        $transactions = Transaction::where('user_id', Auth::id())->latest()->paginate(15);
        return view('wallet.index', compact('wallet', 'transactions'));
    }

    public function deposit(Request $request)
    {
        // Logic for handling deposits will be added later
        return redirect()->route('wallet.index');
    }

    public function withdraw(Request $request)
    {
        // Logic for handling withdrawals will be added later
        return redirect()->route('wallet.index');
    }

    public function generateAddress()
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        if (is_null($wallet->deposit_address)) {
            $config = config('monero');
            $walletRPC = new \MoneroIntegrations\MoneroPhp\walletRPC(
                $config['host'],
                $config['port'],
                $config['ssl']
            );

            $result = $walletRPC->create_address(0, "User Deposit " . $user->id);
            $wallet->deposit_address = $result['address'];
            $wallet->deposit_address_index = $result['address_index'];
            $wallet->save();
        }

        return redirect()->route('wallet.index');
    }

    public function scanForDeposits()
    {
        $wallets = \App\Models\Wallet::whereNotNull('deposit_address')->get();
        $config = config('monero');
        $walletRPC = new \MoneroIntegrations\MoneroPhp\walletRPC(
            $config['host'],
            $config['port'],
            $config['ssl']
        );

        foreach ($wallets as $wallet) {
            $transfers = $walletRPC->get_transfers([
                'in' => true,
                'pool' => true,
                'subaddr_indices' => [$wallet->deposit_address_index],
                'filter_by_height' => true,
                'min_height' => $wallet->last_scanned_block_height,
            ]);

            foreach (['in', 'pool'] as $type) {
                if (isset($transfers[$type])) {
                    foreach ($transfers[$type] as $transfer) {
                        $amount = $transfer['amount'] / 1e12;
                        $wallet->balance += $amount;
                        $wallet->save();

                        \App\Models\Transaction::create([
                            'user_id' => $wallet->user_id,
                            'type' => 'deposit',
                            'amount' => $amount,
                            'description' => 'Deposit to ' . $wallet->deposit_address,
                        ]);
                    }
                }
            }

            $wallet->last_scanned_block_height = $walletRPC->get_height()['height'];
            $wallet->save();
        }
    }

    public function showWithdraw()
    {
        return view('wallet.withdraw');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'pgp_2fa' => 'required|string',
        ]);

        $user = Auth::user();

        // PGP 2FA Challenge
        if (!\App\Services\PgpService::verify($user, $request->pgp_2fa)) {
            return back()->with('error', 'Invalid PGP 2FA code.');
        }

        $wallet = $user->wallet;

        if ($wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance.');
        }

        // Process withdrawal
        try {
            $config = config('monero');
            $walletRPC = new \MoneroIntegrations\MoneroPhp\walletRPC(
                $config['host'],
                $config['port'],
                $config['ssl']
            );

            $result = $walletRPC->transfer([
                'address' => $request->address,
                'amount' => $request->amount * 1e12, // Convert to atomic units
                'priority' => 1
            ]);

            $wallet->balance -= $request->amount;
            $wallet->save();

            \App\Models\Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => -$request->amount,
                'description' => 'Withdrawal to ' . $request->address,
            ]);

            return redirect()->route('wallet.index')->with('success', 'Withdrawal successful.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Withdrawal failed: ' . $e->getMessage());
            return back()->with('error', 'Withdrawal failed. Please try again later.');
        }
    }
}
