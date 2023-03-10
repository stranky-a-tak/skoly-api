<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Collage;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\RatingLike;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user =  User::factory()->create([
            'name' => 'test',
            'email' => 'email@email.com',
            'password' => bcrypt('test123')
        ]);

        $collage = Collage::factory()->create([
            'name' => 'FEI STU',
            'slug' => 'fei-stu',
            'description' => 'Poslaním Fakulty elektrotechniky a informatiky, jednej z najstarších
                technických fakúlt na Slovensku s bohatou vedeckou a výskumnou činnosťou, 
                je poskytovanie kvalitného vzdelávania na báze slobodného vedeckého bádania
                a tvorivej výskumnej práce.',
        ]);

        Collage::factory()->create([
            'name' => 'FIIT STU',
            'slug' => 'fiit-stu',
            'description' => 'Fakulta informatiky a informačných technológií STU v Bratislave
                Na Slovensku v súčasnosti chýba až 20 000 informatikov, v Európe dokonca až 900 000! Zaplň medzeru na trhu.',
        ]);

        foreach (range(1, 300) as $test) {
            Collage::factory()->create([
                'name' => 'MTF STU',
                'slug' => 'mtf-stu',
                'description' => 'Materiálovotechnologická fakulta STU v Bratislave so sídlom v Trnave chce byť, v 
                kontexte s víziou STU, výskumne orientovanou, celoslovensky a medzinárodne uznávanou a priemyslom akceptovanou fakultou. 
                Chce poskytovať špičkové, medzinárodne porovnateľné vzdelávanie a rozvíjať moderné trendy vo výskume a priemyselnej výrobe.',
            ]);
        }

        $rating = Rating::factory()->create([
            'user_id' => $user->id,
            'user_ip' => '123',
            'collage_id' => $collage->id,
            'rating' => '3',
            'body' => 'Nic moc akoze'
        ]);

        RatingLike::factory()->create([
            'user_id' => $user->id,
            'rating_id' => $rating->id,
        ]);

        Comment::factory()->create([
            'user_id' => $user->id,
            'collage_id' => $collage->id,
            'rating_id' => 1,
            'body' => 'davam ti za pravdu sefe'
        ]);
    }
}
