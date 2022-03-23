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