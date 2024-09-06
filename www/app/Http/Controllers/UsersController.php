<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"first_name", "last_name", "email", "role"},
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string",
     *                     description="First name",
     *                     default="John",
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     description="Last name",
     *                     default="Doe",
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="Email",
     *                     default="john.doe@example.com",
     *                 ),
     *                 @OA\Property(
     *                     property="role",
     *                     type="string",
     *                     description="Role (Please specify whether you are a student, teacher, parent, or private tutor)",
     *                     default="student",
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
        $validator = Validator::make($request->all(), [
            "first_name" => "required|max:255",
            "last_name" => "required|max:255",
            "email" => "required|email|unique:users|max:255",
            "role" =>
                "required|max:255|in:student,teacher,parent,private tutor",
        ]);

        if ($validator->fails()) {
            return new JsonResponse([
                "status" => "Failed",
                'errors' => $validator->errors()
            ], 422);
        }

        [
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email,
            "role" => $role,
        ] = $validator->getData();

        $user = new User();
        $user->name = "$firstName $lastName";
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->role = $role;
        $user->password = 'password';
        $user->push();

        $user->notify(new WelcomeEmailNotification());

        return response()->json(["status" => "Success"]);
    }
}
