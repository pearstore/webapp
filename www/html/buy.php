<?php

require_once('_function.php');
require_once('_global.php');

$warenkorb = [];
if(isset($_COOKIE['warenkorb'])) {
    $compressedJSON = $_COOKIE['warenkorb'];
    $warenkorb = json_decode(gzinflate($compressedJSON), True);
}

$warenkorbArtikel = [];
foreach($warenkorb as $anr => $count){
    $artikel = getArtikelByAnr($anr);
    $artikel['count'] = $count;
    array_push($warenkorbArtikel, $artikel);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <Title>Pearstore - Warenkorb</title>
  <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/assets/pictures/icon/icon.png">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>


<body>
    <?php require_once("navbar.php"); ?>
    <div class="container pt-5">
        <div class="row">
            <?php if(getUserbySession() != False): ?>
            <div class="card px-0 mb-4">
                <h4 class="card-header">
                    Warenkorb
                </h4>
                <table class="table table-striped table-hover card-body m-0">
                    <thead>
                        <tr>
                            <th scope="col" class="col-1">Pos</th>
                            <th scope="col" class="col-auto">ANR</th>
                            <th scope="col" class="col-auto">Produkt</th>
                            <th scope="col" class="col-1 text-end">Stück</th>
                            <th scope="col" class="col-2 text-end">Einzel (€)</th>
                            <th scope="col" class="col-2 text-end">Gesamt (€)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $gesPreis = 0; ?>
                        <?php foreach($warenkorbArtikel as $pos => $artikel): ?>
                        <tr>
                            <th scope="row"><?= $pos+1 ?></th>
                            <td><?= $artikel['Anr'] ?></td>
                            <td><?= $artikel['Name'] ?></td>
                            <td class="text-end"><?= $artikel['count'] ?></td>
                            <td class="text-end"><?= number_format($artikel['Preis'], 2, ',', '.') ?> €</td>
                            <td class="text-end"><?= number_format(($artikel['Preis'] * $artikel['count']), 2, ',', '.') ?> €</td>
                        </tr>
                        <?php $gesPreis += $artikel['Preis'] * $artikel['count']; ?>
                        <?php endforeach; ?>
                        <tr>
                            <th scope="row"colspan="5"></th></th>
                            <td class="text-end"><b><?= number_format($gesPreis, 2, ',', '.') ?> €</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card px-0 mb-4">
                <h4 class="card-header">
                    Kreditkarte
                </h4>
                <form class="card-body m-0">
                    <div class="mb-3">
                        <label for="kkn" class="form-label">Kreditkartennummer</label>
                        <input type="text" class="form-control" id="kkn">
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="pz" class="form-label">Prüfziffer</label>
                            <input type="text" class="form-control" id="pz">
                        </div>
                        <div class="col">
                            <label for="ad" class="form-label">Ablaufdatum</label>
                            <input type="date" class="form-control" id="ad">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/vue.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
</body>
</html>
