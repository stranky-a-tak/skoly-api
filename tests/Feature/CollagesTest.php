<?php

namespace Tests\Feature;

use App\Models\Collage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollagesTest extends TestCase
{
    use RefreshDatabase;

    private function getCollage(): Collage
    {
        return Collage::where('name', 'FEI STU')->with('ratings')->first();
    }

    public function test_search_returns_data_in_correct_format()
    {
        $response = $this->post('/api/collages', ['search' => 'fei'], ['Content-Type' => 'json']);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'slug',
                    'name',
                    'description',
                    'founded_at',
                    'average_rating',
                    'rating_count',
                ]
            ]
        ]);

        $response->assertOk();
    }

    public function test_search_returns_correct_data()
    {
        $collage = $this->getCollage();
        $response = $this->post('/api/collages', ['search' => $collage->name]);

        $response->assertOk();
        $response->assertJson(
            [
                'data' => [
                    [
                        'id' => $collage->id,
                        'slug' => $collage->slug,
                        'name' => $collage->name,
                        'description' => $collage->description,
                        'founded_at' => $collage->founded_at,
                    ]
                ]
            ]
        );
    }

    public function test_show_method_returns_data_in_valid_format()
    {
        $response = $this->get('/api/collage/fei-stu');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'slug',
                'name',
                'description',
                'founded_at',
                'average_rating',
                'rating_count',
                'ratings' => [
                    [
                        'id',
                        'rating',
                        'body',
                        'likes',
                        'user' => [
                            'id',
                            'name',
                            'email'
                        ]
                    ]
                ],
            ]
        ]);
    }
    public function test_show_method_returns_correct_data()
    {
        $collage = $this->getCollage();
        $response = $this->get('/api/collage/fei-stu');

        $response->assertOk();
        $response->assertJson(
            [
                'data' => [
                    'id' => $collage->id,
                    'slug' => $collage->slug,
                    'name' => $collage->name,
                    'description' => $collage->description,
                    'founded_at' => $collage->founded_at,
                ]
            ]
        );
    }
}
