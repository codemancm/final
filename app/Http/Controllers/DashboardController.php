<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.index');
        }

        if ($user->hasRole('vendor')) {
            return redirect()->route('vendor.index');
        }

        return view('dashboard', compact('user'));
    }

    private function determineUserRole(User $user): string
    {
        if ($user->hasRole('admin') && $user->hasRole('vendor')) {
            return 'Admin & Vendor';
        } elseif ($user->hasRole('admin')) {
            return 'Administrator';
        } elseif ($user->hasRole('vendor')) {
            return 'Vendor';
        } else {
            return 'Buyer';
        }
    }
}
