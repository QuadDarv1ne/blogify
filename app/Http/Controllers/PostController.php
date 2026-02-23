<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index(Request $request)
    {
        $posts = $this->postService->getPublished($request->get('per_page', 12));
        return view('posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = $this->postService->getBySlug($slug);
        
        if (!$post) {
            abort(404);
        }

        return view('posts.show', compact('post'));
    }
}
