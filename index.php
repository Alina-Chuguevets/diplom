<?php
include_once './functions.php';

$db = new dbAPI();
$db->init();

$status = '';

if($_COOKIE['auth'] !== null){
	$user = $db->getUserConfigByToken($_COOKIE['auth']);
	if($user == NULL){
		die('Ошибка токена');
	}
	if($user['type'] == 0){
		header('Location: ./student_testing.php');
	} else {
		header('Location: ./main_setting.php');
	}
	die();
}

// Если отправили запрос на авторизацию
if($_POST['postAuth'] !== NULL){
    $user = $db->getUserConfig($_POST['login'], $_POST['password']);
	if($user == NULL){
		$status = "Ошибка авторизации";
	}
	else {
		$token = base64_encode($_POST['password']);
		$db->createToken($user['id'], $token);
		setcookie('auth', $token);
		if($user['type'] == 0){
			header('Location: ./student_testing.php');
		} else {
			header('Location: ./main_setting.php');
		}
		die();
	}
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
	<header class="header"></header>
	<div class="container">
		<h3>Авторизуйтесь</h3>
		<span><?= $status ?></span>
		<form action="" class="authorize-form" method="post">
			<input class="authorize-field" name="login" type="text" value="" placeholder="Логин">
			<input class="authorize-field" name="password" type="password" value="" placeholder="Пароль">
			<input class="button button-submit" type="submit" value="Отправить" name="postAuth">
		</form>
	</div>
</body>

</html>