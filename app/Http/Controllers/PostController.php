<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $posts = Post::all();
        return response()->json(['success' => true, 'posts' => PostResource::collection($posts)], 200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not typically used in API controllers.
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/posts/create",
     *     tags={"Post"},
     *     summary="Create Post",
     *     description="Create Post",
     *     operationId="create post",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"text","image[]"},
     *                  @OA\Property(property="text",type="text"),
     *                  @OA\Property(property="image[]",type="file"),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="successful created post",
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
        $images = $request->image ? $request->image : null;
        try {
            $post = Post::create([
                'text' => $request->text,
                'user_id' => Auth::id()
            ]);
            $post_id = $post->id;
            foreach ($images as $image) {
                $imgName = rand() . '.' . $image->getClientOriginalExtension();
                Image::create([
                    'image_name' => $imgName,
                    'post_id' => $post_id
                ]);
                $image->move(public_path('/') . 'upload/user-' . Auth::id() . '/posts/post-' . $post->id, $imgName);
            }
            return response()->json(['success' => true, 'post' => PostResource::make($post)], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/posts/my-posts",
     *     tags={"Posts"},
     *     summary="Personal Posts",
     *     description="Show Users's Posts",
     *     operationId="show user posts",
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
    public function myPosts(): JsonResponse
    {
        $uid = Auth::id();
        $posts = Post::where('user_id', $uid)->get();
        if ($posts->count() > 0) {
            return response()->json(['success' => true, 'data' => PostResource::collection($posts)], 200);
        } else {
            return response()->json(['success' => false, 'data' => []], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *     path="/api/posts/update/{post}",
     *     tags={"Post"},
     *     summary="Update Post Posts",
     *     description="Update Users's Posts",
     *     operationId="update user posts",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *          name="post",
     *          in="path",
     *          description="ID of the post to update",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"text"},
     *                  @OA\Property(property="text",type="string"),
     *              ),
     *          ),
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
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $validated = $request->validated();
        $uid = Auth::id();
        $validated['user_id'] = $uid;
        try {
            if ($post->user_id == $uid) {
                $post->update($validated);
                return response()->json(['success' => true, 'data' => $post], 200);
            } else {
                return response()->json(['success' => false, 'data' => 'You are not authorized'], 401);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *     path="/api/posts/delete/{post}",
     *     tags={"Post"},
     *     summary="Delete Post",
     *     description="Delete User's Posts",
     *     operationId="delete user posts",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *          name="post",
     *          in="path",
     *          description="ID of the post to delete",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful delete post",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function destroy(Post $post): JsonResponse
    {
        $uid = Auth::id();
        try {
            if ($post->user_id == $uid) {
                $post->delete();
                return response()->json(['success' => true, 'data' => $post], 200);
            } else {
                return response()->json(['success' => false, 'data' => 'You are not authorized'], 401);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
