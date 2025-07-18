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
        $wallet = Auth::user()->wallet;
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
