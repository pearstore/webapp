<?php require_once('function.php'); ?>
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
    <?php require_once("navbar.php"); ?>


    <section class="container" id="product">
    <div class="row">
        <?php while($row = mysqli_fetch_array($result)){?>
        <div class="col-3">
            <?php include 'card.php'?>
        </div>
        <?php }?>
    </div>
    <br>
    </section>
    
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
</body>
</html>
