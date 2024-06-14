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
    /**
     * @OA\Get(
     *     path="/api/replies/my-replies",
     *     tags={"Show User's Replies"},
     *     summary="Show User's Replies",
     *     description="Show User's Replies",
     *     operationId="show user's Replies",
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
    /**
     * @OA\Post(
     *     path="/api/replies/create",
     *     tags={"Add new Replies"},
     *     summary="Add new Replies",
     *     description="Add new Replies",
     *     operationId="add new replies",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"text","comment_id"},
     *                  @OA\Property(property="text",type="text"),
     *                  @OA\Property(property="comment_id",type="integer"),
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

    /**
     * @OA\Put(
     *     path="/api/replies/update/{reply}",
     *     tags={"Update User Replies"},
     *     summary="Update User Replies",
     *     description="Update User Replies",
     *     operationId="update user replies",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *            name="comment",
     *            in="path",
     *            description="ID of the reply to update",
     *            required=true,
     *            @OA\Schema(
     *                type="integer",
     *                format="int64"
     *            )
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"text"},
     *                  @OA\Property(property="text",type="text"),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful updated Replies",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
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
    /**
     * @OA\Delete(
     *     path="/api/replies/delete/{reply}",
     *     tags={"Delete User Replies"},
     *     summary="Delete User Replies",
     *     description="Delete User Replies",
     *     operationId="delete user replies",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *           name="comment",
     *           in="path",
     *           description="ID of the replies to delete",
     *           required=true,
     *           @OA\Schema(
     *               type="integer",
     *               format="int64"
     *           )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful Deleted Replies",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
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
