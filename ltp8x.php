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
        include "./functions.php";

        //выводим только проблемные приставки
        $ontLowRssi= filter_input(INPUT_GET, 'ontLowRssi', FILTER_SANITIZE_NUMBER_INT);
        if ($ontLowRssi == 1) {
            $config = " AND `ontRssi` < -27 ";
        } else {
            $config = "";
        }

        echo "<a href=\"ltp8x.php?ontLowRssi=1\">Показать только проблемные ONT</a> ||| <a href=\"ltp8x.php?ontLowRssi=0\">Показать все ONT</a>";

        $ltpListRaw = mysqli_query($link_to_mysql, "SELECT * FROM `jpon` WHERE `type` LIKE 'ltp'") or die(mysqli_error());
        for ($q = 0; $q < mysqli_num_rows($ltpListRaw); $q++) {
            $ltpList = mysqli_fetch_array($ltpListRaw);
            echo "<h3>$ltpList[ip] - $ltpList[hostname]</h3>";
            echo "<table class='table table-condensed'><tr><td>Serial</td><td>Channel</td><td>Id</td><td>State</td><td>Rssi</td><td>Rx Power</td><td>Description</td><td>Last Update</td></tr>";

            $ontListRaw = mysqli_query($link_to_mysql, "SELECT * FROM `ont` WHERE `id_device` = '$ltpList[id]'".$config."ORDER BY `ont`.`ontChannel` ASC ") or die(mysqli_error());
                for ($w = 0; $w < mysqli_num_rows($ontListRaw); $w++) {
                    $ontList = mysqli_fetch_array($ontListRaw);
                    //проверяем поддерживает ли ONT параметр RxPower
                    if ($ontList[ontRxPower] == 32.767){
                        $ontList[ontRxPower] = "not supported";
                    }
                    //выводим ont с параметрами
                    if ($ontList[ontRssi] < -27 ){
                        echo "<tr class='danger'><td>$ontList[ontSerial]</td><td>$ontList[ontChannel]</td><td>$ontList[ontId]</td><td>$ontList[ontState]</td><td>$ontList[ontRssi]</td><td>$ontList[ontRxPower]</td><td>$ontList[ontDescription]</td><td>$ontList[date]</td></tr>";
                    } else {
                        echo "<tr><td>$ontList[ontSerial]</td><td>$ontList[ontChannel]</td><td>$ontList[ontId]</td><td>$ontList[ontState]</td><td>$ontList[ontRssi]</td><td>$ontList[ontRxPower]</td><td>$ontList[ontDescription]</td><td>$ontList[date]</td></tr>";
                    }
                }
            echo "</table>";
        }
        $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
        printf('<br>Сгенерировано за %.3F сек.', $time);
        ?>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>