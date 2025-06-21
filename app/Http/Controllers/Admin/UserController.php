<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Wyświetla listę wszystkich użytkowników.
     */
    public function index(): View
    {
        $users = User::latest()->get(); // Pobieramy posortowanych od najnowszych
        return view('admin.users.index', compact('users'));
    }

    /**
     * Wyświetla formularz do tworzenia nowego użytkownika.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Zapisuje nowego użytkownika w bazie danych.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'title' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:user,administrator'],
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'title' => $request->title,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Użytkownik został pomyślnie utworzony.');
    }

    /**
     * Wyświetla formularz do edycji istniejącego użytkownika.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Aktualizuje dane użytkownika w bazie danych.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'title' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:user,administrator'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $userData = $request->except('password');

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('status', 'Dane użytkownika zostały zaktualizowane.');
    }

    /**
     * Blokuje lub odblokowuje użytkownika.
     */
    public function toggleBlock(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'Nie możesz zablokować samego siebie.']);
        }

        $user->blocked_at = $user->blocked_at ? null : now();
        $user->save();

        $statusMessage = $user->blocked_at ? 'Użytkownik został zablokowany.' : 'Użytkownik został odblokowany.';

        return back()->with('status', $statusMessage);
    }

    /**
     * Eksportuje listę użytkowników do pliku CSV.
     */
    public function exportCsv()
    {
        $users = User::all();
        $fileName = 'uzytkownicy_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['ID', 'Imię i Nazwisko', 'Nazwa użytkownika', 'Email', 'Telefon', 'Stanowisko', 'Rola', 'Data utworzenia'];

        $callback = function () use ($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $user) {
                $row['ID'] = $user->id;
                $row['Imię i Nazwisko'] = $user->name;
                $row['Nazwa użytkownika'] = $user->username;
                $row['Email'] = $user->email;
                $row['Telefon'] = $user->phone_number;
                $row['Stanowisko'] = $user->title;
                $row['Rola'] = $user->role;
                $row['Data utworzenia'] = $user->created_at;

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Usuwa użytkownika z bazy danych.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'Nie możesz usunąć samego siebie.']);
        }

        // Można dodać logikę usuwania awatara/zdjęć w tle
        // if ($user->avatar_path) { Storage::disk('public')->delete($user->avatar_path); }
        // if ($user->cover_photo_path) { Storage::disk('public')->delete($user->cover_photo_path); }

        $user->delete();

        return back()->with('status', 'Użytkownik został usunięty.');
    }
}
