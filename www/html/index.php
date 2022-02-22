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

  <header class ="Jumbotron">
    <div class="container">
      <h1>Welcome to Pear</h1>
    </div>
  </header>
  <hr>
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

</section>

<script src="assets/js/bootsrap.bundle.js"></script>
</body>
</html>
