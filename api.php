<?php
header('Content-Type: application/json');
if ($_GET['action'] == "getMac") {
    $balance;
    //Узнаём из базы данных баланс аккаунта и записываем в переменную balance
    $stbMac = $_GET['mac'];
    include './config.php';
    //ищем мак в базе и забираем серийный номер ONT
    $stbQuery = mysqli_query($link_to_mysql, "SELECT * FROM `reports`.`mac` WHERE `mac` = '$stbMac' 
        ORDER BY `mac`.`date` DESC") or die("ONT не найдена");
    $stbResult = mysqli_fetch_array($stbQuery);
    //echo "{$stbResult[ontSerial]}<br>";
    //ищем ont
    $ontQuery = mysqli_query($link_to_mysql, "SELECT * FROM `ont` WHERE `ontSerial` = '$stbResult[ontSerial]'");
    $ontResult = mysqli_fetch_array($ontQuery);
    //узнаем где стоит данная ont
    $deviceQuery = mysqli_query($link_to_mysql, "SELECT * FROM `jpon` WHERE `id` = '$ontResult[id_device]'");
    $deviceResult = mysqli_fetch_array($deviceQuery);
    //echo"{$deviceResult[ip]}<br>{$ontResult[ontSlot]}<br>{$ontResult[ontChannel]}<br>$ontResult[ontId]";
    $jsonResponse = array("deviceIP" => "$deviceResult[ip]","ontSerial" => "$stbResult[ontSerial]",
        "ontSlot" => "$ontResult[ontSlot]", "ontChannel" => "$ontResult[ontChannel]","ontId" => "$ontResult[ontId]");
    echo(json_encode($jsonResponse, JSON_FORCE_OBJECT));
}