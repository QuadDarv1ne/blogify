<?php

namespace App\Http\Controllers;

use App\Services\PostService;

class HomeController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index()
    {
        $posts = $this->postService->getPublished(6);
        return view('welcome', compact('posts'));
    }
}
