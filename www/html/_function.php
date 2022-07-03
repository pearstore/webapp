<?php

// Dises dukument enthält alle wichtigen funktionen der Webseite

function mysql_execute(string $quary, string $var_types = NULL, array $var_array = NULL): mysqli_result|bool {
    /* Dies ist eine universelle funktion um MySQL (DML) Quarys auszuführen */
    /* • Die funktion gibt True zurück wenn die Quary erfogreich ausgefüht wurde, aber kein wert duch die Quary ausgegeben wurde */
    /* • Die funtion gibt alle duch die Quary ausgegebenen werte zurück */
    /* • Bei einem Fehler gibt die funktion False zurück */

    global $_MYSQL; // Übergibt die MySQL Nutzerdaten aus _global.php
    $_MYSQL_CONNECTION = mysqli_connect($_MYSQL["HOST"],$_MYSQL["USER"],$_MYSQL["PASSWD"],$_MYSQL["DATABASE"], $_MYSQL["PORT"]);
    
    // mysql Query bauen und ausführen
    $stmt = $_MYSQL_CONNECTION->prepare($quary);
    if($var_types != NULL && $var_array != NULL){
        $stmt->bind_param($var_types, ...$var_array);
    }
    $execute = $stmt->execute();

    // Prüfen ob ein Wert zurückgegeben wird. Wenn dann wwert zurckgeben. Sonst false als rückgabe wert.
    if($execute){
        $result = $stmt->get_result();
        if($result){
            return $result;
        } else {
            return True;
        }
    } else {
        return false;
    }
}
function mysql_insert_lastid(string $quary, string $var_types = NULL, array $var_array = NULL): int {
    /* Mit funktion können insert query aus gefürt werden */
    /* Zusätzlich gibt die letzte ID die mit Auto-Inkrement festgelegt worden ist zurück */

    global $_MYSQL; // Übergibt die MySQL Nutzerdaten aus _global.php
    $_MYSQL_CONNECTION = mysqli_connect($_MYSQL["HOST"],$_MYSQL["USER"],$_MYSQL["PASSWD"],$_MYSQL["DATABASE"], $_MYSQL["PORT"]);

    $stmt = $_MYSQL_CONNECTION->prepare($quary);
    if($var_types != NULL && $var_array != NULL){
        $stmt->bind_param($var_types, ...$var_array);
    }
    $execute = $stmt->execute();

    // Holt die ID die von der vorher ausgefürten query erstellt wurde
    $last_id = mysqli_insert_id($_MYSQL_CONNECTION);

    return $last_id;
}
function passwd_crypt($password, $cost=11): string {
    /* funktion zum hashen von Passwörtern*/
    $salt="CK6twagYBBYdDq/T3NxzvL";
    $param='$'.implode('$',array("2y", str_pad($cost,2,"0",STR_PAD_LEFT), $salt)); // params für die crypt funtion festlegen
    return crypt($password,$param);
}

function createOrt(string $ort, int $plz): mysqli_result|bool {
    /* Esrtellt einen Ort in der Datenbank */
    return mysql_execute(
        "INSERT INTO Ort (Ort, PLZ) VALUES (?, ?);",
        "si",
        [$ort, $plz]
    );
}

/* User Management */

function registerUser(string $vorname, string $nachname, string $email, string $passwort, string $adresse, string $ort, int $plz): mysqli_result|bool {
    /* Erstellt einen neuen nutzer in der Datenbank*/

    $ort_result = mysql_execute(
        "SELECT ortid FROM Ort WHERE Ort = ? AND PLZ = ?",
        "si",
        [$ort, $plz]
    );
    if($ort_result->num_rows == 0){
        createOrt($ort, $plz);
    }

    // Passweort hashen
    $passwort_hash = passwd_crypt($passwort);

    // Nutzer in der Datenbank abfragen
    return mysql_execute(
        "INSERT INTO Benutzer (Vorname, Nachname, Email, Passwort, Adresse, Ortid) VALUES (?,?,?,?,?,(SELECT OrtId FROM Ort WHERE Ort = ? AND PLZ = ?));",
        "ssssssi", 
        [$vorname, $nachname, $email, $passwort_hash, $adresse, $ort, $plz]
    );
}

function loginUser($email, $passwort): bool {
    /* Einloggen des Nutzers */

    // querry variablen
    $email = $_POST['mail'];
    $passwort = passwd_crypt($_POST['passwd']); // Passwort wird gehasht damit es mit dem hash der datenbank vergilchen werden kann

    $result = mysql_execute(
        "SELECT BNR FROM Benutzer WHERE Email=? AND Passwort=?;",
        "ss", array($email, $passwort)
    );
    
    // Wenn der nutzer exestiert
    if($result->num_rows > 0){
        /* querry variablen */
        $sessionid = session_id();

        $login = mysql_execute(
            "INSERT INTO `Login` (SessionId, Zeitstempel, BNR) VALUES (?, current_timestamp(), (SELECT BNR FROM Benutzer WHERE Email=? AND Passwort=?));",
            "sss",
            [$sessionid, $email, $passwort]
        );
        
        if($login){
            $_SESSION["userIsLogin"] = True; 
            return True;
        }
    }
    return False;
}

function logoutUser() {
    /* logt den aktuellen Nutzer aus */

    // querry variablen
    $sessionid = session_id();

    mysql_execute(
        "DELETE FROM Login WHERE (SessionId = ?);",
        "s",
        [$sessionid]
    );

    $_SESSION["userIsLogin"] = False;
    session_destroy();
}

function getUserbySession(): array|false {
    /* Gibt den aktuell angemeldeten nutzer aus */
    $session_id = session_id();
    
    $result = mysql_execute(
        "SELECT b.BNR, b.Vorname, b.Nachname, b.Email, b.Adresse, o.PLZ, o.Ort FROM Benutzer as b JOIN `Login` as l ON l.BNR = b.BNR JOIN Ort as o ON b.Ortid = o.Ortid WHERE l.SessionId = ?;",
        "s",
        [$session_id]
    );

    if($result->num_rows > 0){
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    return False;
}

function getArtikelByAnr(int $anr): array|false {
    /* Findet Artikel in der Datenbank */
    $session_id = session_id();

    $result = mysql_execute(
        "SELECT `Anr`, a.`AArtid`, `Preis`, `Beschreibung`, `Name`, aa.`AArt_Name`, `Menge` FROM `Artikel` as a JOIN `Artikel_Art` as aa ON aa.`AArtid` = a.`AArtid` WHERE `Anr` = ?;",
        "i",
        [$anr]
    );

    if($result->num_rows > 0){
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    return False;
}

function insertOrder(int $userId, array $besposList): bool {
    /* Erstellt eine Bestellung mit Positionen */
    $lastID = mysql_insert_lastid("INSERT INTO Bestellung (BNR) VALUES (?);", "i", [$userId]);
    foreach($besposList as $Anr => $Menge){
        mysql_execute(
            "INSERT INTO Bestpos (BID, Anr, Menge) VALUES (?, ?, ?);",
            "iii",
            [$lastID, $Anr, $Menge]
        );
    }
    return True;
}
    
?>