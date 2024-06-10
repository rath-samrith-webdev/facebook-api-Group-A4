<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegiterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return response()->json(['success' => true, 'data' => $user, 'token' => $token], 200);
    }
    public function logout(LoginRequest $request){
        $user = Auth::user();
        $user->tokens()->delete();
        auth()->guard('web')->logout();
        return response()->json(['success' => true]);
    }
    public function register(RegiterRequest $request){
        $newUser=$request->validated();
        try {
            $user=User::create($newUser);
            return response()->json(['success' => true,'message'=>'New user have been created','data'=>$user],201);
        }catch (\Exception $e){
            return response()->json(['success'=>false,'message' => 'User Registration Failed!','error'=>$e], 500);
        }
    }
    public function remove(Request $request)
    {
        $user=Auth::user();
        $user->delete();
        return response()->json(['success' => true,'data'=>$user],200);
    }
    public function update(Request $request){
        $user=Auth::user();
        $user->update($request->all());
        return response()->json(['success' => true,'data'=>$user],200);
    }
}
