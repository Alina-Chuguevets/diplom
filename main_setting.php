<?php
include_once './functions.php';

$db = new dbAPI();
$db->init();

$userParams = $db->getUserConfigByToken($_COOKIE['auth']);
$usersList = $db->getUsers();

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

if($_POST['createUser'] !== null){
    $db->createUser($_POST['login'], $_POST['password'], $_POST['name'], $_POST['type'], $_POST['class']);
}

if($_POST['isopen'] !== null){
    //Открываем тестирование для всех
    $db->changeTestingStatus(true);
    $userParams['isopentest'] = 1;
}

if($_POST['isclose'] !== null){
    //Закрываем тестирование для всех
    $db->changeTestingStatus(false);
    $userParams['isopentest'] = 0;
}
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
            Настройки тестирования
        </span>
        <form action="./main_setting.php" method="post">
            <input type="submit" name="signOut" value="Выход">
        </form>
    </header>
    <div class="container">
        <div class="headline">
    
        </div>

        <div>
            <form action="./main_setting.php" method="post">
                <?php
                    if($userParams['isopentest'] == 0){
                ?>
                <input class="button" type="submit" value="Открыть тестирование" name="isopen">
                <?php
                    } else {
                ?>
                <input class="button" type="submit" value="Закрыть тестирование" name="isclose">
                <?php
                    }
                ?>
            </form>
            <br><br>
            <form action="./main_setting.php" method="post">
                    <input type="text" placeholder="Имя" name="name">
                    <input type="text" placeholder="Класс" name="class">
                    <input type="text" placeholder="Логин" name="login">
                    <input type="text" placeholder="Пароль" name="password">
                    <input type="text" placeholder="Роль" name="type">
                    <input type="submit" value="Создать аккаунт" name="createUser">
            </form>
            <div>
                <h3>Список учеников: </h3>
            </div>
            <ul>
                <?php
                    foreach($usersList as $user){
                        ?>
                            <li><a href="./main_score.php?user=<?= $user['id'] ?>"><?= $user['name'] ?></a></li>
                        <?php
                    }
                ?>
            </ul>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>