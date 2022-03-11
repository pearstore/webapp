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
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Pearstore</a>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            Warenkorb ()
          </li>
        </ul>
    </div>
  </nav>
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
