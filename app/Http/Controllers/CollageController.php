<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collage\CollagesResource;
use App\Http\Resources\Collage\ShowCollageResource;
use App\Models\Collage;
use Illuminate\Http\Request;

class CollageController extends Controller
{
    /**
     * Returns a list of collages based on search
     * @OA\Post (
     *     path="/api/collages",
     *     tags={"Collages"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      @OA\Property(
     *                          property="search",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "search":"Fiit",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="We successfully return a list of collage",
     *          @OA\JsonContent(
     *          @OA\Property(
     *              property="data", type="object",
     *              @OA\Property(
     *                  property="id", type="int", example="1"
     *              ),
     *              @OA\Property(
     *                  property="slug", type="string", example="fiit-stu"
     *              ),
     *              @OA\Property(
     *                  property="name", type="string", example="FIIT STU"
     *              ),
     *              @OA\Property(
     *                  property="description", type="string", example="Toto je popis ku skole FIIT STU"
     *              ),
     *              @OA\Property(
     *                  property="founded_at", type="date", example="1999-01-01"
     *              ),
     *              @OA\Property(
     *                  property="average_rating", type="int", example=4
     *              ),
     *              @OA\Property(
     *                  property="rating_count", type="int", example=90
     *              ),
     *          ),
     *        )
     *    ),
     * )
     */
    public function search(Request $request)
    {
        if (strlen($request->input('search')) >= 2) {
            return CollagesResource::collection(Collage::with('ratings')->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('description', 'like', '%' . $request->input('search') . '%');
            })->limit(8)->get());
        }
    }

    /**
     * Returns a single collage resource 
     * @OA\Get (
     *     path="/api/collage/{slug}",
     *     tags={"Collages"},
     *      @OA\Response(
     *          response=200,
     *          description="We successfully return a single resource of a collage",
     *          @OA\JsonContent(
     *          @OA\Property(
     *              property="data", type="object",
     *              @OA\Property(
     *                  property="id", type="int", example="1"
     *              ),
     *              @OA\Property(
     *                  property="slug", type="string", example="fiit-stu"
     *              ),
     *              @OA\Property(
     *                  property="name", type="string", example="FIIT STU"
     *              ),
     *              @OA\Property(
     *                  property="description", type="string", example="Toto je popis ku skole FIIT STU"
     *              ),
     *              @OA\Property(
     *                  property="founded_at", type="date", example="1999-01-01"
     *              ),
     *              @OA\Property(
     *                  property="average_rating", type="int", example=4
     *              ),
     *              @OA\Property(
     *                  property="rating_count", type="int", example=90
     *              ),
     *              @OA\Property(
     *                  property="ratings", type="object",
     *                  @OA\Property(
     *                      property="id", type="int", example="1"
     *                   ),
     *                   @OA\Property(
     *                       property="rating", type="int", example=5
     *                    ),
     *                    @OA\Property(
     *                       property="body", type="string", example="Celkom fajn"
     *                     ),
     *                    @OA\Property(
     *                       property="likes", type="int", example=12
     *                     ),
     *                      @OA\Property(
     *                          property="user", type="object",
     *                          @OA\Property(
     *                              property="id", type="int", example=1
     *                          ),
     *                          @OA\Property(
     *                              property="name", type="string", example="Janko hrasko"
     *                          ),
     *                          @OA\Property(
     *                              property="email", type="string", example="janko@email.com"
     *                          ),
     *                          @OA\Property(
     *                              property="age", type="16", example=12
     *                          ),
     *                     ),
     *                  @OA\Property(
     *                      property="comments", type="object",
     *                  @OA\Property(
     *                      property="id", type="int", example="1"
     *                   ),
     *                    @OA\Property(
     *                       property="body", type="string", example="Velka pravda sefko"
     *                     ),
     *                      @OA\Property(
     *                          property="user", type="object",
     *                          @OA\Property(
     *                              property="id", type="int", example=11
     *                          ),
     *                          @OA\Property(
     *                              property="name", type="string", example="Petko hrasko"
     *                          ),
     *                          @OA\Property(
     *                              property="email", type="string", example="petko@email.com"
     *                          ),
     *                          @OA\Property(
     *                              property="age", type="16", example=9
     *                          ),
     *                        )
     *                     ),
     *                  )
     *              )
     *          )
     *      )
     *  )
     */
    public function show(Collage $collage)
    {
        return new ShowCollageResource($collage->load([
            'ratings.user',
            'ratings.comments',
            'ratings.comments.user',
            'ratings.likes',
        ]));
    }
}
