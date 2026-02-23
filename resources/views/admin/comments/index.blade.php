@extends('admin.layouts.app')

@section('title', 'Comments')

@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-6">Comments</h1>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Post</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comment</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($comments as $comment)
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-gray-900 font-medium">{{ $comment->author_name }}</div>
                        <div class="text-sm text-gray-500">{{ $comment->author_email }}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        <a href="{{ route('posts.show', $comment->post?->slug) }}" target="_blank" class="hover:text-indigo-600">
                            {{ $comment->post?->title ?? 'Deleted' }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-gray-600 max-w-xs">
                        <p class="truncate">{{ $comment->content }}</p>
                        <div class="text-xs text-gray-400 mt-1">{{ $comment->created_at->format('M d, Y H:i') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $comment->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $comment->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if(!$comment->is_approved)
                            <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Approve</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No comments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $comments->links() }}
</div>
@endsection
