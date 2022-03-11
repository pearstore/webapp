<?php

session_start();
var_dump(session_id());
print("<br/>");

# var_dump($_POST);

$link = mysqli_connect("pearshop_db","pearshop","itsstuttgart","pearstore_database");
function passwd_crypt ($password, $cost=11){
    $salt="CK6twagYBBYdDq/T3NxzvL";
    $param='$'.implode('$',array("2y", str_pad($cost,2,"0",STR_PAD_LEFT), $salt));
    return crypt($password,$param);
}

// Register User 
if(isset($_POST['form_type']), $_POST['form_type'] == "user_register" && isset($_POST['vname']) && isset($_POST['nname']) && isset($_POST['mail']) && isset($_POST['passwd']) && isset($_POST['passwd2']) && isset($_POST['address']) && $_POST['passwd'] == $_POST['passwd2']){
    $sql = "INSERT INTO Kunde (Vorname, Nachname, Email, Passwort, Adresse, Ortid) VALUES (?,?,?,?,?,?);";
    $stmt = $link->prepare($sql);
    
    $vorname = $_POST['vname'];
    $nachname = $_POST['nname'];
    $email = $_POST['mail'];
    $passwort = passwd_crypt($_POST['passwd']);
    $adresse = $_POST['address'];
    $ortid = 1;

    $stmt->bind_param("ssssss", $vorname, $nachname, $email, $passwort, $adresse, $ortid);
    $stmt->execute();
}
// Login User
if(isset($_POST['form_type']), $_POST['form_type'] == "user_login" && isset($_POST['mail']) && isset($_POST['passwd'])){
    // sql quary
    $sql = "SELECT KNR, Vorname, Nachname, Email FROM Kunde WHERE Email=? AND Passwort=?";
    $stmt = $link->prepare($sql);

    // querry variablen
    $email = $_POST['mail'];
    $passwort = passwd_crypt($_POST['passwd']);

    // querry 
    $stmt->bind_param("ss", $email, $passwort);
    $stmt->execute();
    $result = $stmt->get_result();
    var_dump($result);
    
    $user = $result->fetch_array(MYSQLI_ASSOC);
    var_dump($user);

    
    if($result->num_rows > 0 && $user['KNR']){
        $sql = "INSERT INTO Login (SessionId, Zeitstempel, KNR) VALUES (?, current_timestamp(), ?)";
        $stmt = $link->prepare($sql);

        // querry variablen
        $sessionid = session_id();
        $knr = $user['KNR'];

        // querry 
        $stmt->bind_param("si", $sessionid, $knr);
        $stmt->execute();
        $result = $stmt->get_result();
        var_dump($result);
        var_dump($result->fetch_array(MYSQLI_ASSOC));
    }
}

$link->close();
?><!DOCTYPE html>
<html lang="de">
<head>
    <Title>Pearstore</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="bg-white bg-gradient">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid" id="navbarToggleExternalContent">
            <a class="navbar-brand" href="#">PearStore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/register.php">register</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Suche" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Suche</button>
                </form>
            </div>
            <div class="d-flex ms-5">
                <button type="button" class="btn btn-outline-light mx-1" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Login
                </button>
                <button type="button" class="btn btn-light mx-1" data-bs-toggle="modal" data-bs-target="#registerModal">
                    Register
                </button>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post">
                <div class="modal-content text-light">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="loginModalLabel">Nutzer Login</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-dark">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control bg-dark text-light" id="mail" name="mail" placeholder="name@example.com">
                            <label for="mail" id="lblemail">E-Mail Adresse</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control bg-dark text-light" id="passwd" name="passwd" placeholder="Password">
                            <label for="passwd" id="lblpasswd">Passwort</label>
                        </div>
                    </div>
                    <div class="modal-footer bg-dark">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-primary" name="form_type" value="user_login">Einloggen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="post">
                <div class="modal-content text-light">
                    <div class="modal-header bg-dark text-light">
                        <h5 class="modal-title" id="registerModalLabel">Nutzer Login</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-dark container-fluid">
                        <div class="row g-3">
                            <div class="col-md-6 ">
                                <div class="container-fluid form-floating">
                                    <div class="form-floating">
                                        <input type="test" class="form-control bg-dark text-light" id="vname" name="vname" placeholder="Vorname">
                                        <label for="vname" class="form-label">Vorname</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="container-fluid">
                                    <div class="form-floating">
                                        <input type="test" class="form-control bg-dark text-light" id="nnmae" name="nname" placeholder="Nachname">
                                        <label for="nname" class="form-label">Nachname</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="container-fluid">
                                    <div class="form-floating">
                                        <input type="email" class="form-control bg-dark text-light" id="mail" name="mail" placeholder="E-Mail">
                                        <label for="mail" class="form-label">E-Mail</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="container-fluid">
                                    <div class="form-floating">
                                        <input type="password" class="form-control bg-dark text-light" id="passwd" name="passwd" placeholder="Passwort">
                                        <label for="passwd" class="form-label">Passwort</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="container-fluid">
                                <div class="form-floating">
                                    <input type="password" class="form-control bg-dark text-light" id="passwd2" name="passwd2" placeholder="Passwort">
                                    <label for="passwd" class="form-label">Passwort (wiederholung)</label>
                                </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="container-fluid">
                                    <div class="form-floating">
                                        <input type="text" class="form-control bg-dark text-light" id="address" name="address" placeholder="Adresse">
                                        <label for="address" class="form-label">Adresse</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="container-fluid">
                                    <div class="form-floating">
                                        <input type="text" class="form-control bg-dark text-light" id="city" name="city" placeholder="Ort">
                                        <label for="city" class="form-label">Ort</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="container-fluid">
                                    <div class="form-floating">
                                        <input type="text" class="form-control bg-dark text-light" id="zip" name="zip" placeholder="PLZ">
                                        <label for="zip" class="form-label">PLZ</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-dark">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-primary" name="form_type" value="user_register">Registrieren</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                <form class="row g-3" method="post">
                    <div class="col-md-6">
                        <label for="vname" class="form-label">Vorname</label>
                        <input type="test" class="form-control" id="vname" name="vname">
                    </div>
                    <div class="col-md-6">
                        <label for="nname" class="form-label">Nachname</label>
                        <input type="test" class="form-control" id="nnmae" name="nname">
                    </div>
                    <div class="col-md-12">
                        <label for="mail" class="form-label">E-Mail</label>
                        <input type="email" class="form-control" id="mail" name="mail">
                    </div>
                    <div class="col-md-6">
                        <label for="passwd" class="form-label">Passwort</label>
                        <input type="password" class="form-control" id="passwd" name="passwd">
                    </div>
                    <div class="col-md-6">
                        <label for="passwd" class="form-label">Passwort (wiederholung)</label>
                        <input type="password" class="form-control" id="passwd2" name="passwd2">
                    </div>
                    <div class="col-12">
                        <label for="address" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                    <div class="col-md-9">
                        <label for="city" class="form-label">Ort</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>
                    <div class="col-md-3">
                        <label for="zip" class="form-label">PLZ</label>
                        <input type="text" class="form-control" id="zip" name="zip">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Registrieren</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
</body>

</html>