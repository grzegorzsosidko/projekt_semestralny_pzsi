<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocCategory;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentsController extends Controller
{
    public function index()
    {
        $documents = Document::with(['category', 'user', 'files'])->latest()->get();
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = DocCategory::all();
        return view('admin.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'doc_category_id' => 'required|exists:doc_categories,id',
            'attachments' => 'required|array|min:1|max:5',
            'attachments.*' => 'file|max:10240'
        ]);

        $document = Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'doc_category_id' => $request->doc_category_id,
            'user_id' => Auth::id(), // <-- Tutaj używamy Auth
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $sanitizedTitle = Str::slug($document->title) . '_' . Str::random(5);
                $path = $file->storeAs('documents', $sanitizedTitle . '.' . $file->extension(), 'public');

                $document->files()->create([
                    'original_name' => $originalName, 'stored_name' => basename($path), 'path' => $path
                ]);
            }
        }
        return redirect()->route('admin.documents.index')->with('status', 'Dokument został pomyślnie dodany.');
    }

    public function edit(Document $document)
    {
        $categories = DocCategory::all();
        $document->load('files'); // Upewnij się, że pliki są załadowane
        return view('admin.documents.edit', compact('document', 'categories'));
    }

    /**
     * Aktualizuje dokument w bazie danych.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'doc_category_id' => 'required|exists:doc_categories,id',
            'attachments.*' => 'file|max:10240',
            'delete_files' => 'nullable|array',
            'delete_files.*' => 'integer|exists:document_files,id',
        ]);

        // Aktualizuj podstawowe dane dokumentu
        $document->update($request->only('title', 'description', 'doc_category_id'));

        // Usuń zaznaczone załączniki
        if ($request->has('delete_files')) {
            foreach ($request->delete_files as $fileId) {
                $file = DocumentFile::find($fileId);
                if ($file && $file->document_id === $document->id) {
                    Storage::disk('public')->delete($file->path);
                    $file->delete();
                }
            }
        }

        // Dodaj nowe załączniki, jeśli zostały przesłane
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $sanitizedTitle = Str::slug($document->title);
                $storedName = $sanitizedTitle . '_' . Str::random(5) . '.' . $extension;
                $path = $file->storeAs('documents', $storedName, 'public');

                $document->files()->create([
                    'original_name' => $originalName,
                    'stored_name' => $storedName,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.documents.index')->with('status', 'Dokument został zaktualizowany.');
    }

    /**
     * Zmienia status dokumentu (opublikowany/ukryty).
     */
     public function toggleStatus(Document $document)
    {
        $document->status = ($document->status === 'published') ? 'hidden' : 'published';
        $document->save();
        $statusMessage = ($document->status === 'published') ? 'Dokument został opublikowany.' : 'Dokument został ukryty.';
        return back()->with('status', $statusMessage);
    }

    /**
     * Usuwa dokument wraz z jego załącznikami.
     */
     public function destroy(Document $document)
    {
        foreach ($document->files as $file) {
            Storage::disk('public')->delete($file->path);
        }
        $document->delete();
        return back()->with('status', 'Dokument został trwale usunięty.');
    }


    public function getAttachments(Document $document)
    {
        $files = $document->files->map(function ($file) {
            return [
                'name' => $file->original_name,
                'url' => Storage::url($file->path) // Generuje publiczny URL
            ];
        });

        return response()->json([
            'title' => $document->title,
            'files' => $files
        ]);
    }

    public function exportCsv()
    {
        $documents = Document::with(['category', 'user'])->get();
        $fileName = 'dokumenty_'.date('Y-m-d').'.csv';

        $headers = array(
            "Content-type"        => "text/csv; charset=utf-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = ['ID', 'Tytuł', 'Kategoria', 'Dodał', 'Status', 'Data dodania'];

        $callback = function() use($documents, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // Dodaj BOM dla UTF-8
            fputcsv($file, $columns);

            foreach ($documents as $doc) {
                $row['ID']              = $doc->id;
                $row['Tytuł']           = $doc->title;
                $row['Kategoria']       = $doc->category->name;
                $row['Dodał']           = $doc->user->name;
                $row['Status']          = $doc->status;
                $row['Data dodania']    = $doc->created_at->format('Y-m-d');

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
