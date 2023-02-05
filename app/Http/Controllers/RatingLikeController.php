<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\RatingLike;
use App\Trait\Auth\AuthenticateUser;

class RatingLikeController extends Controller
{
    use AuthenticateUser;

    /**
     * Likes a rating
     * @OA\Post (
     *     path="/api/rating/{id}/like",
     *     tags={"Rating"},
     *      @OA\Response(
     *          response=200,
     *          description="Likes the rating",
     *          @OA\JsonContent(
     *          @OA\Property(
     *              property="data", type="object",
     *                  @OA\Property(
     *                      property="message", type="string", example="Success"
     *                   ),
     *                )
     *              )
     *            )
     *          )
     *      )
     */
    public function create(Rating $rating)
    {
        if (!$this->authUser($rating->user_id)) {
            return $this->authUser($rating->user_id);
        }

        RatingLike::create([
            'rating_id' => $rating->id,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json(['message' => 'Success']);
    }

    /**
     * Unlikes a rating
     * @OA\Delete (
     *     path="/api/rating/{id}/unlike",
     *     tags={"Rating"},
     *      @OA\Response(
     *          response=200,
     *          description="Unlikes the rating",
     *          @OA\JsonContent(
     *          @OA\Property(
     *              property="data", type="object",
     *                  @OA\Property(
     *                      property="message", type="string", example="Success"
     *                   ),
     *                )
     *              )
     *            )
     *          )
     *      )
     */
    public function destroy(Rating $rating)
    {
        if (!$this->authUser($rating->user_id)) {
            return $this->authUser($rating->user_id);
        }

        RatingLike::where('rating_id', $rating->id)->where('user_id', $rating->user_id)->delete();

        return response()->json(['message' => 'Success']);
    }
}
