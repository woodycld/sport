@extends('dashboard')

@section('dashboard-content')
    <h2>Тренировки</h2>

    @if($parameters)
        <p><strong>Ваши текущие параметры:</strong></p>
        <ul style="list-style-type: none; padding: 0;">
            <li><strong>Пол:</strong> {{ $parameters->gender == 'male' ? 'Мужчина' : 'Женщина' }}</li>
            <li><strong>Рост:</strong> {{ $parameters->height }} см</li>
            <li><strong>Текущий вес:</strong> {{ $parameters->current_weight }} кг</li>
            <li><strong>Желаемый вес:</strong> {{ $parameters->desired_weight }} кг</li>
            <li><strong>Возраст:</strong> {{ $parameters->age }} лет</li>
            <li><strong>Тренировки в неделю:</strong> {{ $parameters->weekly_trainings }}</li>
        </ul>

        <form method="POST" action="{{ route('dashboard.generateWorkoutPlan') }}">
            @csrf
            <button class="btn btn-primary">Сгенерировать план тренировок</button>
        </form>

        @if($workoutPlan)  <!-- Проверяем наличие плана тренировок -->
        <h3>Ваш план тренировок:</h3>
        @foreach(json_decode($workoutPlan->data, true) as $day => $exercises)
            <h4>{{ $day }}</h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Упражнение</th>
                    <th>Подходы</th>
                    <th>Повторы</th>
                    <th>Вес</th>
                    <th>Время</th>
                </tr>
                </thead>
                <tbody>
                @foreach($exercises as $exercise)
                    <tr>
                        <td>{{ $exercise['name'] }}</td>
                        <td>{{ $exercise['sets'] }}</td>
                        <td>{{ $exercise['reps'] }}</td>
                        <td>{{ $exercise['weight'] ? $exercise['weight'] . ' кг' : 'Собственный вес' }}</td>
                        <td>{{ $exercise['time'] }} мин</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach
        @else
            <p>У вас нет плана тренировок. Нажмите кнопку выше, чтобы сгенерировать новый план.</p>
        @endif
    @else
        <p>Вы не указали параметры. Пожалуйста, перейдите в <a href="{{ route('dashboard.parameters') }}">раздел "Параметры"</a>.</p>
    @endif
@endsection
