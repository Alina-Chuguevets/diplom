<?php
// $dataCookie = 'test'
// if  ($_COOKIE['auth'] !== $dataCookie){
//     die('Авторизуйтесь на <a href="./auth.php">сайте</a>')
// }

$status = $_POST['status'];

// Эти данные берутся из бд
$listScoreTesting = [
    '1' => 15,
    '2' => 25,
    '3' => 35,
]
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
    </header>
    <div class="container">
        <div class="headline">
            <span class="info">Иванов Иван(5Б)</span>
        </div>
        <div class="results-list">
            <? foreach ($listScoreTesting as $date => $score) {
                $testCorrectClass = $score > 25 ? 'result-score-success' : 'result-score-false' ?>
                <div class="result">
                    <div class="result-date"><?= $date ?></div>
                    <div class="result-score <?= $testCorrectClass ?>"><?= $score ?>%</div>
                </div>
            <? } ?>
        </div>
    </div>
</body>

</html>