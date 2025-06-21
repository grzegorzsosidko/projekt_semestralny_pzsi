<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsController as PublicNewsController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\KnowledgeBaseController;
use App\Http\Controllers\Admin\DocumentsController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');

// ===============================================
// Grupa tras, które wymagają zalogowania (dla wszystkich userów)
// ===============================================
Route::middleware('auth')->group(function () {
    // --- SEKCJA AKTUALNOŚCI (PUBLICZNA) ---
    // PONIŻEJ ZNAJDUJE SIĘ KLUCZOWA POPRAWKA. Zmieniamy nazwę z 'news.index' na 'news'
    Route::get('/aktualnosci', [PublicNewsController::class, 'index'])->name('news');
    Route::get('/aktualnosci/{post:slug}', [PublicNewsController::class, 'show'])->name('news.show');
    Route::post('/aktualnosci/{post}/comments', [PublicNewsController::class, 'storeComment'])->name('comments.store');

    // --- Pozostałe publiczne podstrony ---
    Route::get('/galeria', [PageController::class, 'gallery'])->name('gallery');
    Route::get('/baza-wiedzy', [PageController::class, 'knowledge'])->name('knowledge');
    Route::get('/dokumenty', [PageController::class, 'documents'])->name('documents');
    Route::get('/ksiazka-telefoniczna', [PageController::class, 'phoneBook'])->name('phonebook');
    Route::get('/ksiazka-telefoniczna/export', [PageController::class, 'exportPhoneBookCsv'])->name('phonebook.export');
    Route::get('/kontakt', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/kontakt', [ContactController::class, 'store'])->name('contact.store');

    // --- SEKCJA PROFILU UŻYTKOWNIKA ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::post('/profile/cover', [ProfileController::class, 'updateCover'])->name('profile.cover.update');
    Route::patch('/profile/contact', [ProfileController::class, 'updateContact'])->name('profile.contact.update');
    Route::patch('/profile/details', [ProfileController::class, 'updateDetails'])->name('profile.details.update');

    Route::get('/search', [SearchController::class, 'handle'])->name('global.search');

});

// ===============================================
// Grupa tras tylko dla ADMINISTRATORA
// ===============================================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::post('/news/{news}/toggle-status', [AdminNewsController::class, 'toggleStatus'])->name('news.toggle-status');
        Route::resource('news', AdminNewsController::class)->except(['show']);

        Route::patch('/galleries/{gallery}/toggle-status', [GalleryController::class, 'toggleStatus'])->name('gallery.toggle-status');
        Route::resource('galleries', GalleryController::class)
            ->except(['show'])
            ->names('gallery');

        Route::patch('/knowledge/{faq}/toggle-status', [KnowledgeBaseController::class, 'toggleStatus'])->name('knowledge.toggle-status');
        Route::resource('knowledge', KnowledgeBaseController::class)
            ->parameters(['knowledge' => 'faq'])
            ->names('knowledge');

        Route::patch('/documents/{document}/toggle-status', [DocumentsController::class, 'toggleStatus'])->name('documents.toggle-status');
        Route::get('/documents/{document}/attachments', [DocumentsController::class, 'getAttachments'])->name('documents.attachments');
        Route::get('/documents/export', [DocumentsController::class, 'exportCsv'])->name('documents.export');
        Route::resource('documents', DocumentsController::class)->except(['show']);

        Route::patch('/users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('users.toggle-block');
        Route::get('/users/export', [UserController::class, 'exportCsv'])->name('users.export');
        Route::resource('users', UserController::class)->except(['show']);
    });

require __DIR__ . '/auth.php';
