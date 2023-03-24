<?php

namespace App\Services\Collage;

use App\Http\Resources\Collage\CollagesResource;
use App\Models\Collage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class CollageService
{
    public function getSearchResult(Request $request): Collection|AnonymousResourceCollection
    {
        $input = $request->input('search');

        if (strlen($input) <= 2) {
            return new Collection();
        }

        // //TODO: add test case for cache
        if (Cache::has($input)) {
            return Cache::get($input);
        }

        $collages = CollagesResource::collection(Collage::search($input)->query(function ($query) {
            $query->with('ratings');
        })->take(8)->get());

        Cache::put($input, $collages, now()->addHours(24));

        return $collages;
    }
}
