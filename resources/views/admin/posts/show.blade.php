@extends('admin.layouts.app')

@section('title', $post->title)

@section('content')
<div class="flex justify-between items-start mb-6">
    <h1 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.posts.edit', $post) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Edit</a>
        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex items-center gap-4 mb-6">
        <span class="px-3 py-1 text-sm rounded-full {{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
            {{ $post->is_published ? 'Published' : 'Draft' }}
        </span>
        @if($post->category)
            <span class="px-3 py-1 text-sm rounded-full bg-indigo-100 text-indigo-700">
                {{ $post->category->name }}
            </span>
        @endif
    </div>

    <div class="prose max-w-none">
        {!! nl2br(e($post->content)) !!}
    </div>

    @if($post->tags->count() > 0)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex gap-2">
                @foreach($post->tags as $tag)
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">#{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
    @endif
</div>

<div class="mt-4">
    <a href="{{ route('admin.posts.index') }}" class="text-indigo-600 hover:text-indigo-700">← Back to Posts</a>
</div>
@endsection
