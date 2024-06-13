<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
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
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        $post = Post::create($validated);
        return response()->json(['success' => true, 'data' => $post], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Not typically used in API controllers.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        $post->update($validated);

        if ($request->hasFile('image')) {
            if ($post->image) {
                FacadesStorage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('post_images', 'public');
        }

        $post->save();

        return response()->json([
            'success' => true,
            'data' => $post,
            'msg' => 'Post updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            FacadesStorage::disk('public')->delete($post->image);
        }
        $post->delete();

        return response()->json(['success' => true]);
    }
}
