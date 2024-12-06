<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PhoneSubmission;

class PhoneController extends Controller
{
    public function submit(Request $request)
    {
        // Валидация данных формы
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^\+?[0-9]{7,15}$/',
        ]);

        // Получение данных
        $name = $request->input('name');
        $phone = $request->input('phone');

        // Отправка почты администратору
        Mail::to('straus97@mail.ru')->send(new PhoneSubmission($name, $phone));

        // Возврат успешного сообщения
        return back()->with('success', 'Заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.');
    }
}
