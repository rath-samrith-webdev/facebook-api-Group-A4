<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResource;
use App\Models\Like;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['success'=>true,'data'=>LikeResource::collection(Like::all())],200);
    }

    public function myLikes()
    {
        $uid=Auth::id();
        try {
            $likes=Like::where('user_id',$uid)->get();
            if(count($likes)==0){
                return response()->json(['success'=>true,'message'=>'No Likes Yet'],200);
            }
            return response()->json(['success'=>true,'data'=>$likes],200);
        }catch (\Exception $exception){
            return response()->json(['success'=>false,'message'=>$exception->getMessage()],500);
        }

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLikeRequest $request)
    {
        $uid=Auth::id();
        $data=$request->validated();
        $data['user_id']=$uid;
        try {
            $like=Like::create($data);
            return response()->json(['success'=>true,'message'=>'Liked Successfully','data'=>$like],201);
        }catch (\Exception $exception){
            return response()->json(['success'=>false,'message'=>$exception->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLikeRequest $request, Like $like)
    {
        $uid=Auth::user()->id;
        $data=$request->validated();
        $data['user_id']=$uid;
        try {
            if($like->user_id == $uid){
                $like->update($data);
                return response()->json(['success'=>true,'message'=>'Liked Successfully','data'=>$like],200);
            }else{
                return response()->json(['success'=>false,'message'=>'Something Went Wrong'],500);
            }
        }catch (\Exception $exception){
            return response()->json(['success'=>false,'message'=>$exception->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        $user_id=Auth::id();
        try {
            if($like->user_id == $user_id){
                $like->delete();
                return response()->json(['success'=>true,'message'=>'Liked Successfully','data'=>$like],200);
            }else{
                return response()->json(['success'=>false,'message'=>'Something Went Wrong'],500);
            }
        }catch (\Exception $exception){
            return response()->json(['success'=>false,'message'=>$exception->getMessage()],500);
        }
    }
}
