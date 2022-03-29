<?php
include_once './functions.php';

$db = new dbAPI();
$db->init();

$userParams = $db->getUserConfigByToken($_COOKIE['auth']);

if($_POST['signOut'] !== null){
    setcookie('auth', '');   
    header('Location: ./index.php');
};

if($userParams['type'] !== '0'){
    die('Нет доступа к этой странице');
};

if ($_COOKIE['auth'] !== $userParams['token']) {
    header('Location: ./index.php');
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
    <!-- Bootstrap CSS (jsDelivr CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Bootstrap Bundle JS (jsDelivr CDN) -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">
               Результат тестирования
        </a>
        <form class="form-inline my-2 my-lg-0" action="./student_testing.php" method="post">
            <span class="text-light" style="margin-right: 10px;"><?= $userParams['name'] ?>(<?= $userParams['class'] ?>)</span>
            <input class="btn btn-outline-light" type="submit" name="signOut" value="Выход">
        </form>
    </div>
</nav>
    <div class="container">
        <div>
            <div class="buttonsBlock">
                <a class="btn btn-outline-primary" href="./student_testing.php">Тестирование</a>
                <a class="btn btn-primary" href="./student_score.php">Результат тестирования</a>
            </div>
        </div>
        <div>
        </div>
        <div class="results-list">
            <?php 
            if($listScoreTesting !== null){
            foreach ($listScoreTesting as $test) {
                $testCorrectClass = $test['score'] > 50 ? 'btn-success' : 'btn-warning' ?>
                <div class="result">
                    <div class="result-date"><?= substr($test['date'], 0, 4)."-".substr($test['date'], 4, 2)."-".substr($test['date'], 6, 2); ?></div>
                    <div class="result-score <?= $testCorrectClass ?>"><?= $test['score'] / 2 ?>%</div>
                </div>
                <hr>
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