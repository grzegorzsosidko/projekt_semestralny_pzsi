<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Document;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function handle(Request $request)
    {
        $query = $request->input('q');

        if (!$query || strlen($query) < 3) {
            return response()->json([]);
        }

        $results = [];

        // 1. Wyszukaj w Aktualnościach (Postach) - rozszerzone o więcej pól
        $posts = Post::where('is_hidden', false)
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('intro_text', 'LIKE', "%{$query}%")
                  ->orWhere('subheading', 'LIKE', "%{$query}%");
            })
            ->take(5)->get();

        foreach ($posts as $post) {
            $results[] = [
                'title' => Str::limit($post->title, 50),
                'url' => route('news.show', $post->slug),
                'type' => 'Aktualność'
            ];
        }

        // 2. Wyszukaj w Dokumentach
        $documents = Document::where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->take(5)->get();
        
        foreach ($documents as $document) {
            $results[] = [
                'title' => Str::limit($document->title, 50),
                'url' => route('documents'),
                'type' => 'Dokument'
            ];
        }

        // 3. Wyszukaj w Bazie Wiedzy (FAQ)
        $faqs = Faq::where('is_hidden', false)
            ->where(function ($q) use ($query) {
                $q->where('question', 'LIKE', "%{$query}%")
                  ->orWhere('answer', 'LIKE', "%{$query}%");
            })
            ->take(5)->get();

        foreach ($faqs as $faq) {
            $results[] = [
                'title' => Str::limit($faq->question, 50),
                'url' => route('knowledge'),
                'type' => 'Baza Wiedzy'
            ];
        }
        
        // 4. Wyszukaj Użytkowników (np. w Książce telefonicznej)
        $users = User::whereNull('blocked_at')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('title', 'LIKE', "%{$query}%");
            })
            ->take(5)->get();

        foreach ($users as $user) {
            $results[] = [
                'title' => $user->name,
                'url' => route('phonebook'),
                'type' => 'Pracownik'
            ];
        }

        return response()->json($results);
    }
}
