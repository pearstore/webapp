<?php

require_once('../_function.php');
require_once('../_global.php');

$warenkorb = [];
if(isset($_COOKIE['warenkorb'])) {
    $JSON = $_COOKIE['warenkorb'];
    $warenkorb = json_decode($JSON, True);
    $nnn = $warenkorb;
}
if ( isset($_GET['out']) && $_GET['out'] == 1 ) {
    # ausgabe für debug
    print("<pre>");
    var_dump($warenkorb);
    print("</pre>");
} elseif ( isset($_GET['json']) && $_GET['json'] == 1 ) {
    print(json_encode($warenkorb));
} elseif(isset($_GET['anr']) && isset($_GET['type']) && isset($_GET['amount'])){
    $anr = (int) $_GET['anr'];
    $artikel = getArtikelByAnr($anr);
    $type = (string) $_GET['type'];
    $amount = (int) $_GET['amount'];

    if(!isset($warenkorb[$anr])){
        $warenkorb[$anr] = 0;
    }

    if($type == "add") {
        # fügt dem wert im wahrenkorb eine bestimmte mege hinzu 
        if($warenkorb[$anr] + $amount <= $artikel["Menge"]){
            $warenkorb[$anr] = $warenkorb[$anr] + $amount;
        } else {
            $warenkorb[$anr] = $artikel["Menge"];
        }
    } elseif ($type == "rm") {
        # ziet dem wert im wahrenkorb eine bestimmte mege ab 
        if($warenkorb[$anr] - $amount >= 0){
            $warenkorb[$anr] = $warenkorb[$anr] - $amount;
        } else {
            $warenkorb[$anr] = 0;
        }
    } elseif ($type == "set" ) {
        # setzt dem wert im wahrenkorb auf eine bestimmte mege 
        if($amount >= $artikel["Menge"]){
            $warenkorb[$anr] = $artikel["Menge"];
        }elseif ($amount < 0) {
            $warenkorb[$anr] = 0;
        } else {
            $warenkorb[$anr] = $amount;
        }
    }
    $JSON = json_encode($warenkorb);
    setcookie('warenkorb', $JSON, time()+36000, "/");
}
print(json_encode($warenkorb));
print(json_encode($_GET));