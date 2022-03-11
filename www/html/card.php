<div class="card">
  <div class="card-titel"><?= $row['Name']?></div>
  <img src="\assets\pictures\pexels-nana-dua-8622912.jpg" class="card-img-top">
  <div class="card h-30">
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
