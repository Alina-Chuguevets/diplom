<?php
include_once './functions.php';

$db = new dbAPI();
$db->init();

$userParams = $db->getUserConfigByToken($_COOKIE['auth']);

if($_POST['signOut'] !== null){
    setcookie('auth', '');   
    die('Авторизуйтесь на <a href="./index.php">сайте</a>');
};

if($userParams['type'] !== '0'){
    die('Нет доступа к этой странице');
};

if ($_COOKIE['auth'] !== $userParams['token']) {
    die('Авторизуйтесь на <a href="./index.php">сайте</a>');
};
$status = $_POST['status'];

$listScoreTesting = $db->getDataTest($userParams['id']);


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
            Результаты тестирования
        </span>
        <form action="./student_score.php" method="post">
            <input type="submit" name="signOut" value="Выход">
        </form>
    </header>
    <div class="container">
    <div class="headline">
            <span class="info"><?= $userParams['name'] ?>(<?= $userParams['class'] ?>)</span>
        </div>
        <div>
            <div class="buttonsBlock">
                <a class="button button-active" href="./student_testing.php">Тестирование</a>
                <a class="button" href="./student_score.php">Результат тестирования</a>
            </div>
        </div>
        <div class="results-list">
            <?php 
            if($listScoreTesting !== null){
            foreach ($listScoreTesting as $test) {
                $testCorrectClass = $test['score'] > 25 ? 'result-score-success' : 'result-score-false' ?>
                <div class="result">
                    <div class="result-date"><?= $test['date'] ?></div>
                    <div class="result-score <?= $testCorrectClass ?>"><?= $test['score'] ?>%</div>
                </div>
            <? }
            } else {
                ?>
                    <span>Результатов нет</span>
                <?php
            } ?>
        </div>
    </div>
</body>

</html>