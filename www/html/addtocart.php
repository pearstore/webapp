<?php 
require_once('_function.php');
require_once('_global.php');

$anr = (int) $_GET['anr'];
$artikel = getArtikelByAnr($anr);
$menge = (int) $_GET['add'];

$warenkorb = [];
if(isset($_COOKIE['warenkorb'])) {
    $JSON = $_COOKIE['warenkorb'];
    $warenkorb = json_decode($JSON, True);
}
if(isset($_GET['anr'])) {
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
    $JSON = json_encode($warenkorb);
    setcookie('warenkorb', $JSON, time()+36000, "/");
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <Title>Pearstore - Add to Cart</title>
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
                    Zu Warenkorb hizugefügt:
                </h4>
                
                <div class="card-body m-0 container">
                    <div class="row">
                        <div class="col-sm-4">
                            <img src="\assets\pictures\<?= $artikel['Name'] ?>.jpg" class="card-img border-0 my-auto px-1" alt="">
                        </div>
                        <div class="col-sm-8">
                        <div class="text-center">           
                            Es wurden <?= $menge ?>x <?= $artikel['Name'] ?> zum Warenkorb hinzugefügt.
                        </div>
                        </div>
                    </div>
                </div>
                    
                <div class="card-body p-4">
                    <p class="card-text">Wohin möchten Sie jetzt?</p>
                    <a href="/ware.php" class="btn btn-secondary">Zurück zur Ware</a>
                    <a href="/warenkorb.php" class="btn btn-primary">Zur Bestellung</a>
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