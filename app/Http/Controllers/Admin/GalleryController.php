<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with(['user', 'images'])->latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:65',
            'description' => 'required|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120' // 5MB na plik
        ]);

        $gallery = Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('images')) {
            $this->uploadImages($request->file('images'), $gallery);
        }

        return response()->json(['success' => true, 'redirect_url' => route('admin.gallery.index')]);
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load('images');
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:65',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:gallery_images,id'
        ]);

        $gallery->update($request->only('title', 'description'));

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = GalleryImage::find($imageId);
                if ($image && $image->gallery_id === $gallery->id) {
                    Storage::disk('public')->delete([$image->path, $image->thumbnail_path]);
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('images')) {
            $this->uploadImages($request->file('images'), $gallery);
        }

        return redirect()->route('admin.gallery.index')->with('status', 'Galeria została pomyślnie zaktualizowana.');
    }

    public function destroy(Gallery $gallery)
    {
        foreach ($gallery->images as $image) {
            Storage::disk('public')->delete([$image->path, $image->thumbnail_path]);
        }
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('status', 'Galeria została usunięta.');
    }

    public function toggleStatus(Gallery $gallery)
    {
        $gallery->is_hidden = !$gallery->is_hidden;
        $gallery->save();
        $statusMessage = $gallery->is_hidden ? 'Galeria została ukryta.' : 'Galeria została opublikowana.';
        return redirect()->route('admin.gallery.index')->with('status', $statusMessage);
    }

    protected function uploadImages(array $files, Gallery $gallery)
    {
        foreach ($files as $file) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $randomName = Str::random(20) . '_' . time();

            $fullSizePath = 'gallery/' . $randomName . '.webp';
            Storage::disk('public')->put($fullSizePath, (string) $image->scale(width: 1920)->toWebp(85));

            $thumbnailPath = 'gallery/thumbnails/' . $randomName . '.webp';
            Storage::disk('public')->put($thumbnailPath, (string) $image->cover(400, 400)->toWebp(75));

            $gallery->images()->create([
                'path' => $fullSizePath,
                'thumbnail_path' => $thumbnailPath,
            ]);
        }
    }
}
