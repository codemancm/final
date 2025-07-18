<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class PgpService
{
    /**
     * Verify a PGP 2FA code.
     *
     * @param  \App\Models\User  $user
     * @param  string  $code
     * @return bool
     */
    public static function verify(User $user, $code)
    {
        if (!$user->pgp_key) {
            return false;
        }

        try {
            $decrypted = \gnupg_decrypt(new \gnupg(), $code);
            return $decrypted === Crypt::decryptString($user->pgp_2fa_token);
        } catch (\Exception $e) {
            return false;
        }
    }
}
