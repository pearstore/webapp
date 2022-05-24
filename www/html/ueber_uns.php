<?php
require_once('_function.php');
require_once('_global.php');
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

    <!-- text... -->

    <!-- wichtig -->
        <script src="/assets/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/js/vue.js"></script>
        <script>
            new bootstrap.Modal(document.getElementById('loginModal'));
        </script>
    <!-- wichtig -->
</body>
</html>
