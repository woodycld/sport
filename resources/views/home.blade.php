@extends('layouts.app')

@section('title', 'Главная')

@section('content')

    <!-- Информация о сайте с оффером на покупку доступа -->
    <div class="container my-5">
        <div class="row align-items-center">
            <!-- Картинка слева -->
            <div class="col-md-4">
                <img src="{{ asset('images/offer.png') }}" alt="Спортивный дневник" class="img-fluid rounded" >
            </div>

            <!-- Текст справа -->
            <div class="col-md-8">
                <h1>Добро пожаловать в Спортивный дневник!</h1>
                <p class="lead">Записывайте ваши тренировки, отслеживайте результаты, улучшайте питание и достигайте целей с нашим удобным спортивным дневником.</p>
                <p>Наш дневник позволяет вести учет всех тренировок, следить за прогрессом, корректировать питание и поддерживать мотивацию на высоком уровне. Будь то похудение, набор массы или улучшение выносливости — у нас есть всё, чтобы помочь вам достичь ваших целей!</p>
                <p><strong>Оформите доступ и начните свой путь к здоровью и фитнесу прямо сейчас!</strong></p>
                <button class="btn btn-primary btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#phoneModal">Оформить доступ</button>
            </div>

            <!-- Модальное окно -->
            <div class="modal fade" id="phoneModal" tabindex="-1" aria-labelledby="phoneModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="phoneModalLabel">Для быстрой связи оставьте свой номер телефона</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                        </div>
                        <div class="modal-body">
                            <form id="phoneForm" action="{{ route('phone.submit') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Ваше имя</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Номер телефона</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" pattern="\+?[0-9]{7,15}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Оставить заявку</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Таблица с преимуществами -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Преимущества нашего спортивного дневника</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Удобный интерфейс</h5>
                        <p class="card-text">Наш дневник прост в использовании, интуитивно понятен и доступен на всех устройствах.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Персонализированные планы</h5>
                        <p class="card-text">Получите индивидуальные рекомендации по тренировкам и питанию в зависимости от ваших целей.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Анализ прогресса</h5>
                        <p class="card-text">Легко отслеживайте результаты и корректируйте свои планы, чтобы достичь максимального эффекта.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок с контактной информацией и формой обратной связи -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Свяжитесь с нами</h2>
        <p class="text-center">Если у вас есть вопросы или предложения, не стесняйтесь обращаться! Мы всегда на связи.</p>
        <form action="{{ route('contact.send') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">Ваше имя</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Ваш email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="messages">Ваше сообщение</label>
                    <textarea class="form-control" id="messages" name="messages" rows="4" required></textarea>
                </div>
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Отправить сообщение</button>
                </div>
            </div>
        </form>
    </div>

@endsection
