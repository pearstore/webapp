<!DOCTYPE html>
<html lang="de">
<?php var_dump($_POST);?>
<?php var_dump(password_hash($_POST['passwd'], PASSWORD_BCRYPT)); ?>
<head>
  <Title>Pearstore</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
    <body>
        <div class="container">
            <div class="card">
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
        <script src="assets/js/bootsrap.bundle.js"></script>
    </body>
</html>