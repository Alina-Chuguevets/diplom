<?php
define("HOST", "localhost");
define("USER", "root");
define("PASS", "");
define("DB", "testing");

$db = @mysqli_connect(HOST, USER, PASS, DB) or die('Нет соединения БД'); //@ для того, чтобы выводилась только эта ошибка
mysqli_set_charset($db, 'utf8') or die('Не установлена кодировка соединения ');
//require "rb.php";
//R::setup ('mysql:host=localhost; dbname=testing', 'root', '');
?>