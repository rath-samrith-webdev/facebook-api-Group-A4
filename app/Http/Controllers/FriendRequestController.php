<?php

namespace App\Http\Controllers;

use App\Http\Resources\FriendRequestResource;
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
        return response()->json(FriendRequestResource::collection(FriendRequest::all()));
    }
    /**
     * @OA\Get(
     *     path="/api/friends/request/my-friend-request",
     *     tags={"Personal Friend Request"},
     *     summary="Personal Friend Request",
     *     description="Personal Friend Request",
     *     operationId="personal friend request",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function myFriendRequest()
    {
        $uid = Auth::id();
        try {
            $requests=FriendRequest::where('request_to',$uid)->get();
            if ($requests->count() > 0) {
                return response()->json(['success'=>true,'data'=>FriendRequestResource::collection($requests)],200);
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

    /**
     * @OA\Post(
     *     path="/api/friends/request/add",
     *     tags={"Add new Friend Request"},
     *     summary="Add new Friend Request",
     *     description="Add new Friend Request",
     *     operationId="add new friend request",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"request_to"},
     *                  @OA\Property(property="text",type="integer"),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="successful created comment",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
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
        return FriendRequestResource::make($friendRequest);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *     path="/api/friends/request/confirm/{friendrequest}",
     *     tags={"Confirm new Friend Request"},
     *     summary="Confirm new Friend Request",
     *     description="Confirm new Friend Request",
     *     operationId="confirm new friend request",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=201,
     *         description="successful confirm friend request",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function confirm(FriendRequest $friendRequest)
    {
        $uid=Auth::id();
        try {
            if($friendRequest->request_to==$uid && $friendRequest->status=='pending'){
                $friendRequest->update(['status'=>'accepted']);
                $confirm=FriendList::create(
                    ['user_id'=>$uid,'friend_id'=>$friendRequest->request_from]
                );
                $friendRequest->delete();
                return response()->json(['status'=>'success','message'=>'Friend request has been confirmed','data'=>FriendRequestResource::make($confirm)],200);
            }else{
                return response()->json(['status'=>'error','message'=>'You cannot confirm this request'],200);
            }
        }catch (\Exception $exception){
            return response()->json(['status'=>'error','message'=>$exception->getMessage()],400);
        }
    }
    /**
     * @OA\Put(
     *     path="/api/friends/request/decline/{friendrequest}",
     *     tags={"Decline Friend Request"},
     *     summary="Decline Friend Request",
     *     description="Decline Friend Request",
     *     operationId="decline friend request",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=201,
     *         description="successful decline friend request",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/friends/unfriend/{friends}",
     *     tags={"Unfriend A User"},
     *     summary="Unfriend a user",
     *     description="Unfriend A User",
     *     operationId="unfriend a user",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=201,
     *         description="successful cancel friend request",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
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
