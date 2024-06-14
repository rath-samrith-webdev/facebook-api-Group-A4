<?php

namespace App\Http\Controllers;

use App\Models\FriendList;
use App\Models\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FriendRequest::all();
    }

    public function myFriendRequest()
    {
        $uid = Auth::id();
        try {
            $requests=FriendRequest::where('request_to',$uid)->get();
            if ($requests->count() > 0) {
                return response()->json(['success'=>true,'data'=>$requests],200);
            }else{
                return response()->json(['success'=>false,'data'=>null],200);
            }
        }catch (\Exception $e){
            return response()->json(['success'=>false,'data'=>null,'message'=>$e->getMessage()],200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $uid = Auth::id();
        $data=$request->validate([
            'request_from'=>'exists:users,id',
            'request_to'=>'required|exists:users,id',
        ]);
        $request['request_from']=$uid;
        try{
            if($request->get('request_to')==$uid){
                return response()->json(['success'=>false ,'message'=>'You cannot sent request to yourself'],200);
            }else{
                FriendRequest::create([
                    'request_from'=>$uid,
                    'request_to'=>$data['request_to'],
                ]);
                return response()->json(['success'=>true,'data'=>$request->all()],200);
            }
        }catch(\Exception $e){
            return response()->json(['success'=>false,'error'=>$e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FriendRequest $friendRequest)
    {
        return $friendRequest;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FriendRequest $friendRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function confirm(Request $request, FriendRequest $friendRequest)
    {
        $uid=Auth::id();
        try {
            if($friendRequest->request_to==$uid && $friendRequest->status=='pending'){
                $friendRequest->update(['status'=>$request->get('status')]);
                FriendList::create(
                    ['user_id'=>$uid,'friend_id'=>$friendRequest->request_from]
                );
                $friendRequest->delete();
                return response()->json(['status'=>'success','message'=>'Friend request has been confirmed'],200);
            }else{
                return response()->json(['status'=>'error','message'=>'You cannot sent request to yourself'],200);
            }
        }catch (\Exception $exception){
            return response()->json(['status'=>'error','message'=>$exception->getMessage()],400);
        }
    }
    public function decline(FriendRequest $friendRequest)
    {
        $uid=Auth::id();
        try {
            if($friendRequest->request_to==$uid && $friendRequest->status=='pending'){
                $friendRequest->update(['status'=>'decline']);
                return response()->json(['status'=>'success','message'=>'Friend request has been declined'],200);
            }else{
                return response()->json(['status'=>'error','message'=>'Something went wrong'],400);
            }
        }catch (\Exception $exception){
            return response()->json(['status'=>'error','message'=>$exception->getMessage()],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FriendRequest $friendRequest)
    {
        $uid=Auth::id();
        try {
            if($friendRequest->request_from==$uid){
                $friendRequest->delete();
                return response()->json(['status'=>'success','message'=>'Friend request has been deleted'],200);
            }else{
                return response()->json(['status'=>'error','message'=>'You cannot delete this friend request'],400);
            }
        }catch (\Exception $exception){
            return response()->json(['status'=>'error','message'=>$exception->getMessage()],400);
        }
    }
}
