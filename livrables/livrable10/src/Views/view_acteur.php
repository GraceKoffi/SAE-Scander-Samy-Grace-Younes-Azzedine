<?php require "Views/view_navbar.php"; ?>
<style>
body {
    background: linear-gradient(to bottom, #0c0c0c, #1f1f1f); /* Dégradé du noir (#0c0c0c) vers le blanc (#1f1f1f) */
    margin: 0;
    font-family: 'Calibri', sans-serif;
    color: white;
}
.container-fluid {
    position: relative;
}

.composent-card {
    background-color: #333; /* Gris foncé */
    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23); /* Effet d'ombre 3D */
    margin: 10px; /* Espacement entre les cartes */
    transition: transform 0.3s, border 0.3s; /* Ajout de la transition pour la bordure */
    
}

.composent-card:hover {
    transform: scale(1.1);
    border: 2px solid white; /* Encadrement blanc lors du survol */
}

.card-title {
    color: white; /* Titre en blanc */
    font-size: 17px;/*taille de la police*/
}


</style>


<?php 
$api_key = "9e1d1a23472226616cfee404c0fd33c1";
$id_acteur = '';
if(isset($_GET['id'])){
    $id_acteur = $_GET['id'];
} 
else if(isset($_GET['acteurId'])){
    $id_acteur = $_GET['acteurId'];
}
$url = "https://api.themoviedb.org/3/find/{$id_acteur}?api_key={$api_key}&external_source=imdb_id";
        


$response = file_get_contents($url);
$data = json_decode($response);
$portrait= null;
$sexe=null;
$biographie=null;

if (isset($data->person_results[0]->profile_path) && $data->person_results[0]->profile_path !== null) {
    $portrait = $data->person_results[0]->profile_path;
}
if (isset($data->person_results[0]->gender) && $data->person_results[0]->gender !== null) {
   if ($data->person_results[0]->gender==2){

    $sexe="Homme";
   }
   else{
$sexe="Femme";

   }
}

  ?>  
    
    

    <div class="container-fluid position-relative px-0 mt-5">
    <div class="row">
       <div class="info-container">
                <div class="row">
                    <div class="col-md-5">
                        <img class="mx-auto" src="https://image.tmdb.org/t/p/w400<?= $portrait ?>" alt="Portrait">
                    </div>
                    <div class="col-md-7">
                    <h2><?= $info['primaryname']; ?></h2>
                    <h3><?= $info['birthyear']; ?></h3>
                    <h3><?= $info['deathyear']; ?></h3>
                    <h3><?= $info['primaryprofession']; ?></h3>
                      
             <p><?= $sexe; ?></p>  
                       
                    </div>
                </div>
            </div>
    </div>
</div>
<?php
if (isset($_SESSION['username'])) {
     // Récupérez la valeur de filmId depuis l'URL
    $favori = isset($_SESSION['favori']) ? $_SESSION['favori'] : 'false';
    $texteBouton = ($favori === 'true') ? 'Retirer Favori' : 'Ajouter Favori';
    $couleurBouton = ($favori === 'true') ? 'yellow' : 'white';
    echo "
    <div class='film' data-favori='$favori'>
        <h2 id='titreFilm'>Mon Film Préféré</h2>
        <a href='?controller=home&action=favorie_acteur&acteurId=$id_imdb'>
            <button id='favoriButton' class='bouton-favori' style='background-color: $couleurBouton;'>$texteBouton</button>
        </a>
    </div>
    ";
}
?>

<div class="container mt-4">
    <div class="row">
        <?php foreach($titre as $v) : ?>
            <?php 
                $id_film = $v['tconst'];
                $url = "https://api.themoviedb.org/3/find/{$id_film}?api_key={$api_key}&external_source=imdb_id";

            
                $response = file_get_contents($url);
                $data = json_decode($response);
                $portrait_film = null;
                $results = array_merge($data->movie_results, $data->tv_results, $data->tv_episode_results, $data->tv_season_results);

                foreach ($results as $result) {
                    if (isset($result->poster_path) && $result->poster_path!== null) {
                        $portrait_film = $result->poster_path;
                        break;  // Sortir de la boucle dès qu'une valeur est trouvée
                    }
                }
               
            ?>
            <div class="col-md-3 custom-card d-flex align-items-stretch"> <!-- Choisissez la classe de colonne Bootstrap en fonction de votre mise en page -->
            <a href="?controller=home&action=information_movie&id=<?php echo $id_film; ?>" class="card composent-card" style="width: 200px;">
                    <img src="https://image.tmdb.org/t/p/w500<?= $portrait_film ?>" alt="Poster" class="card-img-top">
                    <div class="card-body">
                        <h2 class="card-title"><?= $v['primarytitle'] ?></h2>
                       
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>






<?php require "Views/view_footer.php"; ?>