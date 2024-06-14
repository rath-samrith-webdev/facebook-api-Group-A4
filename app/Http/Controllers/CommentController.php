<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $comments=Comment::all();
            return response()->json(['success' => true, 'comments' => CommentResource::collection($comments)],200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Comment is not found'], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/comments/my-comments",
     *     tags={"Show User's Comments"},
     *     summary="Show User's Comments",
     *     description="Show User's Comments",
     *     operationId="show user's comments",
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

    public function myComments(): JsonResponse
    {
        $uid=Auth::id();
        try {
            $comments=Comment::where('user_id',$uid)->get();
            return response()->json(['success' => true, 'comments' => CommentResource::collection($comments)],200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Comment is not found'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\Post(
     *     path="/api/comments/create",
     *     tags={"Add new Comment"},
     *     summary="Add new Comment",
     *     description="Add new Comment",
     *     operationId="add new comment",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"text","post_id"},
     *                  @OA\Property(property="text",type="text"),
     *                  @OA\Property(property="post_id",type="integer"),
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
    public function store(StoreCommentRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $validatedData['user_id'] = Auth::id();
            $comment = Comment::create($validatedData);
            return response()->json(['success'=>true,'data'=>CommentResource::make($comment)], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Comment is not found'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): JsonResponse
    {
        try {
            return response()->json(['success' => true, 'comment' => new CommentResource($comment)],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comment is not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *     path="/api/comments/update/{comment}",
     *     tags={"Update User Comment"},
     *     summary="Update User Comment",
     *     description="Update User Comment",
     *     operationId="update user comment",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *            name="comment",
     *            in="path",
     *            description="ID of the comment to delete",
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
    public function update(UpdateCommentRequest $request, Comment $comment): JsonResponse
    {
        $user=Auth::user();
        try {
            if($comment->user_id==$user->id){
                $validatedData = $request->validated();
                $validatedData['user_id'] = Auth::id();
                $comment->update($validatedData);
                return response()->json(['success'=>true,'data'=>CommentResource::make($comment)],200);
            }else{
                return response()->json(['error'=>'You cannot edit this comment'],403);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comment is not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/comments/delete/{comment}",
     *     tags={"Delete User Comment"},
     *     summary="Delete User Comment",
     *     description="Delete User Comment",
     *     operationId="delete user comment",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *           name="comment",
     *           in="path",
     *           description="ID of the comment to delete",
     *           required=true,
     *           @OA\Schema(
     *               type="integer",
     *               format="int64"
     *           )
     *     ),
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
    public function destroy(Comment $comment): JsonResponse
    {
        try {
            $comment->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comment is not found'], 404);
        }
    }
}
