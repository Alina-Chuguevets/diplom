<?php
include_once './functions.php';

$db = new dbAPI();
$db->init();

$userParams = $db->getUserConfigByToken($_COOKIE['auth']);

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

if ($_GET['user'] == null) {
    die('Не указан пользователь');
}

$userId = $_GET['user'];

$userInfo = $db->getUserInfo($userId);

//Результат тестов
$userTests = $db->getDataTest($userId);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                Результаты тестирования
            </a>
            <form class="form-inline my-2 my-lg-0" action="./student_testing.php" method="post">
                <span class="text-light" style="margin-right: 10px;"><?= $userParams['name'] ?></span>
                <input class="btn btn-outline-light" type="submit" name="signOut" value="Выход">
            </form>
        </div>
    </nav>
    <div class="container">

        <div>
            <div class="buttonsBlock">
                <a class="btn btn-primary" href="./main_setting.php">Настройки тестирования</a>
            </div>
        </div>
        <hr>
        <br><br>
        <div style="margin-bottom: 25px;">
            <h3>Результаты тестирования ученика <?= $userInfo['name'] ?>(<?= $userInfo['class'] ?>)</h3>
        </div>
        <div class="mainScore">
            <div>
                <ul>
                    <?php
                    if ($userTests !== null) {
                        foreach ($userTests as $test) {
                    ?>
                            <li>Дата: (<span class="dateTest"><?= substr($test['date'], 0, 4) . "-" . substr($test['date'], 4, 2) . "-" . substr($test['date'], 6, 2); ?></span>) Результат:
                                <font color="<?= $test['score'] > 50 ? 'green' : 'red' ?>">
                                    <span class="dataTest">
                                        <?= $test['score'] ?>
                                    </span>
                            </li>
                            </font>
                    <?php
                        }
                    } else {
                        echo "<span>Ученик не прошел ни одного теста</span>";
                    }
                    ?>
                </ul>
            </div>
            <div>
                <h5 style="margin-bottom: 20px;">График прогноза зависимости:</h5>
                <div class="canvas-substrate">
                    <canvas id="canvas" class="canvas" width="630" height="400">
                    </canvas>
                    <div class="canvas-substrate__date"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext("2d");
        ctx.strokeStyle = 'navy';
        ctx.lineWidth = 3.0;
        ctx.beginPath();

        let data = $('.dataTest');
        let alfa = 0.1;
        let L = ($(data[0]).html()) * 0.5;
        let point = 0;
        let d = 600 / data.length;

        const pointsArray = [];
        
        let summX = 0;
        let summY = 0;
        let summX2 = 0;
        let summXY = 0;

        data.each((index, element) => {
            point = 200 - Math.round(Math.pow((1 - alfa), index) * $(element).html() + Math.pow((1 - alfa), data.length) * L);
            pointsArray.push([index * d, point]);
            if (index == 0) {
                ctx.moveTo(index * d, point);
                ctx.arc(index * d, point, 2, 0, Math.PI * 2, true);
            } else {
                ctx.lineTo(index * d, point);
                ctx.arc(index * d, point, 2, 0, Math.PI * 2, true);
            }
            console.log('x: ' + index * d + 'y: ' + point )
            summX += index;
            summY += point;
            summX2 += index * index;
            summXY += index * point;
        });
        

        // Метод крамера
        function determinant(a11,a12,a21,a22){
            var d;
            d = a11*a22-a12*a21  
            return d
        }
 
    function model(a11, a12, a13, a21, a22, a23){
        var d;
        var d1,d2;
        var x1,x2;
        d = determinant(a13,a23,a12,a22);
        d1 = determinant(a11,a21,a12,a22);
        d2 = determinant(a11,a21,a13,a23);
        x1 = d/d1;
        x2 = d2/d1;
        return [x1, x2]
    }
    ctx.stroke();
    ctx.beginPath();
    ctx.strokeStyle = "#138CCB";

    let abArray = model(summX2, summX, summXY, summX, data.length, summY);
    // Строим прогнозную модель
    data.each((index, element) => {
        let y = index * abArray[0] + abArray[1];
        console.log(y);
            if (index == 0) {
                ctx.moveTo(index * d, y);
                ctx.arc(index * d, y, 2, 0, Math.PI * 2, true);
            } else {
                ctx.lineTo(index * d, y);
                ctx.arc(index * d, y, 2, 0, Math.PI * 2, true);
            }
        });
        let y = (data.length + 1) * abArray[0] + abArray[1];
        console.log(y);

                ctx.lineTo((data.length + 1) * d, y);
                ctx.arc((data.length + 1) * d, y, 2, 0, Math.PI * 2, true);

        ctx.stroke();
        let associate = {};
        let dates = $('.dateTest');
        dates.each((index, element) => {
            associate[`${pointsArray[index]}`] = $(element).html();
        });
        let canvasDate = $('.canvas__date');
        $('canvas').on('mousemove', (e) => {
            $this = $(e).target;
            var x = e.pageX - e.target.offsetLeft,
                y = e.pageY - e.target.offsetTop;
            if (associate[`${x},${y}`] !== undefined) {
                canvasDate.html(associate[`${x},${y}`]);
                canvasDate.show();
            }
        })
    </script>
    <script src="script.js"></script>
</body>

</html>