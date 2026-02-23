<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService
    ) {}

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|min:3',
        ]);

        $data = array_merge($validated, [
            'post_id' => $post->id,
            'author_name' => Auth::user()->name,
            'author_email' => Auth::user()->email,
            'user_id' => Auth::id(),
        ]);

        $this->commentService->create($data);

        return back()->with('success', 'Comment submitted for moderation.');
    }
}
