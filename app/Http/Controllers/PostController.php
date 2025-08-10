<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Gets all blog posts from all users.
     * Called by `/api/posts`.
     */
    public function index()
    {
        return PostResource::collection(Post::paginate(5));
    }

    /**
     * Show the form for creating a new blog post.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created blog post in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified blog post.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified blog post.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified blog post in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified blog post from storage.
     */
    public function destroy(Post $post)
    {
        //
    }

    /**
     * Lists users and the total number of blog posts they've written.
     */
    public function rank()
    {
        return DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.author_id')
            ->select('users.name', DB::raw('count(posts.id) as posts'))
            ->groupBy('users.id')
            ->orderByDesc('posts')
            ->get();
    }
}
