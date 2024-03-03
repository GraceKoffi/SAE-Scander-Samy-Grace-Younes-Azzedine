<?php require "Views/view_navbar.php"; ?>
<style>
  .item{
    margin-top:40px;
    margin-left: 10px;
    margin-right: 10px;
  }

  .relation{
    justify-items: center;
    margin-bottom: 50px;
    margin-top: 10px;
    color: yellow;
  }

  .result{
    margin-top: 20px;
  }

  .arrow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transform: rotate(90deg);
    cursor: pointer;
}


.bouton-favori{
    border-radius: 10px 5%;
    background-color: yellow;
    padding: 5px 10px;
 }


</style>
<div class="row" style="margin-top: 120px;">
    <div class="col-md-8 m-5">
        <h1>Résultats entre "<?php echo $result[0]["search1"]?>" et "<?php echo $result[0]["search2"] ?> :</h1>
        <p><?php if(round($result["data"]["time"], 1) < 60): ?>
          <?php echo "Voici le chemin le plus court trouver entre ".$result[0]['search1']." et ".$result[0]["search2"]." en ". round($result["data"]["time"], 3) ?> s
          <?php elseif (round($result['data']['time']) > 60): ?>
          <?php echo "Voici le chemin le plus court trouver entre ".$result[0]['search1']." et ".$result[0]["search2"]." en ". round($result["data"]["time"], 3) ?>  m
          <?php else: ?>
          <?php echo "Voici le chemin le plus court trouver entre ".$result[0]['search1']." et ".$result[0]["search2"]." en ". round($result["data"]["time"], 3) ?>  h
          <?php endif; ?>
          <p>
          <a href="?controller=rapprochement">
          <button id='favoriButton' class='bouton-favori'> &#8592; Realiser un nouveau rapprochement</button>
          </a>
        </p>  
        </p>

    </div>
</div>

<div class="container result">
  <div class="formulaire row align-items-center">
    <div class="mx-auto">
<?php
$m = Model::getModel();
$index = 0;
foreach (array_unique($result['data']['path']) as $item) {
    if ($item[0] == "n") {
        $infoItem = $m->getInfoActeur($item);
        $primaryName = isset($infoItem['primaryname']) ? $infoItem['primaryname'] : 'Aucune information';
        $birthDay = isset($infoItem['birthyear']) ?  $infoItem['birthyear'] : 'Aucune information';
        $primaryProfession = isset($infoItem['primaryprofession']) ? $infoItem['primaryprofession'] : 'Aucune information';
        $posterPath = $m->getPersonnePhoto($item);; // Supposons que getPersonnePhoto est une fonction PHP existante
        $hrefValue = "?controller=home&action=information_acteur&id=" . $item;
        $cardContent = '<a href="' . $hrefValue . '" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
              <div class="cardrecherche item" style="cursor: pointer;">
                  <img src="' . $posterPath . '" alt="' . $item . '">
                    <div class="card-bodyrecherche">
                    <h2 class="card-1recherche">'.$primaryName.'</h2>
                    <p class="card-2recherche">Type : '.$primaryProfession.'</p>
                    <p class="card-3recherche">Date : '.$birthDay.'</p>


                  </div>
                  </div> 
                  </a>';
        echo $cardContent;
        if($index < sizeof(array_unique($result['data']['path']))-1){
          echo "<div class='container'>
                <div class='row'>
                <div class='mx-auto'>
                  <h2 class='relation'>
                  <img src='Images/icons8-double-bas-96.png'>
                  </h2>
                  
                </div>
                </div>
                </div>
          ";
        }

    }  else {
      $infoItem = $m->getInfoFilm($item);
      $primaryTitle = isset($infoItem['primarytitle']) ? $infoItem['primarytitle'] : 'Aucune information';
      $titleType = isset($infoItem['titletype']) ? $infoItem['titletype'] : 'Aucune information';
      $startYear = isset($infoItem['startyear']) ? $infoItem['startyear'] : 'Aucune information';
      $genres = isset($infoItem['genres']) ? $infoItem['genres'] : 'Aucune information';
      $posterPath = $m->getFilmPhoto($item); // Supposons que getPersonnePhoto est une fonction PHP existante
      $hrefValue = "?controller=home&action=information_movie&id=" . $item;
      $cardContent = '<a href="' . $hrefValue . '" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
            <div class="cardrecherche item" style="cursor: pointer;">
                <img src="' . $posterPath . '" alt="' . $item . '">
                <div class="card-bodyrecherche">
                <h2 class="card-1recherche">'.$primaryTitle.'</h2>
                <p class="card-2recherche">Type : '.$titleType.'</p>
                <p class="card-3recherche">Date : '.$startYear.'</p>
                <p class="card-4recherche">Genres : '.$genres.'</p>
                </div>
                </div> 
                </a>';
        echo $cardContent;
        if($index < sizeof(array_unique($result['data']['path']))-1){
          echo "<div class='container'>
                <div class='row'>
                <div class='mx-auto'>
                <h2 class='relation'>
                <img src='Images/icons8-double-bas-96.png'>
                </h2>
                </div>
                </div>
                </div>
          ";
        }
      }
      $index++;
    
}
?>
</div>
</div>
</div>

<div class ="m-5" style ="border-left:2px solid #FFCC00; padding-left: 6px;" id="count">
<p>Résultat : <?php echo sizeof($result['data']['path'])-2?></p>
</div>

        
               
 <script src="Js/function.js"></script>


<?php require "Views/view_footer.php"; ?>