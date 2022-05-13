<?php

require_once('_function.php');
require_once('_global.php');

if(isset($_GET['name'])){
    $find_name = "%".$_GET['name']."%";
} else {
    $find_name = "%";
}
$artikel = mysql_select(
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
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
            <?php foreach ($artikel as $row): ?>  
                <!-- Start Card -->
                <a class="card rounded-0" data-bs-toggle="modal" href="#anr<?= $row['Anr'] ?>">
                    <img src="\assets\pictures\<?= $row['Name'] ?>.jpg" class="card-img border-0 my-auto px-1" alt="">
                    <ul class="list-group list-group-flush border-0 text-center px-3">
                        <li class="list-group-item"><?= $row['Name'] ?></li>
                        <li class="list-group-item"><?= number_format($row['Preis'], 2, ',', ' ') ?> €</li>
                        <li class="list-group-item">Menge <?= $row['Menge'] ?></li>
                    </ul>
                </a>
                <!-- End Card -->
                <!-- Start Modal -->
                <div class="modal fade" id="anr<?= $row['Anr'] ?>" tabindex="-1" aria-labelledby="anr<?= $row['Anr'] ?>Label" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="anr<?= $row['Anr'] ?>Label"><?= $row['Name'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
            <?php endforeach; ?>
        </div>
    </section>

    <!--section class="container" id="product">
    <div class="row">
        <?php // foreach ($artikel as $row): ?>
        <div class="col-3 mb-4">
            <?php // include('card.php'); ?>
        </div>
        <?php // endforeach; ?>
    </div>
    <br>
    </section-->

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
</body>
</html>
