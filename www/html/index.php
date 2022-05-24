<?php
require_once('_function.php');
require_once('_global.php');

$link = mysqli_connect("pearshop_db","pearshop","itsstuttgart","pearstore_database");

$sql = "SELECT Anr, AArtid, Preis, Name, Beschreibung FROM Artikel";

$result = mysqli_query($link,$sql);
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <Title>Pearstore</title>
  <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/assets/pictures/icon/icon.png">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>


<body>
    <?php require_once("navbar.php"); ?>
    <div>
        <h2>Willkommen bei Pear</h2>
    </div>
	<?php require_once("cookie_popup.php"); ?>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
  crossorigin="anonymous">
  </script>
  <script type="text/javascript">
    $(window).on('load', function() {
        $('#Cookie').modal('show');
    });
</script>
</body>
</html>
