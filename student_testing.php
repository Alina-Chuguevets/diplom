<?php
include_once './functions.php';

$db = new dbAPI();
$db->init();

$isOpenTest = $db->getStatusTest();
$userParams = $db->getUserConfig('login', 'password');

if($_COOKIE['auth'] !== $userParams['token']){
    die('Авторизуйтесь на <a href="./index.php">сайте</a>');
}; 

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
            Тестирование
        </span>
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
        <?php
        if($isOpenTest) {
            $countQuestions = 1;
            foreach ($listQuestions as $question) {
            ?>
                <div class="questionRow">
                    <div class="question">
                        <?= $question ?>
                    </div>
                    <input name="answer<?= $countQuestions ?>" form="questionsForm" class="answer answer-yes" type="radio" value="1">Да
                    <input name="answer<?= $countQuestions++ ?>" form="questionsForm" class="answer answer-no" type="radio" value="0">Нет
                </div>
<<<<<<< HEAD
                <input name="answer<?= $countQuestions ?>" form="questionsForm" class="answer answer-yes" type="radio" value="1">Да
                <input name="answer<?= $countQuestions++ ?>" form="questionsForm" class="answer answer-no" type="radio" value="0">Нет
            </div>
        <?php
=======
            <?php
            }
            ?>
                <form id="questionsForm" action="./student_testing.php" method="post">
                    <input type="hidden" value="0">
                    <input type="hidden" name="status" value="Данные отправлены">
                    <input class="button button-submit" type="submit" name="postTestingData" value="Отправить тест">
                </form>
            <?php
        } else {
            ?>
                <p>
                    Прохождение теста в данный момент заблокированно
                </p>
            <?php
>>>>>>> d4ae3e944ae8073c21779da426bd6d5d1d856c2f
        }
        ?>
    </div>
    <script src="script.js"></script>
</body>
</html>