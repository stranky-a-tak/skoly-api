<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_endpoint_successfully_stores_user_and_returns_correct_status()
    {
        $data = [
            'name' => 'Test123',
            'email' => 'blablabla123@email.com',
            'password' => 'heslo123',
            'password_confirmation' => 'heslo123'
        ];

        $response = $this->post('/api/register', $data);

        $this->assertDatabaseHas('users', ['name' => 'Test123']);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Úspešne ste sa zaregistrovali']);
    }

    public function test_emails_have_to_be_unique()
    {
        $data = [
            'name' => 'Test123',
            'email' => 'blablabla123@email.com',
            'password' => 'heslo123',
            'password_confirmation' => 'heslo123'
        ];

        $this->post('/api/register', $data);

        $this->assertDatabaseHas('users', ['name' => 'Test123']);

        $data = [
            'name' => 'user2',
            'email' => 'blablabla123@email.com',
            'password' => 'heslo123',
            'password_confirmation' => 'heslo123'
        ];

        $this->post('/api/register', $data);
        $this->assertDatabaseMissing('users', ['name' => 'user2']);
    }

    public function test_passwords_have_to_match()
    {
        $data = [
            'name' => 'Test123',
            'email' => 'blablabla123@email.com',
            'password' => 'heslo123',
            'password_confirmation' => 'heslo'
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'Heslá sa musia zhodovať']);
        $this->assertDatabaseMissing('users', ['name' => 'Test123']);
    }

    public function test_passwords_have_to_be_min_6_characters()
    {
        $data = [
            'name' => 'Test123',
            'email' => 'blablabla123@email.com',
            'password' => 'heslo',
            'password_confirmation' => 'heslo'
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'Heslo musí mať najmennej 6 znakov']);
        $this->assertDatabaseMissing('users', ['name' => 'Test123']);
    }
}
