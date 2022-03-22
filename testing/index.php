<?php
ini_set("display_errors", 1);
error_reporting(-1);
require_once 'config.php';
require_once 'fuctions.php';

if(isset($_POST['test'])){
    $test = (int) $_POST['test'];
    unset ($_POST['test']); //удаляем из массива post номер теста
    $result = get_answers($test);//получение ответов

    //данные теста
    $test_all_data = get_test_data($test);
    // массив вопросы-ответы, ответы, ответы пользователя
    $test_all_data_result = get_test_data_result($test_all_data, $result, $_POST);
    echo print_result($test_all_data_result);
    die;
}
   
//список тестов
$tests = get_tests();
if(isset ($_GET['test'])){
    $test_id=(int)$_GET['test'];//целочисленный тип
    $test_data = get_test_data($test_id);//результат
   //print_arr($test_data);//вывод массива
    //var_dump($test_data);//вывод массива
    if (is_array($test_data)){
   $count_questions=count($test_data);  //количество вопросов теста
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Система тестирования</title>

<link rel="stylesheet" href="style.css">
</head>
<body>
<div class = "wrap"> 

<?php if($tests):?>
    <div class = "header"> 
  <h2>Тест на вывление интернет-зависимости у детей и подростков</h2> </div>
    <br><hr><br>
        <div class ="content">
            <p> С каждым годом проблема интернет зависимости у детей становится все более актуальной. 
                Это расстройство негативным образом отражается на восприятии чувства реальности подростка. Если обнаружить это расстройство вовремя,  
                то можно избавиться от него и избежать многих неприятных последствий.</p>
<p> Вы можете прямо сейчас уделить несколько минут своего времени и пройти тестирование на выявление интернет-зависимости, получив результат за несколько секунд.</p>
<p>Данный тест не является основанием для постановки диагноза. Между тем, он  
    может служить инструментом для выявления лиц, нуждающихся в консультации специалиста. </p>
<p> Чтобы открыть список вопросов тестирования, кликните по ссылке ниже:</p>               
<?php foreach($tests as $test): ?>
        <p><a href="?test=<?=$test['id']?>"><?=$test['test_name']?></a></p> 
        <?php endforeach;?>
        </div>
        <?php if(isset ($test_data)):?>
<?php if(is_array($test_data)):?>
    <p>Всего вопросов:<?=$count_questions?></p>
     <p>Пожалуйста, внимательно прочтите вопросы и ответьте на каждый из них, используя варианты "да" или "нет"</p>
    <span class="none" id="test-id"><?=$test_id?></span>
    <div class ="test-data">
        <?php foreach($test_data as $id_questions => $item): //получаем вопрос+ответ ?> 
    <div class="questions" data-id="<?=$id_questions?>" id="questions-<?=$id_questions?>">
<?php foreach($item as $id_answer => $answer)://по массиву вопрос-ответы?>
    <?php if (!$id_answer)://если ноль, выводим вопрос?>
        <p class="q"><?=$answer?></p>
        <?php else://выводим варианты ответов?>
            <p class="a">
            <input type="radio" id="answer-<?=$id_answer?>" name="question-<?=$id_questions?>" value="<?=$id_answer?>">
            <label for="answer-<?=$id_answer?>"><?=$answer?></label>
        </p>
<?php endif;//$id_answer?>
    <?php endforeach;//$item?>
</div><!--questions-->
            <?php endforeach;//$test_data?>
    </div><!--test-data-->
       <div class="buttons">
           <button class="center btn" id="btn">Закончить тест</button>
       </div>     
    
<body>
<?php else://is_array($test_data)?>
        Тест находится в разработке
        <?php endif;//is_array($test_data))?>
        <?php else://isset ($test_data)?>
            
            <?php endif;//isset ($test_data)?>   
    <?php else: ?>
        <h3>Нет тестов</h3>
        <?php endif; ?>
</div> <!--.wrap-->
<script src="http://code.jquery.com/jquery-latest.js"></script>

<script src="script.js"></script>
</body>


</html>
    