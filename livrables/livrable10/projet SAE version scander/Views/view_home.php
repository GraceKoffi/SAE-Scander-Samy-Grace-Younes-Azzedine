<?php require "Views/view_navbar.php"; ?>

<style>

.scrolling-container {
    /* Position relative pour permettre le positionnement absolu des boutons de défilement */
    position: relative;
}

/* Style pour le conteneur de défilement */
.scrolling-wrapper {
    /* Permettre le défilement horizontal */
    overflow-x: scroll;
    /* Désactiver le défilement vertical */
    overflow-y: hidden;
    /* Permettre aux éléments de s'afficher en ligne */
    white-space: nowrap;
}

/* Style pour les cartes de films dans le conteneur de défilement */
.scrolling-wrapper .card {
    /* Afficher les cartes en ligne */
    display: inline-block;
}

/* Style pour les boutons de défilement */
.scroll-btn {
    /* Positionnement absolu par rapport au conteneur de la section des films */
    position: absolute;
    /* Centrer verticalement le bouton */
    top: 50%;
    /* Décaler le bouton de moitié sa hauteur pour le centrer parfaitement */
    transform: translateY(-50%);
    /* Les boutons sont transparents par défaut */
    opacity: 0;
    /* Transition pour l'opacité */
    transition: opacity 0.5s;
}

/* Positionnement spécifique pour le bouton gauche */
.scroll-btn.left {
    /* Positionner à gauche */
    left: 0;
}

/* Positionnement spécifique pour le bouton droit */
.scroll-btn.right {
    /* Positionner à droite */
    right: 0;
}

/* Style pour les boutons de défilement lors du survol de la section des films */
.films-section:hover .scroll-btn {
    /* Les boutons deviennent visibles lors du survol */
    opacity: 1;
}
.composent-card {
    background-color: #333; /* Gris foncé */
    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23); /* Effet d'ombre 3D */
    margin: 20px; /* Espacement entre les cartes */
    transition: transform 0.3s, border 0.3s; /* Ajout de la transition pour la bordure */
}

.composent-card:hover {
    transform: scale(1.1);
    border: 2px solid white; /* Encadrement blanc lors du survol */
}

.card-title {
    color: white; /* Titre en blanc */
    font-family: 'Comic Sans MS', cursive, sans-serif; /* Une écriture sympa */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.card-subtitle {
    font-size: 0.8em; /* Plus petit */
    font-weight: lighter; /* Plus fin */
}

.star {
    width: 20px; /* Ajustez selon la taille de votre image */
}

.note {
    color: yellow; /* Note en jaune */
}

body {
    background: linear-gradient(to bottom, #0c0c0c, #1f1f1f); /* Dégradé du noir (#0c0c0c) vers le blanc (#1f1f1f) */
    margin: 0;
    font-family: 'Calibri', sans-serif;
    color: white;
}


</style>

<?php
$api_key = "9e1d1a23472226616cfee404c0fd33c1";
$url = "https://api.themoviedb.org/3/movie/now_playing?api_key=" . $api_key;

// Utilisation de cURL pour récupérer les films actuellement en salle
$movie_data = file_get_contents($url);

$movies = json_decode($movie_data, true)['results'];

$tab_poster = [];

// Parcourir la liste des films
foreach ($movies as $movie) {
    $backdrop_path = $movie['backdrop_path'];
    $tab_poster[] = $backdrop_path;
}
?>

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="3500">
    <div class="carousel-inner">
        <?php foreach ($tab_poster as $index => $poster) : ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img class="d-block w-100" style="width: auto; height: auto;" src="https://image.tmdb.org/t/p/w1280<?= $poster ?>" alt="Slide <?= $index + 1 ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<?php

$genres = [
    'Action' => 28,
    
];

foreach ($genres as $genre_name => $genre_id) {
    $movies = get_movies($genre_id, $api_key);

    echo '<div class="container mt-4 films-section">';
    echo '<h5>' . $genre_name . '</h5>';
    echo '<div class="scrolling-container">';
    echo '<div class="scrolling-wrapper">';

    foreach ($movies as $movie) {
        $tmdb_id = $movie['id'];
        $imdb_id = get_imdb_id($tmdb_id, $api_key);  // Fonction pour obtenir l'ID IMDB
        $poster_path = $movie['poster_path'];

        echo '<a href="?controller=home&action=information_movie&id=' . $imdb_id . '"  class="card composent-card" style="width: 200px;">';
        echo '<img src="https://image.tmdb.org/t/p/w500' . $poster_path . '" alt="Poster" class="card-img-top">';
        echo '<div class="card-body">';
        echo '<img src="./images/star.png" alt="Star" class="star">';
        echo '<span class="note">' . $movie['vote_average'] . '</span>';
        echo '<h6 class="card-subtitle mb-2 text-muted">  sodksodks skdskdsl</h6>';
       
    
        echo '<h5 class="card-title">' . $movie['title'] . '</h5>';
        echo '</div>';
        echo '</a>';
    }

    echo '</div>';
    echo '<button class="scroll-btn left"><</button>';
    echo '<button class="scroll-btn right">></button>';
    echo '</div>';
    echo '</div>';

    
}



function get_movies($genre_id, $api_key) {//recup une liste au hasard en 1 50 de film avec le genre concernet 
 
    $allMovies = [];
    $minPage = 1;
    $maxPage = 50;
    $page = rand($minPage, $maxPage);

    $url = "https://api.themoviedb.org/3/discover/movie?api_key={$api_key}&include_adult=false&with_genres={$genre_id}&page={$page}";

    // $ch = curl_init($url);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $response = curl_exec($ch);
    // curl_close($ch);
    $response = file_get_contents($url);
    $movies = json_decode($response, true)['results'];
    return $allMovies = array_merge($allMovies, $movies);
}


function get_imdb_id($tmdb_id, $api_key) {//recup idImdb avec id tmdb
    $url = "https://api.themoviedb.org/3/movie/{$tmdb_id}?api_key={$api_key}";

    // $ch = curl_init($url);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $response = curl_exec($ch);
    // curl_close($ch);
    $response = file_get_contents($url);
    $movie = json_decode($response, true);
    return $movie['imdb_id'];
}

?>



    <script><?=require "Js/home.js"; ?></script>
    <?php require "Views/view_footer.php"; ?>