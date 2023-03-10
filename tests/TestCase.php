<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $seed = true;

    protected function getUser(): User
    {
        return User::factory()->create([
            'name' => 'blabla bla profile test123',
            'email' => 'test123@email.com',
            'password' => 'heslo123',
        ]);
    }

    protected function login()
    {
        $user = $this->getUser();
        $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'heslo123',
        ]);

        return $user;
    }
}
