<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Aktualizuje awatar użytkownika - WERSJA OSTATECZNA
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate(['avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120']);
        $user = $request->user();

        // Usuń stary awatar, jeśli istnieje
        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $path = $this->processProfileImage($request->file('avatar'), 'avatars', 300, true);
        
        $user->avatar_path = $path;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'Awatar został pomyślnie zaktualizowany.');
    }

    /**
     * Aktualizuje zdjęcie w tle użytkownika - WERSJA OSTATECZNA
     */
    public function updateCover(Request $request): RedirectResponse
    {
        $request->validate(['cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192']);
        $user = $request->user();

        if ($user->cover_photo_path) {
            Storage::disk('public')->delete($user->cover_photo_path);
        }

        $path = $this->processProfileImage($request->file('cover'), 'covers', 1920, false);
        
        $user->cover_photo_path = $path;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'Zdjęcie w tle zostało zaktualizowane.');
    }

    /**
     * Funkcja pomocnicza do przetwarzania obrazów profilowych.
     */
    private function processProfileImage($file, string $directory, int $width, bool $cropToSquare = false)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);
        
        $filename = $directory . '/' . Str::random(25) . '.' . $file->getClientOriginalExtension();
        
        if ($cropToSquare) {
            $image->cover($width, $width); // Przytnij do kwadratu
        } else {
            if ($image->width() > $width) {
                $image->scale(width: $width); // Tylko przeskaluj szerokość
            }
        }
        
        $encodedImage = $image->encode();
        Storage::disk('public')->put($filename, $encodedImage);
        
        return $filename;
    }
    
    // Pozostałe metody (updateContact, updateDetails) bez zmian
    public function updateContact(Request $request)
    {
        $user = $request->user();
        $user->fill($request->validate(['email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)], 'phone_number' => ['nullable', 'string', 'max:20'],]));
        if ($user->isDirty('email')) $user->email_verified_at = null;
        $user->save();
        return Redirect::route('profile.edit')->with('status', 'Informacje kontaktowe zaktualizowane.');
    }

    public function updateDetails(Request $request)
    {
         $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'interests' => ['nullable', 'string'],
            'social_links.linkedin' => ['nullable', 'url'],
            'social_links.facebook' => ['nullable', 'url'],
            'social_links.instagram' => ['nullable', 'url'],
        ]);
        $request->user()->update($validated);
        return Redirect::route('profile.edit')->with('status', 'Szczegóły profilu zaktualizowane.');
    }
}
