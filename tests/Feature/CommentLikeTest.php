<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentLikeTest extends TestCase
{
    use RefreshDatabase;

    private function getComment()
    {
        $user = $this->login();

        $rating = Rating::factory()->create([
            'user_id' => $user->id,
            'collage_id' => 1,
            'rating' => 5,
            'body' => 'v poho'
        ]);

        return Comment::factory()->create([
            'collage_id' => 1,
            'rating_id' => $rating->id,
            'parent_id' => null,
            'user_id' => $user->id,
            'body' => 'Suhlasim'
        ]);
    }

    public function test_liking_a_comment()
    {
        $comment = $this->getComment();

        $response = $this->post("/api/comment/$comment->id/like");
        $response->assertStatus(200);
        $this->assertDatabaseHas("comment_likes", ['comment_id' => $comment->id]);
    }

    public function test_unliking_a_comment()
    {
        $comment = $this->getComment();

        $response = $this->post("/api/comment/$comment->id/like");
        $response->assertStatus(200);
        $this->assertDatabaseHas("comment_likes", ['comment_id' => $comment->id]);

        $response = $this->delete("/api/comment/$comment->id/unlike");
        $response->assertStatus(200);
        $this->assertDatabaseMissing("comment_likes", ['comment_id' => $comment->id]);
    }
}
