<?php
$link = mysqli_connect("pearshop_db","pearshop","itsstuttgart","pearstore_database");

$sql = "SELECT Anr, AArtid, Preis, Name, Beschreibung FROM Artikel";

$result = mysqli_query($link,$sql);
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <Title>Pearstore</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">

</head>


<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
  <a class="navbar-brand" href="#">PearStore</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
        </li>
</ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
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

  <br>
  <br>
    <div>
    <h2>Top Produkte:</h2>
 </div>
<section class="container" id="product">
   <div class="row">
     <?php while($row = mysqli_fetch_array($result)){?>
       <div class="col">
         <?php include 'card.php'?>
       </div>
    <?php }?>
   </div>
   <br>
</section>

<script src="assets/js/bootsrap.bundle.js"></script>
</body>
</html>
