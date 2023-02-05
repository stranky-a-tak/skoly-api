<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Http\Requests\Rating\StoreRatingRequest;
use App\Http\Resources\Rating\ShowRatingResource;
use App\Trait\Auth\AuthenticateUser;

class RatingController extends Controller
{
    use AuthenticateUser;

    /**
     * Returns a single rating resource 
     * @OA\Get (
     *     path="/api/rating/{id}",
     *     tags={"Rating"},
     *      @OA\Response(
     *          response=200,
     *          description="We successfully return a single resource of a collage",
     *          @OA\JsonContent(
     *          @OA\Property(
     *              property="data", type="object",
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
     *                     ),
     *                  )
     *              )
     *          )
     *      )
     *  )
     */
    public function show(Rating $rating)
    {
        return new ShowRatingResource($rating->load(['user', 'comments', 'likes', 'comments.user']));
    }

    /**
     * Stores a rating
     * @OA\Post (
     *     path="/api/rating",
     *     tags={"Rating"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                @OA\Property(
     *                     property="collage_id",
     *                     type="int"
     *                 ),
     *                @OA\Property(
     *                     property="user_id",
     *                     type="int"
     *                 ),
     *                @OA\Property(
     *                     property="user_ip",
     *                     type="string"
     *                 ),
     *                @OA\Property(
     *                     property="rating",
     *                     type="int"
     *                 ),
     *                @OA\Property(
     *                     property="body",
     *                     type="string"
     *                 ),
     *                 example={
     *                     "collage_id":1,
     *                     "user_id":1,
     *                     "user_ip":"127.0.0.1",
     *                     "rating":1,
     *                     "body":"pohodinda",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="We store the rating",
     *          @OA\JsonContent(
     *          @OA\Property(
     *              property="data", type="object",
     *                  @OA\Property(
     *                      property="message", type="string", example="Success"
     *                   ),
     *                  @OA\Property(
     *                      property="id", type="int", example="1"
     *                   ),
     *                    @OA\Property(
     *                       property="collage_id", type="int", example=12
     *                     ),
     *                   @OA\Property(
     *                      property="user_id", type="int", example=12
     *                   ),
     *                   @OA\Property(
     *                      property="user_ip", type="string", example="190.0.0.5"
     *                   ),
     *                   @OA\Property(
     *                       property="rating", type="int", example=5
     *                    ),
     *                    @OA\Property(
     *                       property="body", type="string", example="Celkom fajn"
     *                     ),
     *                    @OA\Property(
     *                       property="created_at", type="date", example="2022-12-10"
     *                     ),
     *                    @OA\Property(
     *                       property="updated_at", type="date", example="2022-12-10"
     *                     ),
     *              )
     *          )
     *      )
     *  )
     */
    public function store(StoreRatingRequest $request)
    {
        $rating = Rating::create($request->validated());

        return response()->json(
            [
                'message' => 'Hodnotenie bolo úspšene vytvorené',
                'rating' => $rating
            ],
            201
        );
    }

    /**
     * Deletes a rating
     * @OA\Delete (
     *     path="/api/rating/{id}",
     *     tags={"Rating"},
     *      @OA\Response(
     *          response=201,
     *          description="We deleted the rating successfully",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message", type="string", example="Success"
     *                ),
     *              )
     *          )
     *      )
     */

    public function destroy(Rating $rating)
    {
        if (!$this->authUser($rating->user_id)) {
            return response()->json('Nemáte oprávnenie vymazať hodnotenie', 403);
        }

        $rating->delete();

        return response()->json('Hodnotenie bolo úspšene odstránené', 201);
    }
}
