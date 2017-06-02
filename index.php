<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Report - server">
    <meta name="author" content="piro256">
    <link rel="shortcut icon" href="favicon.ico">
    <title>Report - server</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <h3> <a href="index.php"><img src="ico/logo2.png"></a> Report - service v 0.1</h3>
    </div>
    <div class="col-lg-10 col-lg-offset-1">
        <?php
        include './menu.php';
        include './config.php';
        ?>
        <p>Тут есть немного отчетов</p>
    </div>
    <div class="navbar-fixed-bottom row-fluid container  col-lg-10 col-lg-offset-1" style="background-color: whitesmoke; border-radius: 15px 15px 0px 0px;">
        <div class="navbar-inner">
            <div class="container">
                <?php
                //$time = microtime(true) - $start;
                $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
                printf('<br>Сгенерировано за %.3F сек.', $time);
                mysqli_close($link_to_mysql)
                ?>
                <br>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>