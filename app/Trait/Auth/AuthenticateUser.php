<?php

namespace App\Trait\Auth;

use Illuminate\Http\JsonResponse;

trait AuthenticateUser
{
    protected function authUser(int $userId): ?JsonResponse
    {
        if (auth()->user()->id === $userId) {
            return response()->json([
                'message' => 'Not authorized to make this request',
                'status' => 402
            ]);
        }
    }
}
