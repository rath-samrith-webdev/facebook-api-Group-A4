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
