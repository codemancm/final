<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Wallet;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            if (!$user->wallet) {
                Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 0,
                    'monero_address' => null,
                ]);
            }
        }
    }
}
