<div class="card">
  <div class="card-titel"><?= $row['Name']?></div>
  <img src="http://placekitten.com/286/180" class="card-img-top">
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
