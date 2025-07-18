<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use FurqanSiddiqui\BIP39\BIP39;
use FurqanSiddiqui\BIP39\Language\English;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting to seed roles and users...');

        // Create admin and vendor roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $vendorRole = Role::firstOrCreate(['name' => 'vendor']);
        $this->command->info('Admin and Vendor roles created successfully.');

        $successCount = 0;
        $errorCount = 0;

        // Create specific users first
        $specificUsers = [
            [
                'username' => 'Admin',
                'password' => 'Admin@123456',
                'role' => 'admin',
                'role_obj' => $adminRole
            ],
            [
                'username' => 'Vendor',
                'password' => 'Vendor@123456',
                'role' => 'vendor',
                'role_obj' => $vendorRole
            ],
            [
                'username' => 'User',
                'password' => 'User@123456',
                'role' => 'user',
                'role_obj' => null
            ]
        ];

        // Create the 3 specific users
        foreach ($specificUsers as $userData) {
            try {
                $mnemonic = $this->generateMnemonic();
                $referenceId = $this->generateReferenceId();

                if ($mnemonic === false) {
                    throw new \Exception("Unable to generate mnemonic.");
                }

                $user = User::create([
                    'username' => $userData['username'],
                    'password' => Hash::make($userData['password']),
                    'mnemonic' => $mnemonic,
                    'reference_id' => $referenceId,
                ]);

                // Assign role if specified
                if ($userData['role_obj']) {
                    $user->roles()->attach($userData['role_obj']);
                }

                $this->command->info("{$userData['role']} user created successfully:");
                $this->command->info("Username: {$userData['username']}");
                $this->command->info("Password: {$userData['password']}");
                $this->command->info("Mnemonic: {$mnemonic}");
                $this->command->info("Reference ID: {$referenceId}");
                $this->command->info("Role: " . ucfirst($userData['role']));
                $this->command->info("---");

                $successCount++;
            } catch (\Exception $e) {
                $this->command->error("Error creating {$userData['username']}: " . $e->getMessage());
                Log::error("Error seeding {$userData['username']}: " . $e->getMessage());
                $errorCount++;
            }
        }

        // Create 10 random vendors
        for ($i = 1; $i <= 10; $i++) {
            try {
                $username = $this->generateValidUsername("vendor{$i}");
                $password = $this->generateValidPassword();
                $mnemonic = $this->generateMnemonic();
                $referenceId = $this->generateReferenceId();

                if ($mnemonic === false) {
                    throw new \Exception("Unable to generate mnemonic.");
                }

                $user = User::create([
                    'username' => $username,
                    'password' => Hash::make($password),
                    'mnemonic' => $mnemonic,
                    'reference_id' => $referenceId,
                ]);

                $user->roles()->attach($vendorRole);

                $this->command->info("Random vendor user created successfully:");
                $this->command->info("Username: {$username}");
                $this->command->info("Password: {$password}");
                $this->command->info("Mnemonic: {$mnemonic}");
                $this->command->info("Reference ID: {$referenceId}");
                $this->command->info("Role: Vendor");
                $this->command->info("---");

                $successCount++;
            } catch (\Exception $e) {
                $this->command->error("Error creating random vendor{$i}: " . $e->getMessage());
                Log::error("Error seeding random vendor{$i}: " . $e->getMessage());
                $errorCount++;
            }
        }

        // Create 10 random regular users
        for ($i = 1; $i <= 10; $i++) {
            try {
                $username = $this->generateValidUsername("user{$i}");
                $password = $this->generateValidPassword();
                $mnemonic = $this->generateMnemonic();
                $referenceId = $this->generateReferenceId();

                if ($mnemonic === false) {
                    throw new \Exception("Unable to generate mnemonic.");
                }

                $user = User::create([
                    'username' => $username,
                    'password' => Hash::make($password),
                    'mnemonic' => $mnemonic,
                    'reference_id' => $referenceId,
                ]);

                $this->command->info("Random regular user created successfully:");
                $this->command->info("Username: {$username}");
                $this->command->info("Password: {$password}");
                $this->command->info("Mnemonic: {$mnemonic}");
                $this->command->info("Reference ID: {$referenceId}");
                $this->command->info("Role: Regular User");
                $this->command->info("---");

                $successCount++;
            } catch (\Exception $e) {
                $this->command->error("Error creating random user{$i}: " . $e->getMessage());
                Log::error("Error seeding random user{$i}: " . $e->getMessage());
                $errorCount++;
            }
        }

        $this->command->info("Seeding completed.");
        $this->command->info("Successfully created users: {$successCount}");
        $this->command->info("Failed to create users: {$errorCount}");
    }

    /**
     * Generate a valid username based on the AuthController rules.
     */
    private function generateValidUsername($baseUsername): string
    {
        $username = $baseUsername;
        
        // Ensure username is between 4 and 16 characters
        if (strlen($username) < 4) {
            $username .= Str::random(4 - strlen($username));
        } elseif (strlen($username) > 16) {
            $username = substr($username, 0, 16);
        }

        // Ensure username only contains letters and numbers
        $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);

        // Check if username already exists and modify if necessary
        $originalUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $username = substr($username, 0, 16);
            $counter++;
        }

        return $username;
    }

    /**
     * Generate a valid password based on the AuthController rules.
     */
    private function generateValidPassword(): string
    {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specialChars = '#$%&@^`~.,:;"\'\/|_-<>*+!?=[](){}';

        $password = $lowercase[rand(0, strlen($lowercase) - 1)] . 
                    $uppercase[rand(0, strlen($uppercase) - 1)] . 
                    $numbers[rand(0, strlen($numbers) - 1)] . 
                    $specialChars[rand(0, strlen($specialChars) - 1)];

        for ($i = strlen($password); $i < 8; $i++) {
            $allChars = $lowercase . $uppercase . $numbers . $specialChars;
            $password .= $allChars[rand(0, strlen($allChars) - 1)];
        }

        return str_shuffle($password);
    }

    /**
     * Generate a secure mnemonic phrase using BIP39.
     *
     * @return string|false
     */
    protected function generateMnemonic()
    {
        try {
            $mnemonic = BIP39::fromRandom(
                English::getInstance(),
                wordCount: 12
            );
            return implode(' ', $mnemonic->words);
        } catch (\Exception $e) {
            Log::error('Failed to generate mnemonic: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate a unique reference ID.
     */
    protected function generateReferenceId(): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $referenceId = '';
        $characterCount = strlen($characters);
        
        for ($i = 0; $i < 16; $i++) {
            $referenceId .= $characters[random_int(0, $characterCount - 1)];
        }
        
        // Ensure there are exactly 8 letters and 8 digits
        $letters = preg_replace('/[^A-Z]/', '', $referenceId);
        $digits = preg_replace('/[^0-9]/', '', $referenceId);
        
        while (strlen($letters) < 8) {
            $letters .= $characters[random_int(0, 25)];
        }
        while (strlen($digits) < 8) {
            $digits .= $characters[random_int(26, 35)];
        }
        
        // Trim excess characters if necessary
        $letters = substr($letters, 0, 8);
        $digits = substr($digits, 0, 8);
        
        // Combine and shuffle
        $referenceId = str_shuffle($letters . $digits);
        
        return $referenceId;
    }
}
