<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Gets all blog posts from all users.
     * Called by `/api/posts`.
     */
    public function index()
    {
        return Post::all();
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
        return $post;
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
}
