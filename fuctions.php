<?php
//вывод массива 
function print_arr ($arr){
    echo'<pre>' . print_r($arr,true) . '</pre>';
}

//получение списка тестов
function get_tests(){
    global $db;
    $query="SELECT * FROM test";
    $res = mysqli_query($db, $query);
    if(!$res) return false;
    $data = array();
    while ($row=mysqli_fetch_assoc($res)){
        $data[]=$row;
    }
    return $data;

}

//получение данных теста
function get_test_data($test_id){
    if( !$test_id ) return; //если ложь, то прекращаем работу функции
    global $db;
    $query="SELECT q.questions, q.parent_test, a.answers, a.id, a.parent_questions
    FROM questions q 
    LEFT JOIN answers a
    ON q.id=a.parent_questions
    WHERE q.parent_test=$test_id";
    $res = mysqli_query($db, $query);

    $data=null;
    //if(!$res) return false;
      while ($row = mysqli_fetch_assoc($res)){
          if(!$row['parent_questions']) return false;
          $data[$row['parent_questions']][0]=$row['questions'];
          $data[$row['parent_questions']][$row['id']] = $row['answers'];
      }
      return $data;
}

//получение id вопрос-ответ
function get_answers($test){
    if(!$test) return false; //проверка на левые значения, которые может ввести пользователь
    global $db;
    $query = "SELECT q.id AS questions_id, a.id AS answers_id
    FROM questions q
    LEFT JOIN answers a
    ON q.id = a.parent_questions
    WHERE q.parent_test = $test AND a.correct_answer = '1'";
    $res = mysqli_query($db, $query);
    $data = null;
     while($row = mysqli_fetch_assoc($res)){
       
       $data[$row['questions_id']] = $row['answers_id'];
     }
    return $data;

	
}




//получение результатов 
//массив вопрос-ответ, правильные ответы
function get_test_data_result($test_all_data, $result ) {
    foreach($result as $q => $a){        //заполняем массив правильными ответами
        $test_all_data[$q]['correct_answer']=$a;
        //неотвеченные вопросы
        if (!isset ($_POST[$q])) {
            $test_all_data[$q]['incorrect_answer']=0;
        }
    }
    //добавим неверные ответы
    foreach ($_POST as $q => $a) {
        //удаление значений вопросов, которые пользователь пытается ввести с консоли
    if(!isset($test_all_data[$q])){
        unset($_POST[$q]);
        continue;

    }
    //удаление значений ответов, которые пользователь пытается ввести с консоли
    if(!isset($test_all_data[$q][$a])){
        $test_all_data[$q]['incorrect_answer'] = 0; //считаем этот ответ неотвеченным
        continue;
    }
    //добавляем неправильные ответы
    if ($test_all_data[$q]['correct_answer'] != $a){
        $test_all_data[$q]['incorrect_answer'] = $a; 
    }
    }
    return $test_all_data;

}

//печать результатов
function print_result ($test_all_data_result){
    //переменные результатов
    $all_count = count ($test_all_data_result); //количество вопросов теста
    $correct_answer_count = 0; // количество ответов да
    $incorrect_answer_count = 0; // количество ответов нет
    $percent = 0; // процент ответов да
    //подсчет результатов
    foreach($test_all_data_result as $item){
        if(isset ($item['incorrect_answer']) ) $incorrect_answer_count++;
    }
    $correct_answer_count  = $all_count - $incorrect_answer_count;
    $percent = $correct_answer_count / $all_count * 100;
    //вывод результатов
    $print_res = '<div class="count_res">';
    $print_res .= "<p> Всего вопросов: <b>{$all_count}</b> </p>";
    $print_res .= "<p> Положительных ответов: <b>{$correct_answer_count}</b> </p>";
    $print_res .= "<p> Отрицательных ответов: <b>{$incorrect_answer_count}</b> </p>";
    $print_res .= "<p> Процент верных ответов: <b>{$percent}</b> </p>";
    $print_res .= '</div>';
    if($percent > 25) {
        echo 'Вы выбрали положительный ответ более чем на 25% вопросов, у вас интернет зависимость.  Рекомендуем вам обратиться к нужному специалисту. ';
    }
    else {
 echo 'Вы выбрали положительный ответ менее чем на 25% вопросов, у вас нет интернет зависимости.';
    }
    
    return $print_res;
}

?>