<?php
include_once './functions.php';

$db = new dbAPI();
$db->init();

$userParams = $db->getUserConfigByToken($_COOKIE['auth']);

// Роли:
// 0 - ученик
// 1 - психолог

if($userParams['type'] !== '1'){
    die('Нет доступа к этой странице');
};


if($_POST['signOut'] !== null){
    setcookie('auth', '');   
    die('Авторизуйтесь на <a href="./index.php">сайте</a>');
}

if ($_COOKIE['auth'] !== $userParams['token']) {
    die('Авторизуйтесь на <a href="./index.php">сайте</a>');
};

if ($_GET['user'] == null){
    die('Не указан пользователь');
}

$userId = $_GET['user'];

$userInfo = $db->getUserInfo($userId);
$userTests = $db->getDataTest($userId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header id="header" class="header">
        <span class="page-info">
            Результат тестирования
        </span>
        <form action="./main_score.php" method="post">
            <input type="submit" name="signOut" value="Выход">
        </form>
    </header>
    <div class="container">
        <div class="headline">
    
        </div>
        <div>
            <div class="buttonsBlock">
                <a class="button" href="./main_setting.php">Настройки тестирования</a>
            </div>
        </div>
        <hr>
        <br><br>
        <div>
            <h3>Результаты тестирования ученика <?= $userInfo['name'] ?>(<?= $userInfo['class'] ?>)</h3>
        </div>
        <div>
             <ul>
                <?php
                    foreach($userTests as $test){
                        ?>
                            <li>Дата: <?= $test['date'] ?> Результат:  <?= $test['score'] ?></li>
                        <?php
                    }
                ?>
            </ul>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>