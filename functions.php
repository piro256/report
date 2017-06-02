<?php
function ontID($ontSerialRaw) {
    $ontSerialExplode = explode(" ", $ontSerialRaw);
    //перебираем массив серийного номера
    for ($a = 0; $a < count($ontSerialExplode); $a++) {
        if ($a > 3) {
            $ontIdArray[] = hexdec($ontSerialExplode[$a]);
        }
    }
    $ontId = implode(".", $ontIdArray);
    return $ontId;
}

function stbMac ($stbMacRaw) {
    $stbMac = str_replace("\"","",$stbMacRaw);
    $stbMac = substr($stbMac, 0, -1);
    $stbMac = str_replace(" ", ":", $stbMac);
    return $stbMac;
}
function ontSerial($ontSerialRaw) {
    $serial = str_replace("\"","",$ontSerialRaw);
    $serial = str_replace(" ","",$serial);
    $ontSerial =  "ELTX" . substr($serial, 8);
    return $ontSerial;
}

function ontSlotMa4000($ontSerialRaw){
    $ontSlotRaw = substr($ontSerialRaw, 33, 1);
    if (substr($ontSerialRaw, 34, 1) != '.') {
        $ontSlotRaw .= substr($ontSerialRaw, 34, 1);
    }
    return $ontSlotRaw;
}

function ontLanMac($rawOntMac){
    $rawOntMac = str_replace(" \"","",$rawOntMac);
    $rawOntMac = str_replace("\"","",$rawOntMac);
    $ontMac = explode(" ",$rawOntMac);
    return $ontMac;
}  
function ontState($state) {
    switch ($state) {
        case 0:
            $state = "free";
            break;
        case 1:
            $state = "allocated";
            break;
        case 2:
            $state = "authInProgress";
            break;
        case 3:
            $state = "authFailed";
            break;
        case 4:
            $state = "authOk";
            break;
        case 5:
            $state = "cfgInProgress";
            break;
        case 6:
            $state = "cfgFailed";
            break;
        case 7:
            $state = "ok";
            break;
        case 8:
            $state = "failed";
            break;
        case 9:
            $state = "blocked";
            break;
        case 10:
            $state = "mibreset";
            break;
        case 11:
            $state = "preconfig";
            break;
        case 12:
            $state = "fwUpdating";
            break;
        case 13:
            $state = "unactivated";
            break;
        case 14:
            $state = "redundant";
            break;
        case 15:
            $state = "disabled";
            break;
        case 16:
            $state = "unknown";
            break;
    }
    return $state;
}