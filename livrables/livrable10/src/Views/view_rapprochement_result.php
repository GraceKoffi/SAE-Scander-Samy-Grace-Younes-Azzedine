<?php require "Views/view_navbar.php"; ?>
<style>

</style>
<div class="row" style="margin-top: 120px;">
    <div class="col-md-8 m-5">
    <?php echo "<br>".print_r($result)."</br>"?>
        <h1>Résultats entre "<?php echo $result[0]["search1"]?>" et "<?php echo $result[0]["search2"] ?></h1>
        <p>En <?php if(round($result["data"]["time"], 1) < 60): ?>
          <?php echo round($result["data"]["time"], 1) ?> s
          <?php elseif (round($result['data']['time']) > 60): ?>
          <?php echo round($result["data"]["time"] / 60, 1) ?> m
          <?php else: ?>
          <?php echo round($result["data"]["time"] / 3600, 1) ?> h
          <?php endif; ?>
        </p>

    </div>

<div class="container">
  <div class="row align-items-center">
<?php
$m = Model::getModel();
foreach (array_unique($result['data']['path']) as $item) {
  
    echo $item . PHP_EOL;

    if ($item[0] == "n") {
        $posterPath = $m->getPersonnePhoto($item);; // Supposons que getPersonnePhoto est une fonction PHP existante
        var_dump($posterPath);
        $hrefValue = "?controller=home&action=information_acteur&id=" . $item;
        $cardContent = '<a href="' . $hrefValue . '" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
              <div class="cardrecherche" style="cursor: pointer;">
                  <img src="' . $posterPath . '" alt="' . $item . '">
                  <div class="card-bodyrecherche">
                  </div>
                  </div>';
        // Faites quelque chose avec $cardContent, par exemple, l'afficher ou le stocker dans un tableau, etc.
    }  else {
      $posterPath = $m->getFilmPhoto($item); // Supposons que getPersonnePhoto est une fonction PHP existante
      $hrefValue = "?controller=home&action=information_acteur&id=" . $item;
      $cardContent = '<a href="' . $hrefValue . '" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
            <div class="cardrecherche" style="cursor: pointer;">
                <img src="' . $posterPath . '" alt="' . $item . '">
                <div class="card-bodyrecherche">
                </div>
                </div>';
      }
    
}
?>
</div>
</div>



  
                
    
                
        
               
 <script src="Js/function.js"></script>


<?php require "Views/view_footer.php"; ?>