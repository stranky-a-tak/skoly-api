<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_needs_to_be_logged_in_to_access_his_profile()
    {
        $user = User::factory()->create([
            'name' => 'blabla bla profile test123',
            'email' => 'test123@email.com',
            'password' => 'heslo123',
        ]);

        $response = $this->get(sprintf("/api/profile/%s", $user->id));
        $response->assertStatus(401);
    }

    public function test_user_profile_get_request_returns_correct_data()
    {

        $user = $this->login();

        $response = $this->get(sprintf("/api/profile/%s", $user->id));

        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'age' => $user->age,
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_user_can_edit_his_profile()
    {
        $user = $this->login();

        $data = [
            'name' => 'Janko hrasko',
            'age' => 18,
        ];

        $response = $this->patch("/api/profile/" . $user->id, $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['name' => 'Janko Hrasko', 'age' => 18]);
        $this->assertDatabaseMissing('users', ['name' => $user->name]);
    }
}
