<?php require_once('function.php'); ?>
<?php
if(!isset($_GET['name'])){
    $sql = "SELECT Anr, AArtid, Preis, Name, Beschreibung FROM Artikel";
    $stmt = $_MYSQL_CONNECTION->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT Anr, AArtid, Preis, Name, Beschreibung FROM Artikel WHERE `Name` LIKE ?";
    $stmt = $_MYSQL_CONNECTION->prepare($sql);

    $name = "%".$_GET['name']."%";

    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
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
    <li class="nav-item">
        <a class="nav-link active" href="/Ware.php">Ware</a>
    </li>
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
