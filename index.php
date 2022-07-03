<?php
require_once './api.php';

$status = '';
$api = new API();
$api->init();

// Проверяем авторизован ли пользователь
if($_COOKIE['auth'] !== null){
	$api->checkAuth();
}

// Если отправили запрос на авторизацию
if($_POST['postAuth'] !== NULL){
	$status = $api->auth($_POST['login'], $_POST['password']);
}
?>

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
	<div class="container">
		<div class="signin">
			<form action="" class="signin__form" method="post">
			<h1 class="signin__title">Авторизация</h1>
			<span><?= $status ?></span>
			<input class="signin__input" name="login" type="text" value="" placeholder="Логин">
			<input class="signin__input" name="password" type="password" value="" placeholder="Пароль">
			<input class="signin__submit" type="submit" value="Отправить" name="postAuth">
		</form>
		</div>
	</div>
</body>

</html>