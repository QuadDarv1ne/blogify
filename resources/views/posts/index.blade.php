@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Latest Posts</h1>

    @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
                <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                    @if($post->image)
                        <a href="{{ route('posts.show', $post->slug) }}">
                            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                        </a>
                    @endif

                    <div class="p-6">
                        @if($post->category)
                            <div class="mb-3">
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-700">
                                    {{ $post->category->name }}
                                </span>
                            </div>
                        @endif

                        <h2 class="text-xl font-bold mb-2">
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-gray-900 hover:text-indigo-600">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <time>{{ $post->published_at?->format('M d, Y') }}</time>
                            <span class="mx-2">•</span>
                            <span>{{ $post->reading_time }} min read</span>
                        </div>

                        <p class="text-gray-600 mb-4">
                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}
                        </p>

                        @if($post->tags->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($post->tags as $tag)
                                    <span class="text-sm text-gray-500">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        <a href="{{ route('posts.show', $post->slug) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                            Read more →
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <p class="text-gray-500 text-lg">No posts found.</p>
        </div>
    @endif
</div>
@endsection
