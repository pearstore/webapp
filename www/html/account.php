<?php
require_once('_function.php');
require_once('_global.php');
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Pearstore - account</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/assets/pictures/icon/icon.png">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<?php 
$result = mysql_execute("SELECT * FROM Bestpos bp JOIN Bestellung b ON bp.BID = b.BID WHERE BNR = ?;", "i", [1]);
$DATA = $result->fetch_all(MYSQLI_ASSOC);

$bestellungen = [];
foreach($DATA as $d) {
    if(!isset($bestellungen[$d["BID"]])){
        $bestellungen[$d["BID"]] = [];
    }
    $artikel = getArtikelByAnr($d["Anr"]);
    $artikel["BestNr"] = $d["BestNr"];
    $artikel['Menge'] = $d["Menge"];
    $artikel['BID'] = $d["BID"];
    array_push($bestellungen[$d["BID"]], $artikel);
}

?>

<body class="bg-white bg-gradient">
    <?php require_once("navbar.php"); ?>
    <div class="container pt-5">
        <div class="row">
            <?php if($_USER == False): ?>
                <div class="alert alert-danger d-flex align-items-center pt-2" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>Bitte anmelden!</div>
                </div>
            <?php else: ?>  
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <img class="border border-white border-1 rounded-circle" src="<?php echo("https://www.gravatar.com/avatar/" . md5( strtolower( trim( $_USER["Email"] ) ) ) . "?d=identicon&s=" . 48); ?>" width="48" height="48">
                                </div>
                                <div class="col" >
                                    <h5 class="card-title"><?php print($_USER['Vorname'] . ' ' . $_USER['Nachname']); ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><?php print($_USER['Email']); ?></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <div>Lieferadresse:</div>
                                    <address class="mb-0">
                                        <?php print($_USER['Adresse']);?><br>
                                        <?php print($_USER['PLZ'] . " " . $_USER['Ort']);?><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <a href="#" class="btn btn-primary">account einstellung</a>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <?php foreach($bestellungen as $bestellung): ?>
                    <div class="card mb-3">
                        <h4 class="card-header">
                            Bestellung #<?= $bestellung[0]['BID'] ?> 
                        </h4>
                        <table class="table table-striped table-hover card-body p-0 m-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="col-1">Pos</th>
                                    <th scope="col" class="col-1">ANR</th>
                                    <th scope="col" class="col-auto">Produkt</th>
                                    <th scope="col" class="col-1">Stück</th>
                                    <th scope="col" class="col-2">Einzel(€)</th>
                                    <th scope="col" class="col-2">Gesamt(€)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $summe = 0 ?>
                                <?php foreach($bestellung as $artikel): ?>
                                    <tr>
                                        <th scope="row"><?= $artikel["BestNr"] ?></th>
                                        <td><?= $artikel["Anr"] ?></td>
                                        <td><?= $artikel['Name'] ?></td>
                                        <td class="text-end"><?= $artikel['Menge'] ?></td>
                                        <td class="text-end"><?= number_format($artikel['Preis'], 2, ',', '.') ?> €</td>
                                        <td class="text-end"><?= number_format(($artikel['Preis'] * $artikel['Menge']), 2, ',', '.') ?> €</td>
                                        <?php $summe = $summe + ($artikel['Preis'] * $artikel['Menge']) ?>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <th scope="row"colspan="5"></th></th>
                                    <td class="text-end"><b><?= number_format($summe, 2, ',', '.') ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/vue.js"></script>
    <script>
        new bootstrap.Modal(document.getElementById('loginModal'));
    </script>
</body>

</html>
