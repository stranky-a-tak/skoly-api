<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Collage extends Model
{
    use HasFactory, Searchable;

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
