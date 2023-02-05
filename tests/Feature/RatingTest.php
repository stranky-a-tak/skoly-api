<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RatingTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_review()
    {
        $data = [
            'collage_id' => 1,
            'user_id' => null,
            'rating' => 4,
            'body' => 'test'
        ];
        $response = $this->post('/api/rating', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('ratings', $data);
    }

    public function test_post_review_rating_is_required_validation()
    {
        $data = [
            'collage_id' => 1,
            'user_id' => null,
            'body' => 'test'
        ];

        $response = $this->post('/api/rating', $data, [
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('ratings', $data);
    }

    public function test_post_review_body_is_required_validation()
    {
        $data = [
            'collage_id' => 1,
            'user_id' => null,
            'rating' => 4
        ];

        $this->post('/api/rating', $data, [
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertDatabaseMissing('ratings', $data);
    }

    public function test_post_review_user_id_has_to_be_unique()
    {
        $data = [
            'collage_id' => 1,
            'user_id' => 1,
            'rating' => 4,
            'body' => 'test'
        ];

        $this->post('/api/rating', $data, [
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertDatabaseMissing('ratings', $data);
    }

    public function test_post_review_user_ip_has_to_be_unique()
    {
        $data = [
            'collage_id' => 1,
            'user_id' => null,
            'rating' => 12,
            'body' => 'nic moc'
        ];

        $this->post('/api/rating', $data);
        $this->assertDatabaseHas('ratings', $data);

        $data2 = [
            'collage_id' => 1,
            'user_id' => null,
            'rating' => 2,
            'body' => 'testing'
        ];

        $this->post('/api/rating', $data2);
        $this->assertDatabaseMissing('ratings', $data2);
    }

    public function test_users_with_correct_id_can_delete_ratings()
    {
        $user = User::factory()->create();

        $rating = Rating::factory()->create([
            'collage_id' => 1,
            'user_id' => $user->id,
            'user_ip' => null,
            'rating' => 1,
            'body' => 'test'
        ]);

        $this->assertDatabaseHas('ratings', $rating->toArray());

        $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'test123',
        ]);

        $response = $this->delete("/api/rating/$rating->id");

        $response->assertStatus(201);
        $this->assertDatabaseMissing('ratings', $rating->toArray());
    }

    public function test_user_with_incorrect_id_cannot_delete_ratings()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $rating = Rating::factory()->create([
            'collage_id' => 1,
            'user_id' => $user->id,
            'user_ip' => null,
            'rating' => 1,
            'body' => 'test'
        ]);

        $rating2 = Rating::factory()->create([
            'collage_id' => 1,
            'user_id' => $user2->id,
            'user_ip' => null,
            'rating' => 1,
            'body' => 'test'
        ]);

        $this->assertDatabaseHas('ratings', $rating->toArray());

        $this->delete("/api/rating/{$rating->id}");
        $this->assertDatabaseHas('ratings', $rating->toArray());

        $this->assertDatabaseHas('ratings', $rating2->toArray());

        $this->delete("/api/rating/{$rating2->id}");
        $this->assertDatabaseHas('ratings', $rating2->toArray());
    }
}
