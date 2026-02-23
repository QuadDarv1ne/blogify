@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Post Header -->
    <article class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($post->featured_image)
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
        @endif

        <div class="p-8">
            <!-- Categories -->
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($post->categories as $category)
                    <a href="{{ route('posts.category', $category) }}" class="inline-block px-3 py-1 text-sm font-semibold rounded-full" style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Title -->
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

            <!-- Meta -->
            <div class="flex items-center text-gray-600 mb-6 pb-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold mr-3">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">{{ $post->user->name }}</div>
                        <div class="text-sm">
                            {{ $post->published_at->format('M d, Y') }} · {{ $post->reading_time }} min read · {{ $post->views_count }} views
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="prose prose-lg max-w-none mb-8">
                {!! nl2br(e($post->content)) !!}
            </div>

            <!-- Tags -->
            @if($post->tags->count() > 0)
                <div class="flex flex-wrap gap-2 pt-6 border-t border-gray-200">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('posts.tag', $tag) }}" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </article>

    <!-- Comments Section -->
    <div class="bg-white rounded-lg shadow-sm p-8 mt-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            Comments ({{ $post->approvedComments->count() }})
        </h2>

        <!-- Comment Form -->
        @auth
            <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8">
                @csrf
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Leave a comment</label>
                    <textarea name="content" id="content" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required></textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Post Comment
                </button>
            </form>
        @else
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                <p class="text-gray-600">
                    Please <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">login</a> to leave a comment.
                </p>
            </div>
        @endauth

        <!-- Comments List -->
        <div class="space-y-6">
            @forelse($post->approvedComments->where('parent_id', null) as $comment)
                <div class="border-l-4 border-indigo-500 pl-4">
                    <div class="flex items-start mb-2">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold mr-3">
                            {{ substr($comment->user->name ?? $comment->author_name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">
                                {{ $comment->user->name ?? $comment->author_name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $comment->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 ml-13">{{ $comment->content }}</p>

                    <!-- Replies -->
                    @if($comment->replies->count() > 0)
                        <div class="ml-13 mt-4 space-y-4">
                            @foreach($comment->replies as $reply)
                                <div class="border-l-2 border-gray-300 pl-4">
                                    <div class="flex items-start mb-2">
                                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold text-sm mr-2">
                                            {{ substr($reply->user->name ?? $reply->author_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900 text-sm">
                                                {{ $reply->user->name ?? $reply->author_name }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $reply->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-sm">{{ $reply->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No comments yet. Be the first to comment!</p>
            @endforelse
        </div>
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $related)
                    <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                        @if($related->featured_image)
                            <a href="{{ route('posts.show', $related) }}">
                                <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-48 object-cover">
                            </a>
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold mb-2">
                                <a href="{{ route('posts.show', $related) }}" class="text-gray-900 hover:text-indigo-600">
                                    {{ Str::limit($related->title, 60) }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-600">
                                {{ Str::limit($related->excerpt, 100) }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
