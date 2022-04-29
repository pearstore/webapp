<div class="card h-100" >
  <div class="card-header"><?= $row['Name']?></div>
  <img src="\assets\pictures\<?= $row['Name'] ?>.jpg" class="card-img border-0 my-auto px-3">
  <!--div class="card-body mb-auto"></div-->
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><?= $row['Beschreibung'] ?></li>
    <li class="list-group-item"><?= number_format($row['Preis'], 2, ',', ' ') ?> €</li>
	<li class="list-group-item">Menge <?= $row['Menge'] ?></li>
  </ul>
  <form action="warenkorb.php" method="get" class="card-footer">
    <a href="/warenkorb.php" class="btn btn-primary btn-sm">Details</a>
    <input type="hidden" name="anr" value="<?= $row['Anr']?>">
    <input type="hidden" name="add" value="1">

    <button class="btn btn-success btn-sm">Hinzufügen</button>

  </form>
</div>
