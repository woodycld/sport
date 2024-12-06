<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhoneController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NutritionController;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

//Отправка формы обратной связи
Route::post('/contact/send', [ContactController::class, 'sendMessage'])->name('contact.send');

//Отправка заявки с главной страницы
Route::post('/phone/submit', [PhoneController::class, 'submit'])->name('phone.submit');

// Маршрут для отображения страницы авторизации и регистрации
Route::get('/auth', function () {
    return view('auth');
})->name('auth');

// Маршрут для входа
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Маршрут для регистрации
Route::post('/register', [AuthController::class, 'register'])->name('register');

//выход после авторизации
Route::post('/logout', function (Request $request) {
    Auth::logout(); // Завершаем авторизацию
    $request->session()->invalidate(); // Удаляем текущую сессию
    $request->session()->regenerateToken(); // Генерируем новый CSRF-токен

    return redirect()->route('home'); // Перенаправляем на главную страницу
})->name('logout');

// Личный кабинет
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard.trainings'); // Перенаправление на Тренировки
    })->name('dashboard');

    Route::get('/trainings', [DashboardController::class, 'trainings'])->name('dashboard.trainings');
    Route::post('/dashboard/trainings/generate', [DashboardController::class, 'generateWorkoutPlan'])->name('dashboard.generateWorkoutPlan');

    //питание
    Route::get('/dashboard/nutrition', [DashboardController::class, 'nutrition'])->name('dashboard.nutrition');
    Route::post('/dashboard/nutrition/generate', [NutritionController::class, 'generate'])->name('dashboard.nutrition.generate');
    Route::post('/dashboard/nutrition/update', [NutritionController::class, 'update'])->name('dashboard.nutrition.update');

    //параметры тела
    Route::get('/parameters', [DashboardController::class, 'parameters'])->name('dashboard.parameters');
    Route::post('/parameters', [DashboardController::class, 'storeParameters'])->name('dashboard.parameters.store');

    //настройки в лк
    Route::get('/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
    Route::post('/settings/update-name', [DashboardController::class, 'updateName'])->name('settings.update-name');
    Route::post('/settings/update-password', [DashboardController::class, 'updatePassword'])->name('settings.update-password');
});
