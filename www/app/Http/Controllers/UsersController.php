<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="My twinkl-php-tech-test-main API", version="0.1")
 */
class UsersController extends Controller
{
    public function index(): JsonResponse
    {
        $user = User::all();

        return response()->json($user);
    }

    /**
     * @OA\Post(
     *     path="/api/user/store",
     *     summary="Store a new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"first_name", "last_name", "email", "role"},
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string",
     *                     description="First name",
     *                     default="",
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     description="Last name",
     *                     default="",
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="Email",
     *                     default="",
     *                 ),
     *                 @OA\Property(
     *                     property="role",
     *                     type="string",
     *                     description="Role (Please specify whether you are a student, teacher, parent, or private tutor)",
     *                     default="",
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(['status' => 'Success']);
    }
}
