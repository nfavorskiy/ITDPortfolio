<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

Route::get('/', function () {
    return view('home');
});

Route::post('/check-name-availability', function (Request $request) {
    $name = (string) $request->input('name'); // Force to string
    
    // Additional validation to ensure we have a valid name
    if (empty(trim($name))) {
        return response()->json(['available' => true]);
    }
    
    $exists = User::where('name', $name)->exists();
    
    return response()->json([
        'available' => !$exists
    ]);
})->name('check.name.availability');

// Only authenticated users can access these routes
Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
