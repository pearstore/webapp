<?php
session_start();
# var_dump(session_id());

# var_dump($_POST);

$link = mysqli_connect("pearshop_db","pearshop","itsstuttgart","pearstore_database");
function passwd_crypt ($password, $cost=11){
    $salt="CK6twagYBBYdDq/T3NxzvL";
    $param='$'.implode('$',array("2y", str_pad($cost,2,"0",STR_PAD_LEFT), $salt));
    return crypt($password,$param);
}

// Register User 
if(isset($_POST['form_type']) && $_POST['form_type'] == "user_register" && isset($_POST['vname']) && isset($_POST['nname']) && isset($_POST['mail']) && isset($_POST['passwd']) && isset($_POST['passwd2']) && isset($_POST['address']) && $_POST['passwd'] == $_POST['passwd2']){
    $sql = "INSERT INTO Kunde (Vorname, Nachname, Email, Passwort, Adresse, Ortid) VALUES (?,?,?,?,?,?);";
    $stmt = $link->prepare($sql);
    
    $vorname = $_POST['vname'];
    $nachname = $_POST['nname'];
    $email = $_POST['mail'];
    $passwort = passwd_crypt($_POST['passwd']);
    $adresse = $_POST['address'];
    $ortid = 1;

    $stmt->bind_param("ssssss", $vorname, $nachname, $email, $passwort, $adresse, $ortid);
    $registerSuccess = $stmt->execute();
}

function loginUser($db, $email, $passwort){
    // sql quary
    $sql = "SELECT KNR, Vorname, Nachname, Email FROM Kunde WHERE Email=? AND Passwort=?";
    $stmt = $db->prepare($sql);

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
        $stmt = $db->prepare($sql);

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

// Login User
if(isset($_POST['form_type']) && $_POST['form_type'] == "user_login" && isset($_POST['mail']) && isset($_POST['passwd'])){
    $loginSuccess = loginUser($link, $_POST['mail'], $_POST['passwd']);
}

// Login User
if(isset($_POST['form_type']) && $_POST['form_type'] == "user_logout"){
    // sql quary
    $sql = "DELETE FROM Login WHERE (SessionId = ?);";
    $stmt = $link->prepare($sql);

    // querry variablen
    $sessionid = session_id();

    // querry 
    $stmt->bind_param("s", $sessionid);
    $logoutSuccess = $stmt->execute();
    $_SESSION["userIsLogin"] = False;
    session_destroy();
}

$userIsLogin = False;
if(isset($_SESSION['userIsLogin']) && $_SESSION["userIsLogin"] == True){
    $sql = "SELECT K.KNR, K.Vorname, K.Nachname, K.Email, L.Zeitstempel FROM Kunde K JOIN Login L ON K.KNR = L.KNR WHERE L.SessionId = ?";
    $stmt = $link->prepare($sql);

    // querry variablen
    $sessionid = session_id();

    // querry 
    $stmt->bind_param("s", $sessionid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        $user = $result->fetch_array(MYSQLI_ASSOC);
        $userIsLogin = True;
    } else {
        $_SESSION["userIsLogin"] = False;
        session_destroy();
    }
}

$link->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <Title>Pearstore</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ware</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Warenkorb</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Bestellungen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">über uns</a>
                    </li>
                </ul>
                <form class="d-flex me-4">
                    <input class="form-control me-2 bg-dark text-white" type="search" placeholder="Suche" aria-label="Search">
                    <button class="btn btn-light" type="submit">Suche</button>
                </form>
                <?php if($userIsLogin == False): ?>
                    <button type="button" class="btn btn-outline-light mx-1" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Login
                    </button>
                    <button type="button" class="btn btn-light mx-1" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Register
                    </button>
                <?php elseif($userIsLogin == True): ?>
                    <form method="post" class="flex-shrink-0 dropdown">
                        <a href="#" class="d-block link-light text-decoration-none dropdown-toggle text-light" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo("https://www.gravatar.com/avatar/" . md5( strtolower( trim( $user["Email"] ) ) ) . "?d=identicon&s=" . 32); ?>" class="border border-white border-1 rounded-circle" width="32" height="32">
                        </a>
                        <ul class="dropdown-menu text-small dropdown-menu-end dropdown-menu-dark bg-dark border-light" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="/account.php">Profil</a></li>
                            <li><a class="dropdown-item" href="/orders.php">Bestellungen</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="dropdown-item" type="submit" name="form_type" value="user_logout">Logout</button></li>
                        </ul>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($loginSuccess) && $loginSuccess == True): ?>
            <div class="alert alert-success d-flex align-items-center mt-3" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>Login Erfogreich!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($loginSuccess) && $loginSuccess == False): ?>
            <div class="alert alert-danger d-flex align-items-center mt-3" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>Login fehlgeschlagen. Überprüfe deinen Benutzername oder Passwort!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($registerSuccess) && $registerSuccess == True): ?>
            <div class="alert alert-success d-flex align-items-center mt-3" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>Registierung Erfogreich!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($registerSuccess) && $registerSuccess == False): ?>
            <div class="alert alert-danger d-flex align-items-center mt-3" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>Registierung fehlgeschlagen. Überprüfe deine Angaben!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($logoutSuccess) && $logoutSuccess == True): ?>
            <div class="alert alert-success d-flex align-items-center mt-3" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>Logout Erfogreich!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($logoutSuccess) && $logoutSuccess == False): ?>
            <div class="alert alert-danger d-flex align-items-center mt-3" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>Logout fehlgeschlagen.</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

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
        <div class="card mt-3">
            <div class="card-body">
                
            </div>
        </div>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
</body>

</html>