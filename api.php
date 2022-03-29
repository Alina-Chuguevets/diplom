<?php
require_once './functions.php';

class API{

    public $db;

    public function init(){
        $this->$db = new dbAPI();
        $this->$db->init();
    }

    /**
     * Отправлены результаты теста
     */
    public function postTest($id, $score){
        $this->$db->setDataTest($id, date("Ymd"), $score);
        header('Location: ./student_score.php');
    }

    /**
     * Проверка авторизации пользователя
     */
    public function checkAuth(){
        $user = $this->$db->getUserConfigByToken($_COOKIE['auth']);
        if($user == NULL){
            die('Ошибка токена');
        }
        if($user['type'] == 0){
            header('Location: ./student_testing.php');
        } else {
            header('Location: ./main_setting.php');
        }
    }

    /**
     * Запрос на авторизацию
     */
    public function auth($login, $password){
        $user = $this->$db->getUserConfig($login, $password);
        if($user == NULL){
            $result = 'Ошибка авторизации';
        }else {

        $token = base64_encode($_POST['password']);
        $this->$db->createToken($user['id'], $token);            
        
        setcookie('auth', $token);
        if($user['type'] == 0){
            header('Location: ./student_testing.php');
        } else {
            header('Location: ./main_setting.php');
        }
        }
        return $result;
    }
}
