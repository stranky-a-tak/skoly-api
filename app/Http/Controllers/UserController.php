<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\ShowUserResource;
use App\Models\User;
use App\Trait\Auth\AuthenticateUser;

class UserController extends Controller
{
    use AuthenticateUser;

    /**
     * Get user data
     * @OA\Get (
     *     path="/api/profile/{id}",
     *     tags={"Profile"},
     *      @OA\Response(
     *          response=200,
     *          description="Gets user data for the profile page",
     *          @OA\JsonContent(
     *          @OA\Property(
     *              property="data", type="object",
     *                  @OA\Property(
     *                      property="id", type="int", example="1"
     *                   ),
     *                    @OA\Property(
     *                       property="name", type="string", example="Janko hrasko"
     *                     ),
     *                    @OA\Property(
     *                       property="email", type="string", example="janko@email.com"
     *                     ),
     *                   @OA\Property(
     *                      property="age", type="int", example=20
     *                   ),
     *              )
     *          )
     *      )
     *  )
     */
    public function show(User $user)
    {
        if (!$this->authUser($user->id)) {
            return $this->authUser($user->id);
        }

        return new ShowUserResource($user);
    }

    /**
     * Updates the profile
     * @OA\Patch (
     *     path="/api/profile/{id}",
     *     tags={"Profile"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                @OA\Property(
     *                     property="age",
     *                     type="int"
     *                 ),
     *                 example={
     *                     "name":"petko hrasko",
     *                     "age":12,
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
     *              )
     *          )
     *      )
     *  )
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        if (!$this->authUser($user->id)) {
            return $this->authUser($user->id);
        }

        $user->update($request->validated());

        return response()->json([
            'message' => 'Úspešne ste si akutalizovali profil'
        ]);
    }
}
