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
    <!-- Bootstrap CSS (jsDelivr CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Bootstrap Bundle JS (jsDelivr CDN) -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
                    if($userTests !== null){
                    foreach($userTests as $test){
                        ?>
                            <li>Дата: <?= $test['date'] ?> Результат:  <?= $test['score'] ?></li>
                        <?php
                    }
                    } else {
                        echo "<span>Ученик не прошел ни одного теста</span>";
                    }
                ?>
            </ul>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>