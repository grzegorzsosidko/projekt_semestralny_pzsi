<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->withCount('comments')->latest()->get();
        return view('admin.news.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:70',
            'slug' => 'required|string|unique:posts,slug|alpha_dash',
            'intro_text' => 'required|string',
            'subheading' => 'required|string',
            'cover_image' => 'required|image|max:8192',
            'content_1' => 'required|string',
            'content_2' => 'nullable|string',
            'content_3' => 'nullable|string',
            'image_1' => 'nullable|image|max:5120',
            'image_2' => 'nullable|image|max:5120',
        ]);

        try {
            // Krok 1: Przygotowujemy tablicę TYLKO z polami, które pasują do kolumn w bazie
            $postData = [
                'user_id' => Auth::id(),
                'title' => $validatedData['title'],
                'slug' => $validatedData['slug'],
                'intro_text' => $validatedData['intro_text'],
                'subheading' => $validatedData['subheading'],
                'content_1' => $validatedData['content_1'],
                'content_2' => $validatedData['content_2'],
                'content_3' => $validatedData['content_3'],
            ];

            // Krok 2: Przetwarzamy pliki i dodajemy do tablicy TYLKO ścieżki pod poprawnymi kluczami
            if ($request->hasFile('cover_image')) {
                $postData['cover_image_path'] = $this->processImage($request->file('cover_image'), 'cover');
            }
            if ($request->hasFile('image_1')) {
                $postData['image_1_path'] = $this->processImage($request->file('image_1'), 'img1');
            }
            if ($request->hasFile('image_2')) {
                $postData['image_2_path'] = $this->processImage($request->file('image_2'), 'img2');
            }

            // Krok 3: Tworzymy post z idealnie przygotowanymi danymi
            Post::create($postData);

            return response()->json(['success' => true, 'redirect_url' => route('admin.news.index')]);
        } catch (\Exception $e) {
            Log::error('Błąd krytyczny podczas tworzenia posta: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Wystąpił błąd serwera. Sprawdź logi.'], 500);
        }
    }

    public function edit(Post $news)
    {
        return view('admin.news.edit', ['post' => $news]);
    }

    public function update(Request $request, Post $news)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:70',
            'slug' => ['required', 'string', 'alpha_dash', Rule::unique('posts')->ignore($news->id)],
            'intro_text' => 'required|string',
            'subheading' => 'required|string',
            'content_1' => 'required|string',
            'content_2' => 'nullable|string',
            'content_3' => 'nullable|string',
            'cover_image' => 'nullable|image|max:8192',
            'image_1' => 'nullable|image|max:5120',
            'image_2' => 'nullable|image|max:5120',
        ]);

        try {
            $updateData = $validatedData;

            // Przetwarzaj i podmieniaj zdjęcia tylko jeśli wgrano nowe pliki
            if ($request->hasFile('cover_image')) {
                if ($news->cover_image_path) {
                    Storage::disk('public')->delete($news->cover_image_path);
                }
                $updateData['cover_image_path'] = $this->processImage($request->file('cover_image'), 'cover');
            }
            if ($request->hasFile('image_1')) {
                if ($news->image_1_path) {
                    Storage::disk('public')->delete($news->image_1_path);
                }
                $updateData['image_1_path'] = $this->processImage($request->file('image_1'), 'img1');
            }
            if ($request->hasFile('image_2')) {
                if ($news->image_2_path) {
                    Storage::disk('public')->delete($news->image_2_path);
                }
                $updateData['image_2_path'] = $this->processImage($request->file('image_2'), 'img2');
            }

            $news->update($updateData);
            return redirect()->route('admin.news.index')->with('status', 'Artykuł został pomyślnie zaktualizowany.');
        } catch (\Exception $e) {
            Log::error('Błąd aktualizacji posta: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'Wystąpił błąd podczas aktualizacji.'])
                ->withInput();
        }
    }

    public function destroy(Post $news)
    {
        $pathsToDelete = array_filter([$news->cover_image_path, $news->image_1_path, $news->image_2_path]);
        if (count($pathsToDelete) > 0) {
            Storage::disk('public')->delete($pathsToDelete);
        }
        $news->delete();
        return redirect()->route('admin.news.index')->with('status', 'Artykuł został usunięty.');
    }

    public function toggleStatus(Post $news)
    {
        $news->is_hidden = !$news->is_hidden;
        $news->save();
        $status = $news->is_hidden ? 'ukryty' : 'opublikowany';
        return redirect()
            ->route('admin.news.index')
            ->with('status', "Status artykułu zmieniono na: {$status}.");
    }

    private function processImage($file, $suffix = 'img')
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        $randomStr = Str::random(11);
        $date = now()->format('dmY');
        $extension = $file->getClientOriginalExtension();
        $filename = "{$randomStr}_{$date}_{$suffix}.{$extension}";
        $path = "news/{$filename}";

        if ($image->width() > 1920) {
            $image->scale(width: 1920);
        }

        $encodedImage = $image->encode();
        Storage::disk('public')->put($path, $encodedImage);
        return $path;
    }
}
