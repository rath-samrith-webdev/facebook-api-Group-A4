<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ReplyResource::collection(Reply::all());
    }

    public function myReplies()
    {
        $uid=Auth::id();
        try{
            $replies=Reply::where('user_id',$uid)->get();
            return response()->json(['success'=>true,'data'=>ReplyResource::collection($replies)]);
        }catch (\Exception $e){
            return response()->json(['success'=>false,'error'=>['message'=>$e->getMessage()]],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReplyRequest $request)
    {
        $uid=Auth::id();
        $data=$request->validated();
        $data['user_id']=$uid;
        try {
            $reply=Reply::create($data);
            return response()->json(['success'=>true,'message'=>'Reply added','data'=>ReplyResource::make($reply)],201);
        }catch (\Exception $exception){
            return response()->json(['success'=>false,'message'=>$exception->getMessage()],422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReplyRequest $request, Reply $reply)
    {
        $user_id=Auth::id();
        $data=$request->validated();
        $data['user_id']=$user_id;
        if($reply->user_id==$user_id){
            $reply->update($data);
            return  response()->json(['success'=>true,'message'=>'Reply updated','data'=>ReplyResource::make($reply)],201);
        }else {
            return response()->json(['success'=>false,'message'=>'You cannot edit this reply.'],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reply $reply)
    {
        $user_id=Auth::id();
        if($reply->user_id==$user_id){
            $reply->delete();
            return  response()->json(['success'=>true,'message'=>'Reply updated','data'=>ReplyResource::make($reply)],201);
        }else {
            return response()->json(['success'=>false,'message'=>'You cannot remove this reply.'],422);
        }
    }
}
