<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BanMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_banni_ne_peut_pas_acceder_au_dashboard()
    {
        $user = User::create([
            'name' => 'Banned User',
            'email' => 'banned@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'reputation' => 0,
            'banned_at' => now(),
        ]);

        $this->post('/login', [
            'email' => 'banned@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_user_actif_peut_acceder_au_dashboard()
    {
        $user = User::create([
            'name' => 'Active User',
            'email' => 'active@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'reputation' => 0,
            'banned_at' => null,
        ]);

        $this->post('/login', [
            'email' => 'active@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }
}