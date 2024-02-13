<?php require "Views/view_navbar.php"; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

.film {
    /* Styles de base pour tous les films */
    padding: 20px;
    border: 1px solid #ccc;
}

.film.favori {
    /* Styles spécifiques pour les films favoris */
    background-color: yellow; /* Couleur de fond jaune */
    color: black; /* Texte en noir */
}



</style>

<?php
$id_imdb = '';
if(isset($_GET['id'])){
    $id_imdb = $_GET['id'];
} 
else if(isset($_GET['filmId'])){
    $id_imdb = $_GET['filmId'];
}
$api_key = "9e1d1a23472226616cfee404c0fd33c1";
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

<?php
if (isset($_SESSION['username'])) {
     // Récupérez la valeur de filmId depuis l'URL
    $favori = isset($_SESSION['favori']) ? $_SESSION['favori'] : 'false';
    $texteBouton = ($favori === 'true') ? 'Retirer Favori' : 'Ajouter Favori';
    $titre = ($favori === 'true') ? 'Retirer ce film des favoris' : 'Ajouter ce film aux favoris';
    $couleurBouton = ($favori === 'true') ? 'yellow' : 'white';
    echo "
    <div class='film' data-favori='$favori'>
        <h2 id='titreFilm'>$titre</h2>
        <a href='?controller=home&action=favorie_movie&filmId=$id_imdb'>
            <button id='favoriButton' class='bouton-favori' style='background-color: $couleurBouton;'>$texteBouton</button>
        </a>
    </div>
    ";
}
?>


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

<script>
       /*
       $(document).ready(function() {
            // Écouteur d'événement pour le clic sur le bouton
            $("#favoriButton").click(function() {
                // Récupérez l'état actuel du film (favori ou non)
                const estFavori = $(".film").data("favori");

                // Effectuez l'appel Ajax ici
                $.ajax({
                    type: "GET", // Ou "GET" selon vos besoins
                    url: "?controller=home&action=favorie_movie&filmId=<?php echo $id_imdb;?>", // Remplacez par votre URL
                    data: { action: estFavori ? "supprimer" : "ajouter" }, // Données à envoyer au serveur
                    success: function(response) {
                        // Mettez à jour l'interface utilisateur en fonction de la réponse
                        if (estFavori) {
                            $(".film").data("favori", false);
                            $("#favoriButton").text("+");
                            $("#titreFilm").text("Ajouter au favori");
                            $(".film").removeClass("favori"); // Retirez la classe "favori"
                        } else {
                            $(".film").data("favori", true);
                            $("#favoriButton").text("-");
                            $("#titreFilm").text("Favori");
                            $(".film").addClass("favori"); // Ajoutez la classe "favori"
                        }
                    },
                    error: function() {
                        alert("Erreur lors de la mise à jour des favoris.");
                    }
                });
            });
        });
        */
    </script>

        <?php require "Views/view_footer.php"; ?>
