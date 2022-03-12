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
    <?php var_dump($user); ?>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-auto">
                            <img class="border border-white border-1 rounded-circle" src="<?php echo("https://www.gravatar.com/avatar/" . md5( strtolower( trim( $user["Email"] ) ) ) . "?d=identicon&s=" . 48); ?>" width="48" height="48">
                        </div>
                        <div class="col" >
                            <h5 class="card-title"><?php print($user['Vorname'] . ' ' . $user['Nachname']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php print($user['Email']); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <h4 class="card-header">
                        Bestellung #1
                    </h4>
                    <table class="table table-striped table-hover card-body p-0 m-0">
                        <thead>
                            <tr>
                                <th scope="col" class="col-1">Pos</th>
                                <th scope="col" class="col-auto">Produkt</th>
                                <th scope="col" class="col-1">Stück</th>
                                <th scope="col" class="col-2">Einzel(€)</th>
                                <th scope="col" class="col-2">Gesamt(€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>test 1</td>
                                <td>2</td>
                                <td>75,00</td>
                                <td>150,00</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>test 2</td>
                                <td>1</td>
                                <td>100,00</td>
                                <td>100,00</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>test 3</td>
                                <td>5</td>
                                <td>10,00</td>
                                <td>50,00</td>
                            </tr>
                            <tr>
                                <th scope="row"colspan="4"></th></th>
                                <td><b>50,00</b></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="card-body p-4">
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
</body>

</html>