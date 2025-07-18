<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_is_redirected_to_admin_dashboard()
    {
        $admin = User::factory()->create();
        $admin->roles()->create(['name' => 'admin']);

        $response = $this->post('/login', [
            'username' => $admin->username,
            'password' => 'password',
            'captcha' => '12345',
        ]);

        $response->assertRedirect('/admin');
    }

    public function test_vendor_is_redirected_to_vendor_dashboard()
    {
        $vendor = User::factory()->create();
        $vendor->roles()->create(['name' => 'vendor']);

        $response = $this->post('/login', [
            'username' => $vendor->username,
            'password' => 'password',
            'captcha' => '12345',
        ]);

        $response->assertRedirect('/vendor');
    }

    public function test_user_is_redirected_to_products_page()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password',
            'captcha' => '12345',
        ]);

        $response->assertRedirect('/products');
    }
}
