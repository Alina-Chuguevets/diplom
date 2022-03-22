<?php
    $dataCookie = 'test'
    if  ($_COOKIE['auth'] !== $dataCookie){
        die('Авторизуйтесь на <a href="./auth.php">сайте</a>')
    }

    $status = $_POST['status'];

    // Эти данные берутся из бд
    $listScoreTesting = [
        'Дата тестирования': 5,
        'Дата тестирования': 5,
        'Дата тестирования': 5,
        'Дата тестирования': 5,
        'Дата тестирования': 5,
        'Дата тестирования': 5,
        'Дата тестирования': 5,
        'Дата тестирования': 5,
    ]
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
        Результаты тестирования
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
                for($listScoreTesting as $data => $score){
                    ?>
                    <li>
                        Дата тестирования: 
                        <?= $data ?>
                        Результат:
                        <?= $score ?>
                    </li>          
                    <?php
                }
            ?>
            <input type="submit" name="postTestingData">
        </ul>
    </form>
</body>
</html>