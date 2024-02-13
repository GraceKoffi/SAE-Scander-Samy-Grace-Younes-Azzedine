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

.info-container {
    position: absolute;
    bottom: 0;
    left: 0;
    color: white;
    padding: 80px;
}
.composent-card {
    background-color: #333; /* Gris foncé */
    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23); /* Effet d'ombre 3D */
    margin: 40px; /* Espacement entre les cartes */
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
$id_imdb = $_GET['id'];
$url = "https://api.themoviedb.org/3/find/{$id_imdb}?api_key={$api_key}&external_source=imdb_id&language=fr";

$response = file_get_contents($url);
$data = json_decode($response);
$couverture = null;
$portait= null;
$overview= null;



// Créez un tableau avec tous les résultats que vous voulez vérifier
$results = array_merge($data->movie_results, $data->tv_results, $data->tv_episode_results, $data->tv_season_results);

foreach ($results as $result) {
    if (isset($result->backdrop_path) && $result->backdrop_path !== null) {
        $couverture = $result->backdrop_path;
        break;  // Sortir de la boucle dès qu'une valeur est trouvée
    }
    if (isset($result->still_path) && $result->still_path!== null) {
        $couverture = $result->still_path;
        break;  // Sortir de la boucle dès qu'une valeur est trouvée
    }
}
foreach ($results as $result) {
    if (isset($result->poster_path) && $result->poster_path!== null) {
        $portrait = $result->poster_path;
        break;  // Sortir de la boucle dès qu'une valeur est trouvée
    }
    if (isset($result->still_path) && $result->still_path!== null) {
        $portrait = $result->still_path;
        break;  // Sortir de la boucle dès qu'une valeur est trouvée
    }
}

foreach ($results as $result) {
    if (isset($result->overview) && $result->overview !== null) {
        $overview = $result->overview;
        break;  // Sortir de la boucle dès qu'une valeur est trouvée
    }
}







?>
 


 <div class="container-fluid position-relative px-0">
    <div class="row">
        <div class="col-md-12">
            <img class="img-fluid w-100" src="https://image.tmdb.org/t/p/w1280<?= $couverture ?>" alt="Couverture" style="filter: opacity(70%) brightness(15%);">
            <div class="info-container">
                <div class="row">
                    <div class="col-md-3">
                        <img class="mx-auto" src="https://image.tmdb.org/t/p/w400<?= $portrait ?>" alt="Portrait">
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                    <h1><?= ($info['primarytitle'] !== null) ? $info['primarytitle'] : 'Inconnu'; ?></h1>
<h2> <?= ($info['runtimeminutes'] !== null) ? $info['runtimeminutes'] . ' minutes' : 'Inconnu'; ?> - <?= ($info['startyear'] !== null) ? $info['startyear'] : 'Inconnu'; ?>
</h2>
<h3><?= ($info['genres'] !== null) ? $info['genres'] : 'Inconnu'; ?></h3>
<h3><?= ($info['averagerating'] !== null) ? $info['averagerating'] : 'Inconnu'; ?></h3>
<h3>
    <?php
    if (is_array($realisateur) && array_key_exists('realisateur', $realisateur)) {
        echo ($realisateur['realisateur'] == null) ? "Inconnu" : $realisateur['realisateur'];
    } else {
        echo "Inconnu";
    }
    ?>
</h3>
<p><?= ($overview !== null) ? $overview : 'Inconnu'; ?></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <?php foreach($acteur as $v) : ?>
            <?php 
                $id_acteur = $v['nconst'];
                $url = "https://api.themoviedb.org/3/find/{$id_acteur}?api_key={$api_key}&external_source=imdb_id";

                // $ch = curl_init($url);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // $response = curl_exec($ch);
                // curl_close($ch);

                $response = file_get_contents($url);
                $data = json_decode($response);
                $profilePath = null;
                $id_api=null;
                if (isset($data->person_results[0]->profile_path) && $data->person_results[0]->profile_path !== null) {
                    $profilePath = $data->person_results[0]->profile_path;
                }
                if (isset($data->person_results[0]->id) && $data->person_results[0]->id !== null) {
                    $id_api = $data->person_results[0]->id;
                }
            ?>
            <div class="col-md-3 custom-card d-flex align-items-stretch"> <!-- Choisissez la classe de colonne Bootstrap en fonction de votre mise en page -->
            <a href="?controller=home&action=information_acteur&id=<?php echo $id_acteur; ?>&id_api=<?php echo $id_api; ?>" class="card composent-card" style="width: 200px;">
            <?php $imageSrc = ($profilePath !== null) ? "https://image.tmdb.org/t/p/w500{$profilePath}" : "./Images/depannage.jpg"; ?>
            <img src="<?php echo $imageSrc; ?>" alt="Poster" class="card-img-top">                          <div class="card-body">
                        <h2 class="card-title"><?= $v['nomacteur'] ?></h2>
                        <h3 class="card-title"><?= $v['dateacteur'] ?></h3>
                        <h4 class="card-title"><?= $v['nomdescene'] ?></h4>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php var_dump($info);?>
<script><?=require "Js/informations.js"; ?></script>

        <?php require "Views/view_footer.php"; ?>
