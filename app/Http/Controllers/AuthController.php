<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\ForgotPasswordRequest;
use App\Http\Requests\UserRequests\LoginRequest;
use App\Http\Requests\UserRequests\ProfileImage;
use App\Http\Requests\UserRequests\RegiterRequest;
use App\Http\Requests\UserRequests\ResetPasswordRequest;
use App\Http\Requests\UserRequests\UpdateProfileDataRequest;
use App\Http\Resources\UserDetail;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     operationId="Log in",
     *     tags={"Authenticate User"},
     *     summary="Log In",
     *     description="Authenticate",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"email","password"},
     *                 @OA\Property(property="email",type="email"),
     *                 @OA\Property(property="password",type="string"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successfully Logged in",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\JsonContent()
     *     ),
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        return response()->json(['success' => true, 'message' => 'You have been log in', 'data' => UserDetail::make($user), 'token' => $token], 200);
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     operationId="Log out",
     *     tags={"Authenticate User"},
     *     summary="Log out",
     *     security={{"bearer":{}}},
     *     description="Authenticate",
     *     @OA\Response(
     *         response="200",
     *         description="Successfully Logged in",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\JsonContent()
     *     ),
     * )
     */
    public function logout(LoginRequest $request): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();
        auth()->guard('web')->logout();
        return response()->json(['success' => true, 'message' => 'You have been logged out']);
    }
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Authenticate User"},
     *     summary="Register User",
     *     description="Register User",
     *     operationId="register users",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name","email","password","password_confirmation"},
     *                  @OA\Property(property="name",type="text"),
     *                  @OA\Property(property="email",type="email"),
     *                  @OA\Property(property="password",type="password"),
     *                  @OA\Property(property="password_confirmation",type="password")
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful updated post",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function register(RegiterRequest $request): JsonResponse
    {
        $newUser = $request->validated();
        try {
            $user = User::create($newUser);
            return response()->json(['success' => true, 'message' => 'New user have been created', 'data' => UserDetail::make($user)], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User Registration Failed!', 'error' => $e], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="api/user/remove",
     *     tags={"Authenticate User"},
     *     summary="Remove User",
     *     description="Remove User",
     *     operationId="remove users",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful updated post",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function remove(Request $request): JsonResponse
    {
        $user = Auth::user();
        $user->delete();
        return response()->json(['success' => true, 'data' => UserDetail::make($user)], 200);
    }
    /**
     * @OA\Put(
     *     path="/api/user/profile-image/update",
     *     tags={"Authenticate User"},
     *     summary="Update User Profile Image",
     *     description="Update User Profile Image",
     *     operationId="update user profile image",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"image"},
     *                  @OA\Property(property="image",type="file"),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful updated post",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function updateProfileImage(ProfileImage $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();
        $image = $data['image'];
        $ext = $image->getClientOriginalExtension();
        $imageName = 'profile-' . $user->id . '-' . time() . '.' . $ext;
        try {
            $path = public_path('/') . '/upload/profiles/user-' . $user->id . '/' . $user->image;
            if (File::exists($path)) {
                unlink($path);
            }
            $user->update(['image' => $imageName]);
            $image->move(public_path('/') . '/upload/profiles/user-' . $user->id, $imageName);
            return response()->json(['success' => true, 'message' => 'Profile image has been updated', 'data' => UserDetail::make($user)], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Profile image update failed!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/user/profile-data/update",
     *     tags={"Authenticate User"},
     *     summary="Update User Profile Data",
     *     description="Update User Profile Data",
     *     operationId="update user profile Data",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name","email"},
     *                  @OA\Property(property="name",type="text"),
     *                  @OA\Property(property="email",type="email"),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful updated post",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public  function updateProfileData(UpdateProfileDataRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();
        try {
            $user->update($data);
            return response()->json(['success' => true, 'message' => 'Profile data has been updated', 'data' => UserDetail::make($user)], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Profile data update failed!', 'error' => $e->getMessage()], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/me",
     *     tags={"Authenticate User"},
     *     summary="Show User Info",
     *     description="Show User Info",
     *     operationId="show user info",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful updated post",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function me(Request $request): JsonResponse
    {
        $user = Auth::user();
        return response()->json(['success' => true, 'data' => UserResource::make($user)], 200);
    }
    /**
     * @OA\Post(
     *     path="/api/auth/forget-password",
     *     tags={"Authenticate User"},
     *     summary="Forget user password",
     *     description="Forget user password",
     *     operationId="forget user password",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"email"},
     *                  @OA\Property(property="email",type="email"),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful updated post",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function forgetPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $email = $data['email'];
        try {
            $user = User::where('email', $email)->first();
            if ($user) {
                $remember_token = Str::random(60);
                DB::table('password_reset_tokens')->insert([
                    'email' => $email,
                    'token' => $remember_token,
                    'created_at' => Carbon::now()
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'User not found!'], 404);
            }
            return response()->json(['success' => true, 'data' => $email, 'reset_token' => $remember_token], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    /**
     * @OA\Post(
     *     path="api/auth/password/reset",
     *     tags={"Authenticate User"},
     *     summary="Reset User Password",
     *     description="Reset User Password",
     *     operationId="reset user password",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"email","reset_token","password","password_confirmation"},
     *                  @OA\Property(property="email",type="email"),
     *                  @OA\Property(property="reset_token",type="text"),
     *                  @OA\Property(property="password",type="password"),
     *                  @OA\Property(property="password_confirmation",type="password"),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful updated post",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $reset_request = $request->validated();
        $token = $reset_request['reset_token'];
        $email = $reset_request['email'];
        try {
            $tokenData = DB::table('password_reset_tokens')->where('token', $token)->first();
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Invalid token'], 404);
            }
            $user->update(['password' => Hash::make($reset_request['password'])]);
            DB::table('password_reset_tokens')->where('token', $token)->delete();
            return response()->json(['success' => true, 'new_password' => $request->password], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
}
