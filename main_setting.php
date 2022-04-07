<?php
include_once './functions.php';

$db = new dbAPI();
$db->init();

$userParams = $db->getUserConfigByToken($_COOKIE['auth']);
$usersList = $db->getUsers();

// Роли:
// 0 - ученик
// 1 - психолог

if ($userParams['type'] !== '1') {
  die('Нет доступа к этой странице');
};

if ($_POST['signOut'] !== null) {
  setcookie('auth', '');
  header('Location: ./index.php');
}

if ($_COOKIE['auth'] !== $userParams['token']) {
  header('Location: ./index.php');
};

if ($_POST['createUser'] !== null) {
  if (!$db->getUserConfig($_POST['login'], $_POST['password'])) {
    $db->createUser($_POST['login'], $_POST['password'], $_POST['name'], $_POST['type'], $_POST['class']);
  } else {
    $isIncorrectlyReg = true;
  }
}

if ($_POST['isopen'] !== null) {
  //Открываем тестирование для всех
  $db->changeTestingStatus(true);
  $userParams['isopentest'] = 1;
}

if ($_POST['isclose'] !== null) {
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
  <!-- Bootstrap CSS (jsDelivr CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- Bootstrap Bundle JS (jsDelivr CDN) -->
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
  <nav class="navbar navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="#">
        Настройка тестирования
      </a>
      <form class="form-inline my-2 my-lg-0" action="./student_testing.php" method="post">
        <span class="text-light" style="margin-right: 10px;"><?= $userParams['name'] ?></span>
        <input class="btn btn-outline-light" type="submit" name="signOut" value="Выход">
      </form>
    </div>
  </nav>
  <div class="container" style="margin-top: 50px;">
    <div style="display: flex; justify-content: space-between; ">
      <div>
        <form action="./main_setting.php" method="post">
          <?php
          if ($userParams['isopentest'] == 0) {
          ?>
            <input class="btn btn-primary" type="submit" value="Открыть тестирование" name="isopen">
          <?php
          } else {
          ?>
            <input class="btn btn-primary" type="submit" value="Закрыть тестирование" name="isclose">
          <?php
          }
          ?>
        </form>
        <br><br>
        <div style="margin-bottom: 15px">
          <strong>Список учеников:</strong>
        </div>
        <div class="list-group">
          <?php foreach ($usersList as $user) { ?>
            <div class="list-group-item list-group-item-action"><a href="./main_score.php?user=<?= $user['id'] ?>"><?= $user['name'] ?></a></div>
          <?php } ?>
        </div>
      </div>
      <div style="width: 50%;">
        <strong>Создание пользователя:</strong>
        <hr>
        <form class="needs-validation" novalidate action="./main_setting.php" method="post">
          <div class="form-row">
            <div class="">
              <label for="validationCustom01">ФИО</label>
              <input type="text" class="form-control" name="name" id="validationCustom01" placeholder="Иван Иванов" value="" required>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div class="">
              <label for="validationCustom02">Класс</label>
              <input type="text" name="class" class="form-control" id="validationCustom02" placeholder="10А" value="" required>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div>
              <label for="validationCustomUsername">Логин</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupPrepend">@</span>
                </div>
                <input type="text" name="login" class="form-control" id="validationCustomUsername" placeholder="example@mail.ru" aria-describedby="inputGroupPrepend" required>
              </div>
              <?php if ($isIncorrectlyReg) { ?>
                <div style="color:red">Пользователь с таким логином уже существует</div>
              <?php } ?>
            </div>
          </div>
          <div class="form-row">
            <div class="">
              <label for="validationCustom03">Пароль</label>
              <input type="password" class="form-control" id="validationCustom03" placeholder="******" required name="password">
              <div class="invalid-feedback">
                Введите пароль
              </div>
            </div>
            <div class="">
              <label for="validationCustom04">Роль</label>
              <input type="text" class="form-control" id="validationCustom04" placeholder="(0-1)" required name="type">
              Введите роль 0 - ученик, 1 -психолог
            </div>
          </div>
          <button class="btn btn-primary" type="submit" name="createUser" style="margin-top: 15px;">Создать пользователя</button>
        </form>
      </div>
    </div>
  </div>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
  <script src="script.js"></script>
</body>

</html>