<?php

require_once('_function.php');
require_once('_global.php');

if(!isset($_GET['name'])){
    $result = mysql_select(
        "SELECT Anr, AArtid, Preis, `Name`, Beschreibung FROM Artikel order by Preis;"
    );
} else {
    $result = mysql_select(
        "SELECT Anr, AArtid, Preis, `Name`, Beschreibung FROM Artikel WHERE `Name` LIKE ?;",
        "s",
        ["%".$_GET['name']."%"]
    );
}
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

    <section class="container" id="product">
    <div class="row">
        <?php while($row = $result->fetch_array(MYSQLI_ASSOC)): ?>
        <div class="col-3 mb-4">
            <?php include('card.php'); ?>
        </div>
        <?php endwhile; ?>
    </div>
    <br>
    </section>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
</body>
</html>
