<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать в Спортивный дневник!</title>
</head>
<body>
<h1>Добро пожаловать в Спортивный дневник!</h1>
<p>Здравствуйте, {{ $name }}!</p>
<p>Вы успешно зарегистрировались. Вот ваши данные для входа:</p>
<ul>
    <li><strong>Email:</strong> {{ $email }}</li>
    <li><strong>Пароль:</strong> {{ $password }}</li>
</ul>
<p>Мы рады видеть вас в нашем сообществе!</p>
</body>
</html>
