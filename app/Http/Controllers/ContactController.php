<?php

namespace App\Http\Controllers;

use App\Models\ContactCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;

class ContactController extends Controller
{
    public function create()
    {
        $categories = ContactCategory::orderBy('name')->get();
        return view('pages.contact', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:contact_categories,id',
            'message' => 'required|string|min:35',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:2048' // max 2MB na plik
        ]);

        $category = ContactCategory::find($validated['category_id']);
        $attachments = $request->hasFile('attachments') ? $request->file('attachments') : [];

        // Adresy, na które wysyłamy maila
        $recipients = ['g.sosidko@sii.com.pl'];

        Mail::to($recipients)->send(new ContactFormSubmitted(
            auth()->user(),
            $category->name,
            $validated['message'],
            $attachments
        ));

        return back()->with('status', 'Dziękujemy! Twoje zgłoszenie zostało wysłane.');
    }
}
