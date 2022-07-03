
<div class="container-fluid px-0 mb-0">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container" id="navbarToggleExternalContent">
          <a class="navbar-brand" href="/">
            <img src="/assets/pictures/icon/Pear.png" width="30" height="30" class="d-inline-block align-top" alt="">
            Pearstore
          </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link" href="/Ware.php">Ware</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ueber_uns.php">über uns</a>
                    </li>
                </ul>
                <form action="/ware.php" method="get" class="d-flex me-4">
                    <div class="input-group">
                        <input class="form-control bg-dark text-white" name="name" type="search" placeholder="Suche" aria-label="Search">
                        <button class="btn btn-light" type="submit">Suche</button>
                    </div>
                </form>
                <?php if(isset($_USER) && $_USER != False): ?>
                    <form method="post" class="flex-shrink-0 dropdown">
                        <a href="#" class="d-block link-light text-decoration-none dropdown-toggle text-light" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo("https://www.gravatar.com/avatar/" . md5( strtolower( trim( $_USER["Email"] ) ) ) . "?d=identicon&s=" . 32); ?>" class="border border-white border-1 rounded-circle" width="32" height="32">
                        </a>
                        <ul class="dropdown-menu text-small dropdown-menu-end dropdown-menu-dark bg-dark border-light" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="/warenkorb.php">Warenkorb</a></li>
                            <li><a class="dropdown-item" href="/account.php">Info</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="dropdown-item" type="submit" name="form_type" value="user_logout">Logout</button></li>
                        </ul>
                    </form>
                <?php else: ?>
                    <!--div class="btn-group mx-1" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login
                        </button>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#registerModal">
                            Register
                        </button>
                    </div-->
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                        <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu text-small dropdown-menu-end dropdown-menu-dark bg-dark border-light" aria-labelledby="dropdownMenuReference">
                            <li data-bs-toggle="modal" data-bs-target="#registerModal"><a class="dropdown-item">Register</a></li>
                            <li><a class="dropdown-item" href="/warenkorb.php">Warenkorb</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"></a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Login modal -->
        <?php
        // Login User
            if(isset($_POST['form_type']) && $_POST['form_type'] == "user_login" && isset($_POST['mail']) && isset($_POST['passwd'])){
                $loginSuccess = loginUser($_POST['mail'], $_POST['passwd']);
            }

            // Logout User
            if(isset($_POST['form_type']) && $_POST['form_type'] == "user_logout"){
                logoutUser();
            }
        ?>
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
        <!-- Login modal - Ende -->
        <!-- Register modal -->
        <?php 
            // Register User 
            if(isset($_POST['form_type']) && $_POST['form_type'] == "user_register" && isset($_POST['vname']) && isset($_POST['nname']) && isset($_POST['mail']) && isset($_POST['passwd']) && isset($_POST['passwd2']) && isset($_POST['address']) && $_POST['passwd'] == $_POST['passwd2']){
                $registerSuccess = registerUser($_POST['vname'], $_POST['nname'], $_POST['mail'], $_POST['passwd'], $_POST['address'], $_POST['ort'], $_POST['zip']);
            }
        ?>
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
                                            <input type="text" class="form-control bg-dark text-light" id="ort" name="ort" placeholder="Ort">
                                            <label for="ort" class="form-label">Ort</label>
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
        <!-- Register modal - Ende -->
    </nav>
    <!-- Navbar - Ende -->

    <!-- Alerts -->
    <?php if (isset($loginSuccess) && $loginSuccess == True): ?>
        <div class="container my-3">
            <div class="alert alert-success" role="alert">
                Login Erfogreich!
            </div>
        </div>
    <?php elseif (isset($loginSuccess) && $loginSuccess == False): ?>
        <div class="container my-3">
            <div class="alert alert-danger d-flex align-items-center pt-2" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>Login fehlgeschlagen. Überprüfe deinen Benutzername oder Passwort!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php elseif (isset($registerSuccess) && $registerSuccess == True): ?>
        <div class="container my-3">
            <div class="alert alert-success d-flex align-items-center pt-2" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>Registierung Erfogreich!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php elseif (isset($registerSuccess) && $registerSuccess == False): ?>
        <div class="container my-3">
            <div class="alert alert-danger d-flex align-items-center pt-2" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>Registierung fehlgeschlagen. Überprüfe deine Angaben!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php elseif (isset($logoutSuccess) && $logoutSuccess == True): ?>
        <div class="container my-3">
            <div class="alert alert-success d-flex align-items-center pt-2" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>Logout Erfogreich!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php elseif (isset($logoutSuccess) && $logoutSuccess == False): ?>
        <div class="container my-3">
            <div class="alert alert-danger d-flex align-items-center pt-2" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>Logout fehlgeschlagen.</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    <!-- Alerts - Ende -->


</div>
