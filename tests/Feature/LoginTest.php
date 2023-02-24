<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private function registerUser(): array
    {
        $data = [
            'name' => 'Test123',
            'email' => 'test123@email.com',
            'password' => 'heslo123',
            'password_confirmation' => 'heslo123'
        ];

        $response = $this->post('/api/register', $data);

        $this->assertDatabaseHas('users', ['name' => 'Test123']);

        $response->assertOk();

        unset($data['name'], $data['password_confirmation']);

        return $data;
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $this->registerUser();
        $loginResponse = $this->post('/api/login', [
            'email' => 'test123@email.com',
            'password' => 'zleheslo123'
        ]);

        $loginResponse->assertUnauthorized();
        $loginResponse->assertJsonStructure(['error']);
    }

    public function test_login_with_registered_user()
    {
        $data = $this->registerUser();
        $loginResponse = $this->post('/api/login', $data);

        $loginResponse->assertOk();
        $loginResponse->assertJsonStructure([
            'user' => [
                'id',
                "name",
                "email",
                "age",
            ]
        ]);
        $loginResponse->assertCookie('jwt');

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $loginResponse['user']['id']
        ]);
    }

    public function test_get_instance_of_logged_in_user()
    {
        $response = $this->get('/api/user');
        $response->assertUnauthorized();

        $user = $this->login();
        $response = $this->get('/api/user');
        $response->assertOk();
        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);
    }
}
