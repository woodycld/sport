@extends('dashboard')

@section('dashboard-content')
    <h2>Питание</h2>

    @if($parameters)
        <p><strong>Ваши текущие параметры:</strong></p>
        <ul style="list-style-type: none; padding: 0;">
            <li><strong>Пол:</strong> {{ $parameters->gender == 'male' ? 'Мужчина' : 'Женщина' }}</li>
            <li><strong>Рост:</strong> {{ $parameters->height }} см</li>
            <li><strong>Текущий вес:</strong> {{ $parameters->current_weight }} кг</li>
            <li><strong>Желаемый вес:</strong> {{ $parameters->desired_weight }} кг</li>
            <li><strong>Возраст:</strong> {{ $parameters->age }} лет</li>
            <li><strong>Цель:</strong>
                @if($parameters->goal == 'lose_fat')
                    Похудеть (убрать жир)
                @elseif($parameters->goal == 'maintain')
                    Поддерживать форму
                @elseif($parameters->goal == 'gain_muscle')
                    Набрать мышечную массу
                @endif
            </li>
        </ul>

        @if($menu)
            <p><strong>Ваш текущий план питания:</strong></p>
            <table class="table">
                <thead>
                <tr>
                    <th>День</th>
                    <th>Прием пищи</th>
                    <th>Блюдо</th>
                    <th>Порция</th>
                    <th>Калории</th>
                </tr>
                </thead>
                <tbody>
                @foreach(json_decode($menu->data, true) as $day => $meals)
                    @foreach($meals as $meal => $details)
                        <tr>
                            <td>{{ $day }}</td>
                            <td>
                                @switch($meal)
                                    @case('breakfast') Завтрак @break
                                    @case('lunch') Обед @break
                                    @case('dinner') Ужин @break
                                    @default {{ $meal }}
                                @endswitch
                            </td>
                            <td>{{ $details['name'] }}</td>
                            <td>{{ $details['portion'] }}</td>
                            <td>{{ number_format($details['calories'], 2, '.', '') }} ккал</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
            <form method="POST" action="{{ route('dashboard.nutrition.update') }}">
                @csrf
                <button class="btn btn-warning">Обновить план питания</button>
            </form>
        @else
            <form method="POST" action="{{ route('dashboard.nutrition.generate') }}">
                @csrf
                <button class="btn btn-primary">Сгенерировать план питания</button>
            </form>
        @endif
    @else
        <p>Пожалуйста, заполните <a href="{{ route('dashboard.parameters') }}">параметры</a> для составления меню.</p>
    @endif
@endsection
