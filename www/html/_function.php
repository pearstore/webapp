<?php


function mysql_select(string $quary, string $var_types = NULL, array $var_array = NULL): mysqli_result|false {
    global $_DEBUG;
    $_MYSQL_CONNECTION = mysqli_connect("pearshop_db","pearshop","itsstuttgart","pearstore_database");
    $stmt = $_MYSQL_CONNECTION->prepare($quary);

    if($var_types != NULL && $var_array != NULL){
        $stmt->bind_param($var_types, ...$var_array);
    }

    if($stmt->execute()){
        return $stmt->get_result();
    } else {
        return false;
    }
}
function passwd_crypt ($password, $cost=11){
    /* funktion zum hashen von Passwörtern*/
    $salt="CK6twagYBBYdDq/T3NxzvL";
    $param='$'.implode('$',array("2y", str_pad($cost,2,"0",STR_PAD_LEFT), $salt)); // params für die crypt funtion festlegen
    return crypt($password,$param);
}

function createOrt(string $ort, int $plz){
    /* Erstellt einen neuen Ort */
    global $_MYSQL_CONNECTION;

    $sql = "INSERT INTO Ort (Ort, PLZ) VALUES (?, ?)";
    $stmt = $_MYSQL_CONNECTION->prepare($sql);
    $stmt->bind_param("si", $ort, $plz);
    $stmt->execute();
}

function registerUser(string $vorname, string $nachname, string $email, 
                string $passwort, string $adresse, string $ort, int $plz){
    /* Erstellt einen neuen nutzer in der Datenbank*/
    global $_MYSQL_CONNECTION;

    // Prüfen ob ort exestiert
    $sql = "SELECT ortid FROM Ort WHERE Ort = ? AND PLZ = ?";
    $stmt = $_MYSQL_CONNECTION->prepare($sql);
    $stmt->bind_param("si", $ort, $plz);
    $stmt->execute();
    // Erstellne eines Orts wenn er noch nicht exestiert 
    if($stmt->get_result()->num_rows == 0){
        createOrt($ort, $plz);
    }

    // Passweort hashen
    $passwort_hash = passwd_crypt($passwort);

    // Nutzer in der Datenbank abfragen
    $sql = "INSERT INTO Kunde (Vorname, Nachname, Email, Passwort, Adresse, Ortid) VALUES (?,?,?,?,?,(SELECT OrtId FROM Ort WHERE Ort = ? AND PLZ = ?));";
    $stmt = $_MYSQL_CONNECTION->prepare($sql);
    $stmt->bind_param("ssssssi", $vorname, $nachname, $email, $passwort_hash, $adresse, $ort, $plz);
    return $stmt->execute();
}

function loginUser($email, $passwort){
    /* Einloggen des Nutzers */
    global $_MYSQL_CONNECTION;

    // querry variablen
    $email = $_POST['mail'];
    $passwort = passwd_crypt($_POST['passwd']); // Passwort wird gehasht damit es mit dem hash der datenbank vergilchen werden kann

    $result = mysql_select(
        "SELECT KNR, Vorname, Nachname, Email FROM Kunde WHERE Email=? AND Passwort=?;",
        "ss", array($email, $passwort)
    );
    $user = $result->fetch_array(MYSQLI_ASSOC);
    
    // Wenn der nutzer 
    if($result->num_rows > 0 && $user['KNR']){
        // $sql = "INSERT INTO Login (SessionId, Zeitstempel, KNR) VALUES (?, current_timestamp(), ?)";
        // $stmt = $_MYSQL_CONNECTION->prepare($sql);

        // querry variablen
        $sessionid = session_id();
        $knr = $user['KNR'];

        // // querry 
        // $stmt->bind_param("si", $sessionid, $knr);
        
        if(mysql_select("INSERT INTO Login (SessionId, Zeitstempel, KNR) VALUES (?, current_timestamp(), ?);", "si", [$sessionid, $knr])){
            $_SESSION["userIsLogin"] = True; 
            return True;
        }
    }
    return False;
}

function logoutUser(){
    global $_MYSQL_CONNECTION;
    // // sql quary
    // $sql = "DELETE FROM Login WHERE (SessionId = ?);";
    // $stmt = $_MYSQL_CONNECTION->prepare($sql);

    // querry variablen
    $sessionid = session_id();

    // // querry 
    // $stmt->bind_param("s", $sessionid);
    // $logoutSuccess = $stmt->execute();

    mysql_select("DELETE FROM Login WHERE (SessionId = ?);", "s", [$sessionid]);

    $_SESSION["userIsLogin"] = False;
    session_destroy();
}

function getUserbySession(){
    global $_MYSQL_CONNECTION;
    // $sql = "SELECT k.KNR, k.Vorname, k.Nachname, k.Email, k.Adresse, o.PLZ, o.Ort FROM Kunde as k JOIN Login as l ON k.KNR = l.KNR JOIN Ort as o ON k.Ortid = o.Ortid WHERE l.SessionId = ?;";
    // $stmt = $_MYSQL_CONNECTION->prepare($sql);
    $session_id = session_id();

    // $stmt->bind_param("s", $session_id);
    // $stmt->execute();
    // $result = $stmt->get_result();
    $result = mysql_select("SELECT k.KNR, k.Vorname, k.Nachname, k.Email, k.Adresse, o.PLZ, o.Ort FROM Kunde as k JOIN Login as l ON k.KNR = l.KNR JOIN Ort as o ON k.Ortid = o.Ortid WHERE l.SessionId = ?;",
        "s", [$session_id]
    );
    if($result->num_rows > 0){
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    return False;
}

function getArtikelByAnr(int $anr){
    global $_MYSQL_CONNECTION;
    $sql = "SELECT `Anr`, a.`AArtid`, `Preis`, `Beschreibung`, `Name`, aa.`AArt_Name` FROM `Artikel` as a JOIN `Artikel_Art` as aa ON aa.`AArtid` = a.`AArtid` WHERE `Anr` = ?;";
    $stmt = $_MYSQL_CONNECTION->prepare($sql);
    $session_id = session_id();

    $stmt->bind_param("i", $anr);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    return False;
}

?>