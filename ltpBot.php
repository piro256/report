<?php
$path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']); // определяем директорию скрипта
chdir($path_parts['dirname']); // задаем директорию выполнение скрипта
snmp_set_quick_print(1);
include './config.php';
include "./functions.php";
//Okay let's start :)
$ltpListRaw = mysqli_query($link_to_mysql, "SELECT * FROM `jpon` WHERE `type` LIKE 'ltp'") or die(mysqli_error());
for ($i = 0; $i < mysqli_num_rows($ltpListRaw); $i++) {
    //обнуляем переменные
    unset($ontSerialArray);
    $ltpList = mysqli_fetch_array($ltpListRaw);
    exec("snmpwalk -v 2c -Ox -c public {$ltpList[ip]} .1.3.6.1.4.1.35265.1.22.3.1.1.2", $ontSerialArray);
    //перебираем весь массив
    echo "<h3>$ltpList[ip] - $ltpList[hostname]</h3>";
    for ($q = 0; $q < count($ontSerialArray); $q++) {
        //обнуляем переменные
        unset($ontIdArray);
        //вырезаем серийник из ответа
        $ontSerialRaw = substr($ontSerialArray[$q], -23);
        //делаем из серийника уникальный ID
        $ontUniquelyId = ontID($ontSerialRaw);

        //делаем серийный номер читабельным
        $ontSerial = ontSerial($ontSerialRaw);

        //запрашиваем слот
        $ontSlot = snmp2_get($ltpList[ip], "public", ".1.3.6.1.4.1.35265.1.22.3.1.1.1.1.8.69.76.84.88.{$ontUniquelyId}");

        //запрашиваем Channel
        $ontChannel = snmp2_get($ltpList[ip], "public", ".1.3.6.1.4.1.35265.1.22.3.1.1.3.1.8.69.76.84.88.{$ontUniquelyId}");

        //запрашиваем ID
        $ontId = snmp2_get($ltpList[ip], "public", ".1.3.6.1.4.1.35265.1.22.3.1.1.4.1.8.69.76.84.88.{$ontUniquelyId}");

        //запрашиваем стутус ONT
        $ontStateRaw = snmp2_get($ltpList[ip], "public", ".1.3.6.1.4.1.35265.1.22.3.1.1.5.1.8.69.76.84.88.{$ontUniquelyId}");
        $ontState = ontState($ontStateRaw);

        //запрашиваем rssi
        $ontRssi = str_replace("\"", "", snmp2_get($ltpList[ip], "public", ".1.3.6.1.4.1.35265.1.22.3.1.1.11.1.8.69.76.84.88.{$ontUniquelyId}")) * 0.1;

        //запрашиваем RxPower (не все отдают, смотри Rsii)
        $ontRxPower = snmp2_get($ltpList[ip], "public", ".1.3.6.1.4.1.35265.1.22.3.1.1.14.1.8.69.76.84.88.{$ontUniquelyId}") * 0.001;

        //Запращиваем Description
        $ontDescription = str_replace("\"", "", snmp2_get($ltpList[ip], "public", ".1.3.6.1.4.1.35265.1.22.3.4.1.8.1.8.69.76.84.88.{$ontUniquelyId}"));

        $updateTime = date("Y-m-j H:i:s");

        //выводим

        $ontSearch = mysqli_query($link_to_mysql, "SELECT * FROM `ont` WHERE `ontSerial` LIKE '$ontSerial' LIMIT 0 , 1");
        print_r(mysqli_num_rows($ontSearch));
        if (mysqli_num_rows($ontSearch) == 0) {
            mysqli_query($link_to_mysql, "INSERT INTO `ont` (`id_device`, `ontSlot`, `ontSerial`, `ontChannel`, `ontId`, `ontState`, `ontRssi`, `ontRxPower`, `ontDescription`, `date`) 
                VALUES ('{$ltpList[id]}', '$ontSlot', '$ontSerial', '$ontChannel', '$ontId', '$ontState', '$ontRssi', '$ontRxPower', '$ontDescription', '$updateTime');");

            echo "ADD ||| $ontSerial ||| $ontSlot ||| $ontChannel ||| $ontId ||| $ontState ||| $ontRssi ||| $ontRxPower ||| $ontDescription |||| $updateTime <br>";
        } else {
            mysqli_query($link_to_mysql, "UPDATE `reports`.`ont` SET `id_device` = '{$ltpList[id]}', `ontSlot` = '$ontSlot', `ontChannel` = '$ontChannel', `ontId` = '$ontId', `ontState` = '$ontState', 
                `ontRssi` = '$ontRssi', `ontRxPower` = '$ontRxPower', `ontDescription` = '$ontDescription', `date` = '$updateTime' WHERE `ont`.`ontSerial` = '$ontSerial';");

            echo "UPD ||| $ontSerial ||| $ontSlot ||| $ontChannel ||| $ontId ||| $ontState ||| $ontRssi ||| $ontRxPower ||| $ontDescription |||| $updateTime <br>";
        }
    }
}
$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
printf('<br>Сгенерировано за %.3F сек.', $time);
