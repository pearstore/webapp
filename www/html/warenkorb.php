<?php

require_once('_function.php');
require_once('_global.php');

$warenkorb = [];
if(isset($_COOKIE['warenkorb'])) {
    $compressedJSON = $_COOKIE['warenkorb'];
    $warenkorb = json_decode(gzinflate($compressedJSON), True);
}
if(isset($_GET['anr'])) {
    $anr = (int) $_GET['anr'];
	$artikel = getArtikelByAnr($anr);
    if(!isset($warenkorb[$anr])){
        $warenkorb[$anr] = 0;
    }
    if(isset($_GET['add'])) {
        $add = (int) $_GET['add'];
		if($warenkorb[$anr] + $add <= $artikel["Menge"]){
          $warenkorb[$anr] = $warenkorb[$anr] + $add;
		}
		
    } elseif(isset($_GET['rm'])) {
        $rm = (int) $_GET['rm'];
        $warenkorb[$anr] = $warenkorb[$anr] - $rm;
    } elseif(isset($_GET['set'])) {
        $set = (int) $_GET['set'];
        $warenkorb[$anr] = $set;
    }
    $compressedJSON = gzdeflate(json_encode($warenkorb), 9);
    setcookie('warenkorb', $compressedJSON, time()+36000);
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
            <div class="card px-0">
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
                            <td class="text-end">
                                <input type="number" id="txt-artikel<?= $artikel['Anr']; ?>" name="tentacles"
                                min="1" max="<?= $artikel['Menge'] ?>" value="<?= $artikel['count'] ?>" onchange="editEvent(event, <?= $artikel['Anr']; ?>)"></td>
                            <td class="text-end" id="td-einzel<?= $artikel['Anr']; ?>" value="<?= $artikel['Preis']; ?>"><?= number_format($artikel['Preis'], 2, ',', ' ') ?> €</td>
                            <td class="text-end" id="td-gesamt<?= $artikel['Anr']; ?>"><?= number_format(($artikel['Preis'] * $artikel['count']), 2, ',', ' ') ?> €</td>
                        </tr>
                        <?php $gesPreis += $artikel['Preis'] * $artikel['count']; ?>
                        <?php endforeach; ?>
                        <tr>
                            <th scope="row"colspan="5"></th></th>
                            <td class="text-end"><b><?= number_format($gesPreis, 2, ',', ' ') ?> €</b></td>
                        </tr>
                    </tbody>
                </table>
                <div class="card-body p-4">
                    <p class="card-text">Bestellung der Artikel:</p>
                    <a href="#" class="btn btn-primary">Kaufen</a>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/vue.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
    <script>
        function editEvent(event, anr){
            console.log($( "#txt-artikel"+anr ).val())
            console.log($( "#td-einzel"+anr ).text())
            console.log($( "#td-einzel"+anr ).attr('value'))
            console.log($( "#td-gesamt"+anr ).text())
            var a = parseInt($( "#txt-artikel"+anr ).val()) * parseInt($( "#td-einzel"+anr ).attr('value'));
            $( "#td-gesamt"+anr ).text(a + ",00 €")
        };
    </script>
</body>
</html>
