<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

// Asosiy sahifa uchun route
Route::get('/', function () {
    return view('welcome'); // Yoki o'zingizning asosiy sahifangiz
});

// Faylni yuklash va konvertatsiya qilish uchun route (POST so‘rovi)
Route::post('upload-file', [FileController::class, 'uploadFile'])->name('upload.file');

// Faylni yuklab olish uchun route (GET so‘rovi)
Route::get('download/{filename}', [FileController::class, 'downloadFile'])->name('download.file');
