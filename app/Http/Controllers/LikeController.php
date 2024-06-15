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
        return response()->json(['success' => true, 'data' => LikeResource::collection(Like::all())], 200);
    }
    /**
     * @OA\Get(
     *     path="/api/likes/my-likes",
     *     tags={"Personal Likes"},
     *     summary="Personal Likes",
     *     description="Personal Likes",
     *     operationId="personal likes",
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
    public function myLikes()
    {
        $uid = Auth::id();
        try {
            $likes = Like::where('user_id', $uid)->get();
            if (count($likes) == 0) {
                return response()->json(['success' => true, 'message' => 'No Likes Yet'], 200);
            }
            return response()->json(['success' => true, 'data' => LikeResource::collection($likes)], 200);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
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
    /**
     * @OA\Post(
     *     path="/api/likes/create",
     *     tags={"Add new Like"},
     *     summary="Add new Like",
     *     description="Add new Like",
     *     operationId="add new like",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"post_id","react_id"},
     *                  @OA\Property(property="post_id",type="integer"),
     *                  @OA\Property(property="react_id",type="integer"),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="successful add like",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function store(StoreLikeRequest $request)
    {
        $uid = Auth::id();
        $data = $request->validated();
        $data['user_id'] = $uid;
        try {
            $like = Like::create($data);
            return response()->json(['success' => true, 'message' => 'Liked Successfully', 'data' => $like], 201);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
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

    /**
     * @OA\Put(
     *     path="/api/likes/update/{like}",
     *     tags={"Update reactions"},
     *     summary="Update reactions",
     *     description="Update reactions",
     *     operationId="update reactions",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *          name="like",
     *          in="path",
     *          description="ID of the like to update",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"post_id","react_id"},
     *                  @OA\Property(property="post_id",type="integer"),
     *                  @OA\Property(property="react_id",type="integer"),
     *              ),
     *          ),
     *     ),
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
    public function update(UpdateLikeRequest $request, Like $like)
    {
        $uid = Auth::user()->id;
        $data = $request->validated();
        $data['user_id'] = $uid;
        try {
            if ($like->user_id == $uid) {
                $like->update($data);
                return response()->json(['success' => true, 'message' => 'Liked Successfully', 'data' => $like], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Something Went Wrong'], 500);
            }
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *     path="/api/likes/delete/{like}",
     *     tags={"Delete reactions"},
     *     summary="Delete reactions",
     *     description="Delete reactions",
     *     operationId="delete reactions",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *          name="like",
     *          in="path",
     *          description="ID of the like to delete",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
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
    public function destroy(Like $like)
    {
        $user_id = Auth::id();
        try {
            if ($like->user_id == $user_id) {
                $like->delete();
                return response()->json(['success' => true, 'message' => 'Liked Successfully', 'data' => $like], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Something Went Wrong'], 500);
            }
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }
}
