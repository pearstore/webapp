<div class="card mb-3" >
  <div class="card-titel"><?= $row['Name']?></div>
  <br>
  <img src="\assets\pictures\<?= $row['Name'] ?>.jpg" class="card h-20" class="card-img-top">
  <div class="card-body">

  <?= $row['Beschreibung'] ?>
  <hr>
  <?= $row['Preis']?>
  </div>
  <div class="card-footer">
      <a href="" class="btn btn-primary btn-sm">Details</a>
      <a href="" class="btn btn-success btn-sm">Hinzufügen</a>
  </div>
</div>
