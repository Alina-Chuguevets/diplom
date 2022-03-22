<?php
    $dataCookie = 'test'
    if  ($_COOKIE['auth'] !== 'test'){
        die('Авторизуйтесь на <a href="./auth.php">сайте</a>')
    }

    // Данные с вопросами для теста
    // todo берутся с бд
    $isOpenTest = true;
    $listQuestions = [
        'Вопрос 1',
        'Вопрос 2',
        'Вопрос 3',
        'Вопрос 4',
    ]

    $status = $_POST['status'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="style.css"></link>
</head>
<body>
    <h1>
        Тестирование
    </h1>
    <div class='statusMessage'>
        <?php
            echo $status;
        ?>
    </div>
    <div>
        <a href="./student_testing.php">Тестирование</a>
        <a href="./student_score.php">Результат тестирования</a>
    </div>
    <form action="./student_testing.php" method="post">
        <ul>
            <input name="status" value="Данные отправлены">
            <?php
                for($listQuestions as $question){
                    ?>
                    <li>
                        <?= $question ?>
                        Тут ответ пока не понятно в каком виде
                    </li>          
                    <?php
                }
            ?>
            <input type="submit" name="postTestingData">
        </ul>
    </form>
</body>
</html>