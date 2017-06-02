<head>
    <meta charset="utf-8">
</head>
<?php
$path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']); // определяем директорию скрипта
chdir($path_parts['dirname']); // задаем директорию выполнение скрипта
snmp_set_quick_print(1);
include './config.php';
include "./functions.php";
//Okay let's start :)
$ltpListRaw = mysqli_query($link_to_mysql, "SELECT * FROM `jpon` WHERE `type` LIKE 'ma4000' LIMIT 0 , 1") or die(mysqli_error());
for ($i = 0; $i < mysqli_num_rows($ltpListRaw); $i++) {
    //обнуляем переменные
    unset($ontSerialArray);
    $ltpList = mysqli_fetch_array($ltpListRaw);
    exec("C:\\usr\\snmp\\bin\\snmpwalk.exe -v 2c -Ox -c public {$ltpList[ip]} .1.3.6.1.4.1.35265.1.22.3.1.1.2", $ontSerialArray);
    //перебираем весь массив
    echo "<h3>$ltpList[ip] - $ltpList[hostname]</h3>";
    for ($q = 0; $q < count($ontSerialArray); $q++) {
        //обнуляем переменные
        unset($ontIdArray);
        //вырезаем серийник из ответа
        $ontSerialRaw = substr($ontSerialArray[$q], -23);
        //вырезаем ont slot
        $ontSlotRaw = ontSlotMa4000($ontSerialArray[$q]);
        //делаем из серийника уникальный ID
        $ontUniquelyId = ontID($ontSerialRaw);
        //делаем серийный номер читабельным
        $ontSerial = ontSerial($ontSerialRaw);
        echo "ONT serial: $ontSerial<br>";
        //запоминаем время обновления информации
        $updateTime = date("Y-m-j H:i:s");
        //запрашиваем мак акдреса
        $ontMacArray = snmp2_walk($ltpList[ip], "public", ".1.3.6.1.4.1.35265.1.22.3.12.1.7.{$ontSlotRaw}.8.69.76.84.88.{$ontUniquelyId}");
            //перебираем массив и пишем в базу
            for ($a = 0; $a < count($ontMacArray); $a++){
                $stbMac = stbMac($ontMacArray[$a]);
                if (substr($stbMac, 0 ,8) != "A8:F9:4B"){
                    echo "{$stbMac} <br>";
                    //ищем ont и mac в базе
                    $ontSearch = mysqli_query($link_to_mysql, "SELECT * FROM `reports`.`mac` WHERE ontSerial LIKE '$ontSerial' AND `mac` LIKE '$stbMac' LIMIT 0 , 1") or die(mysqli_error());
                    echo "<br>";
                    print_r(mysqli_num_rows($ontSearch));
                    echo "<br>";
                    //если такой ont и mac нету, то добавляем новую запись
                    if (mysqli_num_rows($ontSearch) == 0) {
                        mysqli_query($link_to_mysql, "INSERT INTO `reports`.`mac` (`ontSerial`, `mac`, `date`) VALUES ('$ontSerial', '$stbMac', '$updateTime');") or die(mysqli_error());
                    } else {
                        //если такая ONT и такой MAC найдет, то обновляем дату
                        mysqli_query($link_to_mysql, "UPDATE `reports`.`mac` SET date = '$updateTime' WHERE `mac`.`ontSerial` LIKE '$ontSerial';") or die(mysqli_error());
                    }
                }
            }
        //обнуляем массив
        $ontMacArray = array();
    }
}
$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
printf('<br>Сгенерировано за %.3F сек.', $time);