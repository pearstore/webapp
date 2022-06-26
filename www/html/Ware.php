<?php

require_once('_function.php');
require_once('_global.php');

if (isset($_GET['name'])) {
    $find_name = "%" . $_GET['name'] . "%";
} else {
    $find_name = "%";
}
$artikelListe = mysql_execute(
    "SELECT Anr, AArtid, Preis, `Name`, Beschreibung, Menge FROM Artikel WHERE `Name` LIKE ?;",
    "s",
    [$find_name]
)->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <Title>Pearstore - ware</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/assets/pictures/icon/icon.png">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>


<body>
    <?php require_once("navbar.php"); ?>

    <section class="container-fluid pb-0 px-0" id="product">
        <div class="p-5 bg-light border-secondary border-bottom rounded-0">
            <div class="container py-1">
                <h1 class="display-5 fw-bold">Hardware</h1>
            </div>
        </div>
    </section>
    <section class="container-fluid pb-5" id="product">
        <div class="row row-cols-1 row-cols-md-4">
            <?php foreach ($artikelListe as $artikel) : ?>
                <!-- Start Card -->
                <a class="card rounded-0" data-bs-toggle="modal" href="#anr<?= $artikel['Anr'] ?>">
                    <img src="\assets\pictures\<?= $artikel['Name'] ?>.jpg" class="card-img border-0 my-auto px-1" alt="">
                    <ul class="list-group list-group-flush border-0 text-center px-3">
                        <li class="list-group-item"><?= $artikel['Name'] ?></li>
                        <li class="list-group-item"><?= number_format($artikel['Preis'], 2, ',', ' ') ?> €</li>
                        <li class="list-group-item">Menge <?= $artikel['Menge'] ?></li>
                    </ul>
                </a>
                <!-- End Card -->
                <!-- Start Modal -->
                <div class="modal fade" id="anr<?= $artikel['Anr'] ?>" tabindex="-1" aria-labelledby="anr<?= $artikel['Anr'] ?>Label" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="anr<?= $artikel['Anr'] ?>Label"><?= $artikel['Name'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body container">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <img src="\assets\pictures\<?= $artikel['Name'] ?>.jpg" class="card-img border-0 my-auto px-1" alt="">
                                    </div>
                                    <div class="col-sm-8">
                                    <div class="text-center">           
                                    <?= $artikel['Beschreibung'] ?>     <!--gibt die jeweilige Beschreibung der Produkte aus -->
                                  </div>
                                    </div>
                                </div>
                            </div>
                            <form action="addtocart.php" method="get" class="modal-footer">
                                <input type="hidden" name="anr" value="<?= $artikel['Anr'] ?>">
                                <input type="hidden" name="add" value="1">

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="menge" aria-describedby="button-addon2" name="add" id="txt-artikel<?= $artikel['Anr'] ?>">
                                    <button class="btn btn-outline-secondary" type="submit" >Hinzufügen</button> <?php /* onclick="addEvent(event, <?= $artikel['Anr'] ?>);" */ ?>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
            <?php endforeach; ?>
        </div>
    </section>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/vue.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
</body>

</html>
