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
<<<<<<< HEAD
        $wallet = Auth::user()->wallet;
=======
        $user = Auth::user();
        $wallet = $user->wallet;

        if (is_null($wallet)) {
            // If the user does not have a wallet, create one
            $wallet = new Wallet();
            $user->wallet()->save($wallet);
            // Refresh the wallet variable
            $wallet = $user->fresh()->wallet;
        }

>>>>>>> 02ed0f34453d7b9732f9c64c17e03b526f5a3d9a
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
        // Logic for generating a new Monero address will be added later
        return redirect()->route('wallet.index');
    }
}
