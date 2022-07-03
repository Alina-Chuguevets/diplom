<?php
include_once './functions.php';
require_once './api.php';

$db = new dbAPI();
$api = new API();
$db->init();
$api->init();

// Список вопросов
$listQuestions = [
    'Вы испытываете эйфорию, хорошее настроение когда играете в компьютерные игры?',
    'В последнее время требуется все больше и больше времени, чтобы достичь этого состояния?',
    'У вас случается чувство опустошенности, дурное настроение или раздражительность, когда вы не можете поиграть за компьютером?',
    'У вас есть боли в запястьях?',
    'Вы пропускали встречу с кем-либо из-за того, что были заняты компьютерными играми (несрочные дела)?',
    'Вы проводите 3 часа и более в день в Интернете?',
    'Вы заходите на чаты, просматриваете сайты, не касающиеся вашей основной деятельности за компьютером?',
    'Играя, вы пропускали прием пищи (завтрак, обед или ужин)?',
    'Вам легче общаться с людьми через Интернет, нежели лицом к лицу?',
    'Ваши друзья или родственники говорили вам, что вы невероятное количество часов сидите в Интернете или за компьютерными играми?',
    'Вы регулярно загружаете какие-либо развлекательные материалы из Интернета?',
    'Вы отмечаете ухудшение в учебе или уменьшение знаний по основной работе?',
    'У вас были неудачные попытки ограничить время работы за компьютером?',
    'Вы ощущаете онемение в мизинце во время работы за компьютером?',
    'Вы говорили другим, что проводите за компьютерными играми немного времени, хотя это не так?',
    'Вы отмечаете регулярные боли в спине (чаще чем 1 раз в неделю)?',
    'В последнее время вас беспокоит сухость глаз?',
    'В последнее время у вас было сильное желание играть?',
    'Для того чтобы больше побыть в Интернете, вы прекращали мыться, чистить зубы или бриться?',
    'С того времени, как вы используете Интернет или играете в компьютерные игры, у вас появились нарушения сна: долгое засыпание, бессонница, беспокойный сон?',
];

// Парамерты текущего пользователя
$userParams = $db->getUserConfigByToken($_COOKIE['auth']);
$isOpenTest = $userParams['isopentest'];

// Если отправили тест
if($_POST['postTest'] !== NULL){
    $score = 0;
    for($i = 0; $i < count($listQuestions); $i++){
        $score += $_POST['answer' . $i];
    }
    $api->postTest($userParams['id'], $score);
    $isOpenTest = 0;
}

// Деавторизация
if($_POST['signOut'] !== null){
    setcookie('auth', '');   
    header('Location: ./index.php');
}

if($userParams['type'] !== '0'){
    die('Нет доступа к этой странице');
};

if ($_COOKIE['auth'] !== $userParams['token']) {
    header('Location: ./index.php');
};


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
                Тестирование
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
                <a class="btn btn-primary" href="./student_testing.php">Тестирование</a>
                <a class="btn btn-outline-primary" href="./student_score.php">Результат тестирования</a>
            </div>
        </div>

        <div style="margin-top: 45px;">
            <p class="blockquote">
                Возможные значения полей <mark> от 0 до 10 </mark>
            </p>
        </div>
        <hr>
        <?php
        if ($isOpenTest) {
            $countQuestions = 0;
            foreach ($listQuestions as $question) {
            ?>
                <form id="questionsForm" action="./student_testing.php" method="post">
                    <div class="questionRow">
                        <div style="font-size: 1.1em;">
                            <?= $question ?>
                        </div>
                        <input type="number" name="answer<?= $countQuestions++ ?>" value="0" min="0" max="10" style="text-align: center;">
                    </div>
                    <hr>
                    <?php } ?>
                    <input class="btn btn-primary" type="submit" name="postTest" value="Отправить тест" style="margin-top: 15px; margin-bottom: 30px;">
                </form>
            <?php
        } else {
        ?>
            <p>
                Прохождение теста в данный момент заблокированно
            </p>
        <?php
        }
        ?>
    </div>

    <script src="script.js"></script>
</body>

</html>