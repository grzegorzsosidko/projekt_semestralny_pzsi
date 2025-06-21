<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_hidden', false)
            ->with('user')
            ->withCount('comments')
            ->latest()
            ->paginate(10);

        $latestPosts = Post::where('is_hidden', false)->latest()->take(5)->get();
        
        return view('pages.news', compact('posts', 'latestPosts'));
    }

    public function show(Post $post)
    {
        if ($post->is_hidden && (Auth::guest() || auth()->user()->role !== 'administrator')) {
            abort(404);
        }

        $post->increment('views_count');

        $latestPosts = Post::where('is_hidden', false)->where('id', '!=', $post->id)->latest()->take(5)->get();
        
        // Ta linia jest kluczowa - ładuje wszystkie poziomy komentarzy i ich autorów
        $post->load(['comments.user', 'comments.replies.user', 'comments.replies.replies']);

        return view('news.show', compact('post', 'latestPosts'));
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|min:2|max:2000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('status', 'Komentarz został pomyślnie dodany.');
    }
}