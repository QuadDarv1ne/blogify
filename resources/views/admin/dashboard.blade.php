@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="text-sm font-medium text-gray-500">Total Posts</div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['posts'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="text-sm font-medium text-gray-500">Published</div>
            <div class="text-3xl font-bold text-green-600">{{ $stats['published_posts'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="text-sm font-medium text-gray-500">Total Comments</div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['comments'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="text-sm font-medium text-gray-500">Pending</div>
            <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending_comments'] }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Posts -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Posts</h2>
            @if($recentPosts->count() > 0)
                <div class="space-y-4">
                    @foreach($recentPosts as $post)
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <div>
                                <a href="{{ route('admin.posts.show', $post) }}" class="font-medium text-gray-900 hover:text-indigo-600">
                                    {{ $post->title }}
                                </a>
                                <div class="text-sm text-gray-500">
                                    {{ $post->user?->name }} · {{ $post->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $post->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No posts yet.</p>
            @endif
        </div>

        <!-- Recent Comments -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Comments</h2>
            @if($recentComments->count() > 0)
                <div class="space-y-4">
                    @foreach($recentComments as $comment)
                        <div class="border-b border-gray-100 pb-3">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-medium text-gray-900">{{ $comment->author_name }}</span>
                                <span class="px-2 py-1 text-xs rounded-full {{ $comment->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $comment->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $comment->content }}</p>
                            <div class="text-xs text-gray-500 mt-1">
                                on <a href="{{ route('posts.show', $comment->post?->slug) }}" class="hover:text-indigo-600">{{ $comment->post?->title }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No comments yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
