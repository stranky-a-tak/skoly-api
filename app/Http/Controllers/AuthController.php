<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a user
     * @OA\Post (
     *     path="/api/register",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="age",
     *                          type="int"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password_confirmation",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"Janko hrasko",
     *                     "email":"janko@email.com",
     *                     "age":15,
     *                     "password":"hrasko123",
     *                     "password_confirmation":"hrasko123"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User created successfully",
     *          @OA\JsonContent(
     *          @OA\Property(
     *              property="message", type="object", example="success"
     *            ),
     *        )
     *    ),
     *      @OA\Response(
     *          response=422,
     *          description="Failed validation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message", type="string", example="Musite mat viac ako 16 rokov"
     *              ),
     *                  @OA\Property(
     *                      property="errors", type="object",
     *                   @OA\Property(
     *                       property="age", type="object", example="Musite mat viac ako 16 rokov"
     *                  ),
     *               ),
     *            ),
     *         )
     *      )
     */
    public function register(RegisterRequest $request)
    {
        User::create($request->validated());

        return response()->json([
            "message" => "Úspešne ste sa zaregistrovali"
        ]);
    }

    /**
     * Login
     * @OA\Post (
     *     path="/api/login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "email":"janko@email.com",
     *                     "password":"hrasko123"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Logged in successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type = "object",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="name", type="string", example="tvojtato"),
     *                  @OA\Property(property="email", type="string", example="tvojtato@email.com"),
     *                  @OA\Property(property="age", type="number", example=16),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Failed validation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message", type="string", example="Email musi byt uz zaregistrovany"
     *              ),
     *                  @OA\Property(
     *                      property="errors", type="object",
     *                   @OA\Property(
     *                       property="email", type="object", example="Email musi byt uz zaregistrovany"
     *                  ),
     *               ),
     *            ),
     *         )
     *      )
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json(["error" => "Zadali ste nesprávne heslo"], 401);
        }

        $token = auth()->user()->createToken('main')->plainTextToken;
        $user = User::where('email', $request->email)->firstOrFail();

        return response()->json([
            'user' => new UserResource($user)
        ])->cookie(
            'jwt',
            $token
        );
    }

    /**
     * Returns the user instance
     * @OA\Get (
     *     path="/api/user",
     *     tags={"Authentication"},
     *      @OA\Response(
     *          response=200,
     *          description="User is logged in",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="name", type="string", example="tvojtato"),
     *                  @OA\Property(property="email", type="string", example="tvojtato@email.com"),
     *                  @OA\Property(property="age", type="number", example=16),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="User is not logged in",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message", type="string", example="Unauthenticated"
     *              ),
     *            ),
     *         )
     *      )
     */
    public function user()
    {
        return auth()->user();
    }

    /**
     * Logs out the user
     * @OA\Post (
     *     path="/api/logout",
     *     tags={"Authentication"},
     *      @OA\Response(
     *          response=200,
     *          description="User logged out successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="object", example="Uspesne ste sa odhlasili"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="User is not logged in",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message", type="string", example="Unauthenticated"
     *              ),
     *            ),
     *         )
     *      )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Úspešne ste sa odlhásili'
        ]);
    }
}
