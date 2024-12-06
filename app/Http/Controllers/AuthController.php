<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; // Импортируем фасад Mail
use App\Mail\UserRegistered;
use App\Models\User;

class AuthController extends Controller
{
    // Логика для входа
    public function login(Request $request)
    {
        // Валидация входных данных
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Попытка авторизации
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.trainings'); // Перенаправляем на маршрут 'dashboard'
        }

        // Если данные неверны
        return back()->withErrors([
            'email' => 'Неверные учетные данные.',
        ]);
    }

    // Логика для регистрации
    public function register(Request $request)
    {
        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Создание пользователя
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Отправка информационного письма
        Mail::to($user->email)->send(new \App\Mail\UserRegistered($user, $request->input('password')));

        // Перенаправление на страницу входа
        return redirect()->route('auth')->with('success', 'Регистрация прошла успешно! Проверьте свою почту.');
    }
}
