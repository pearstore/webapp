<?php

session_start();
require_once('mysql.php');

function passwd_crypt ($password, $cost=11){
    $salt="CK6twagYBBYdDq/T3NxzvL";
    $param='$'.implode('$',array("2y", str_pad($cost,2,"0",STR_PAD_LEFT), $salt));
    return crypt($password,$param);
}

function registerUser($vorname, $nachname, $email, $passwort, $adresse, $ort, $plz){
    global $_MYSQL_CONNECTION;

    $sql = "SELECT ortid FROM Ort WHERE Ort = ? AND PLZ = ?";
    $stmt = $_MYSQL_CONNECTION->prepare($sql);
    $stmt->bind_param("si", $ort, $plz);
    $stmt->execute();
    if($stmt->get_result()->num_rows == 0){
        $sql = "INSERT INTO Ort (Ort, PLZ) VALUES (?, ?)";
        $stmt = $_MYSQL_CONNECTION->prepare($sql);
        $stmt->bind_param("si", $ort, $plz);
        $stmt->execute();
    }

    $sql = "INSERT INTO Kunde (Vorname, Nachname, Email, Passwort, Adresse, Ortid) VALUES (?,?,?,?,?,(SELECT OrtId FROM Ort WHERE Ort = ? AND PLZ = ?));";
    $stmt = $_MYSQL_CONNECTION->prepare($sql);
    
    $passwort_hash = passwd_crypt($passwort);

    $stmt->bind_param("ssssssi", $vorname, $nachname, $email, $passwort_hash, $adresse, $ort, $plz);
    return $stmt->execute();
}

function loginUser($email, $passwort){
    global $_MYSQL_CONNECTION;
    // sql quary
    $sql = "SELECT KNR, Vorname, Nachname, Email FROM Kunde WHERE Email=? AND Passwort=?";
    $stmt = $_MYSQL_CONNECTION->prepare($sql);

    // querry variablen
    $email = $_POST['mail'];
    $passwort = passwd_crypt($_POST['passwd']);

    // querry 
    $stmt->bind_param("ss", ...[$email, $passwort]);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $user = $result->fetch_array(MYSQLI_ASSOC);
    
    if($result->num_rows > 0 && $user['KNR']){
        $sql = "INSERT INTO Login (SessionId, Zeitstempel, KNR) VALUES (?, current_timestamp(), ?)";
        $stmt = $_MYSQL_CONNECTION->prepare($sql);

        // querry variablen
        $sessionid = session_id();
        $knr = $user['KNR'];

        // querry 
        $stmt->bind_param("si", $sessionid, $knr);
        if($stmt->execute()){
            $_SESSION["userIsLogin"] = True; 
            return True;
        }
    }
    return False;
}

function logoutUser(){
    global $_MYSQL_CONNECTION;
    // sql quary
    $sql = "DELETE FROM Login WHERE (SessionId = ?);";
    $stmt = $_MYSQL_CONNECTION->prepare($sql);

    // querry variablen
    $sessionid = session_id();

    // querry 
    $stmt->bind_param("s", $sessionid);
    $logoutSuccess = $stmt->execute();
    $_SESSION["userIsLogin"] = False;
    session_destroy();
}

function getUserbySession(){
    global $_MYSQL_CONNECTION;
    $sql = "SELECT k.KNR, k.Vorname, k.Nachname, k.Email, k.Adresse, o.PLZ, o.Ort FROM Kunde as k JOIN Login as l ON k.KNR = l.KNR JOIN Ort as o ON k.Ortid = o.Ortid WHERE l.SessionId = ?;";
    $stmt = $_MYSQL_CONNECTION->prepare($sql);
    $session_id = session_id();

    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    return False;
}

// Register User 
if(isset($_POST['form_type']) && $_POST['form_type'] == "user_register" && isset($_POST['vname']) && isset($_POST['nname']) && isset($_POST['mail']) && isset($_POST['passwd']) && isset($_POST['passwd2']) && isset($_POST['address']) && $_POST['passwd'] == $_POST['passwd2']){
    $registerSuccess = registerUser($_POST['vname'], $_POST['nname'], $_POST['mail'], $_POST['passwd'], $_POST['address'], $_POST['ort'], $_POST['zip']);
}

// Login User
if(isset($_POST['form_type']) && $_POST['form_type'] == "user_login" && isset($_POST['mail']) && isset($_POST['passwd'])){
    $loginSuccess = loginUser($_POST['mail'], $_POST['passwd']);
}

// Logout User
if(isset($_POST['form_type']) && $_POST['form_type'] == "user_logout"){
    logoutUser();
}

$USER = getUserbySession();
?>