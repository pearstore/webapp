<div class="card" >
  <div class="card-titel"><?= $row['Name']?></div>
  <br>
  <img src="\assets\pictures\pexels-nana-dua-8622912.jpg" width="300" height="200"  class="card h-20" class="card-img-top">
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
