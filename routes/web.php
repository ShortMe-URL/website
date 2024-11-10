<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShortUrlController;
use App\Models\Clicks;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $linksCount = Link::count();
    $clicksCount = Clicks::count();
    $usersCount = User::count();
    return view('welcome', compact('linksCount', 'clicksCount', 'usersCount'));
});

Route::post('/shortURL', [ShortUrlController::class, 'store'])->name('shorturl.short');
Route::get('/o/{shortpath}', [ShortUrlController::class, 'click'])->name('shorturl.click');



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
