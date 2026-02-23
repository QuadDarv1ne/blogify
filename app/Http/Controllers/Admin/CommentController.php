<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService
    ) {}

    public function index(Request $request)
    {
        $comments = Comment::with(['post', 'user'])
            ->when($request->status, function ($query) use ($request) {
                $query->where('is_approved', $request->status === 'approved');
            })
            ->latest()
            ->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Request $request, Comment $comment)
    {
        $this->commentService->approve($comment);
        return back()->with('success', 'Comment approved.');
    }

    public function destroy(Comment $comment)
    {
        $this->commentService->delete($comment);
        return back()->with('success', 'Comment deleted.');
    }
}
