<?php

include_once('./config.php');

class dbAPI{

    public $db;

    public function init(){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->$db = @mysqli_connect(HOST, USER, PASS, DB) or die('Нет соединения БД');
        mysqli_set_charset($this->$db, 'utf8') or die('Не установлена кодировка соединения ');
    }

    /**
     * Получение данных текущего пользователя
     */
    public function getUserConfig($login, $password){
        $sql = "SELECT * FROM users WHERE login = '".$login."' AND password = '".$password."'";
        $res = mysqli_query($this->$db, $sql);
        $data = null;
        while($row = mysqli_fetch_assoc($res)){
          $data[] = $row;
        }
        return $data[0];
    }

    /**
    * Создание пользователя
    */
    public function createUser($login, $password, $name, $type, $class){
        $sql = "INSERT INTO users (name, login, password, type, class, isopentest, token)
        VALUES ('". $name . "', '" . $login . "', '" . $password . "', " . $type . ", '" . $class . "', 0, '')";
        $res = mysqli_query($this->$db, $sql);
    }

    /**
     * Получение параметров пользователя по токену
     */
    public function getUserConfigByToken($token){
        $sql = "SELECT * FROM users WHERE token = '".$token."'";
        $res = mysqli_query($this->$db, $sql);
        $data = null;
        while($row = mysqli_fetch_assoc($res)){
          $data[] = $row;
        }
        return $data[0];
    }

    /**
     * Создание токена
     */
    public function createToken($user, $token){
        $sql = "UPDATE users SET token = '".$token."' WHERE id = '". $user ."'";
        $res = mysqli_query($this->$db, $sql);
    }

    /**
     * Получение данных пользователя 
     */
    public function getUserInfo($id){
        $sql = "SELECT isopentest, name, class FROM users WHERE id = '".$id."'";
        $res = mysqli_query($this->$db, $sql);
        $data = null;
        while($row = mysqli_fetch_assoc($res)){
          $data[] = $row;
        }
        return $data[0];
    }

    /**
     * Получение статуса теста
     */
    public function getStatusTest(){
        $sql = "SELECT value FROM testsettings WHERE name = 'iswork'";
        $res = mysqli_query($this->$db, $sql);
        $data = null;
        while($row = mysqli_fetch_assoc($res)){
          $data[] = $row;
        }
        return (bool)$data[0]['value'];
    }

    /**
     * Добавление записи тестов
     */
    public function setDataTest($user, $date, $score){
        $sql = "INSERT INTO tests (users, date, score) VALUES (". $user . ", " . $date . ", " . $score . ")";
        $res = mysqli_query($this->$db, $sql);
        $sql = "UPDATE users SET isopentest = 0 WHERE id = '". $user ."'";
        $res = mysqli_query($this->$db, $sql);
    }

    /**
     * Получение данных тестов
     */
    public function getDataTest($user){
        $sql = "SELECT date, score FROM tests WHERE users = '".$user."'";
        $res = mysqli_query($this->$db, $sql);
        $data = null;
        while($row = mysqli_fetch_assoc($res)){
          $data[] = $row;
        }
        return $data;
    }

    /**
     * Открыть тестрование
     */
    public function changeTestingStatus($open){
        if ($open){
            $data = 1;
        } else {
            $data = 0;
        }
        $sql = 'UPDATE users SET isopentest = ' . $data;
        $res = mysqli_query($this->$db, $sql);
    }

    /**
     * Получение списка учеников
     */
    public function getUsers(){
        $sql = "SELECT id, isopentest, name, class FROM users WHERE type = '0'";
        $res = mysqli_query($this->$db, $sql);
        $data = null;
        while($row = mysqli_fetch_assoc($res)){
          $data[] = $row;
        }
        return $data;
    }
}