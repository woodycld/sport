<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormSubmitted;
use App\Mail\UserConfirmation;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'messages' => 'required|string|max:5000',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $messages = $request->input('messages');

        // Проверяем данные
        if (!is_string($name) || !is_string($email) || !is_string($messages)) {
            throw new \Exception('Некорректные данные.');
        }

        // Отправка писем
        Mail::to('straus97@mail.ru')->send(new ContactFormSubmitted($name, $email, $messages));
        Mail::to($email)->send(new UserConfirmation($name));

        return back()->with('success', 'Ваше сообщение отправлено!');
    }

}
