<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\ForgotPasswordRequest;
use App\Http\Requests\UserRequests\LoginRequest;
use App\Http\Requests\UserRequests\ProfileImage;
use App\Http\Requests\UserRequests\RegiterRequest;
use App\Http\Requests\UserRequests\ResetPasswordRequest;
use App\Http\Resources\UserDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return User::all();
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        return response()->json(['success' => true, 'message' => 'You have been log in', 'data' => UserDetail::make($user), 'token' => $token], 200);
    }
    public function logout(LoginRequest $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();
        auth()->guard('web')->logout();
        return response()->json(['success' => true, 'message' => 'You have been logged out']);
    }
    public function register(RegiterRequest $request)
    {
        $newUser = $request->validated();
        try {
            $user = User::create($newUser);
            return response()->json(['success' => true, 'message' => 'New user have been created', 'data' => UserDetail::make($user)], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User Registration Failed!', 'error' => $e], 500);
        }
    }
    public function remove(Request $request)
    {
        $user = Auth::user();
        $user->delete();
        return response()->json(['success' => true, 'data' => UserDetail::make($user)], 200);
    }
    public function updateProfileImage(ProfileImage $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $image = $data['image'];
        $ext = $image->getClientOriginalExtension();
        $imageName = 'profile-'.$user->id.'-'.time() . '.' . $ext;
        try {
            $path=public_path('/') . '/upload/profiles/user-' . $user->id .'/'. $user->image;
            if(File::exists($path)){
                unlink($path);
            }
            $user->update(['image' => $imageName]);
            $image->move(public_path('/') . '/upload/profiles/user-'.$user->id, $imageName);
            return response()->json(['success' => true, 'message' => 'Profile image has been updated', 'data' =>UserDetail::make($user)], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Profile image update failed!', 'error' => $e], 500);
        }
    }
    public function me(Request $request)
    {
        $user = Auth::user();
        return response()->json(['success' => true, 'data' => UserDetail::make($user)], 200);
    }
    public function forgetPassword(ForgotPasswordRequest $request)
    {
        $data=$request->validated();
        $email=$request->email;
        try {
            $user=User::where('email',$email)->first();
            if($user){
                $remember_token=Str::random(60);
                DB::table('password_reset_tokens')->insert([
                    'email' => $email,
                    'token' => $remember_token,
                    'created_at'=>Carbon::now()
                ]);
            };
            return response()->json(['success'=>true,'data'=>$email,'reset_token'=>$remember_token],200);
        }catch (\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()],404);
        }
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        $reset_request=$request->validated();
        $token=$reset_request['reset_token'];
        $email=$reset_request['email'];
        try {
            $tokenData = DB::table('password_reset_tokens')->where('token',$token)->first();
            $user=User::where('email',$email)->first();
            if(!$user){
                return response()->json(['success'=>false,'message'=>'Invalid token'],404);
            }
            $user->update(['password'=>Hash::make($reset_request['password'])]);
            DB::table('password_reset_tokens')->where('token',$token)->delete();
            return response()->json(['success'=>true,'new_password'=>$request->password],200);
        }catch (\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()],404);
        }

    }
}
