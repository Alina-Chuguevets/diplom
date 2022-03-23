<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Авторизация</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<header class="header"></header>
	<div class="container">
		<h3>Авторизуйтесь</h3>
		<form action="" class="authorize-form">
			<input class="authorize-field" type="text" value="" placeholder="Логин">
			<input class="authorize-field" type="password" value="" placeholder="Пароль">
			<input name="usertype" type="radio" class="radiobtn" value="Ученик">Ученик
			<input name="usertype" type="radio" class="radiobtn" value="Учитель">Учитель
			<input class="button button-submit" type="submit" value="Отправить">

		</form>
	</div>
</body>

</html>