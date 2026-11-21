<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::latest();

        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        return view('board', [
            'posts' => $query->get(),
            'currentCategory' => $request->category ?? 'All',
            'searchQuery' => $request->search ?? '',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:Kuppi,Notes,Coding Help,Lost & Found',
            'tags' => 'nullable|string|max:255',
        ]);

        // Gemini 2.5 Flash API call
        $validated['ai_summary'] = GeminiService::generateKuppiHelp(
            $validated['category'],
            $validated['title'],
            $validated['content']
        );

        Post::create($validated);

        return redirect()->route('board.index');
    }

    public function toggleStatus(Post $post)
    {
        $post->update([
            'status' => $post->status === 'Open' ? 'Resolved' : 'Open'
        ]);

        return redirect()->route('board.index');
    }
}