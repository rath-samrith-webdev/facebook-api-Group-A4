<?php

namespace App\Http\Controllers;

use App\Http\Resources\FriendListResource;
use App\Models\FriendList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['success' => true, 'data' => FriendListResource::collection(FriendList::all())], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $uid = Auth::id();
        $data = $request->all();
        $data['user_id'] = $uid;
        try {
            $friend = FriendList::create($data);
            return response()->json(['success' => true, 'data' => FriendListResource::make($friend)], 201);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'data' => $exception->getMessage()], 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(FriendList $friendList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FriendList $friendList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *     path="/api/friends/unfriend/{friendList}",
     *     tags={"Unfriends"},
     *     summary="Unfriend from user",
     *     description="Unfriend from user",
     *     operationId="Unfriend from user",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *          name="friendrequest",
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
    public function destroy(FriendList $friendList)
    {
        $uid = Auth::id();
        try {
            if ($friendList->user_id == $uid) {
                $friendList->delete();
                return response()->json(['success' => true, 'data' => FriendListResource::collection(FriendList::all())], 200);
            } else {
                return response()->json(['success' => false, 'data' => 'You are not authorized to delete this list', 'd' => $friendList], 403);
            }
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'data' => $exception->getMessage()], 400);
        }
    }
}
