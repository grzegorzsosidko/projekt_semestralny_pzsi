<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KnowledgeBaseController extends Controller
{
    /**
     * Wyświetla główny widok zarządzania z listą pytań.
     */
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.knowledge.index', compact('faqs'));
    }

    /**
     * Zapisuje nowe pytanie w bazie danych.
     */
    public function store(Request $request)
    {
    $validated = $request->validate([
    'question' => 'required|string|min:10',
    'answer' => 'required|string|min:10',
    ]);

    // Łączymy zwalidowane dane z ID autora
    $data = array_merge($validated, ['user_id' => Auth::id()]);

    $faq = Faq::create($data);

    return response()->json(['success' => true, 'faq' => $faq]);
    }
    /**
     * Aktualizuje istniejące pytanie.
     */
    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|min:10',
            'answer' => 'required|string|min:10',
        ]);

        $faq->update($validated);

        return response()->json(['success' => true, 'faq' => $faq]);
    }

    /**
     * Zmienia status widoczności pytania.
     */
    public function toggleStatus(Faq $faq)
    {
        $faq->is_hidden = !$faq->is_hidden;
        $faq->save();

        return response()->json(['success' => true, 'is_hidden' => $faq->is_hidden]);
    }

    /**
     * Pobiera dane pojedynczego pytania.
     */
    public function show(Faq $faq)
    {
        return response()->json($faq);
    }
}
