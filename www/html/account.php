<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <Title>Pearstore</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>

<body class="bg-white bg-gradient">
    <?php require_once("navbar.php"); ?>
    <div class="container">
        <div class="card mt-3">
            <div class="card-body"> 
            </div>
        </div>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
</body>

</html>