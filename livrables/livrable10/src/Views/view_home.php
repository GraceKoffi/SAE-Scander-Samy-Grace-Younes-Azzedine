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



.carousel-caption {
    position: absolute;
    bottom: 20px; /* Ajustez selon la marge souhaitée du bas */
    left: 20px; /* Ajustez selon la marge souhaitée du bord gauche */
    text-align: left;
    color: white; /* Pour la couleur du titre */
}

.poster {
    width: 210px; /* Taille du poster */
    position: absolute; /* Positionnement absolu */
    bottom: 20px; /* Ajustez pour aligner avec le bas du carousel */
    left: 80px; /* Ajustez pour aligner avec le bord gauche du carousel */
}

.caption-title {
    position: absolute; /* Positionnement absolu */
    bottom: 80px; /* Ajustez pour aligner avec le bas du carousel */
    left: 320px; /* Ajustez en fonction de la largeur du poster plus la marge désirée */
    font-size : 300px;
}

</style>
<div class="m-4">
<h1 style="margin-top:100px">FinderCine</h1>
<p> 
Bienvenue sur FinderCine, votre nouvelle destination incontournable pour tous les cinéphiles ! Tout comme IMDB, FinderCine vous propose un univers complet dédié au cinéma et à la télévision, où vous pouvez explorer une base de données exhaustive de films, séries TV, acteurs, réalisateurs, et bien plus encore. Que vous cherchiez à découvrir les dernières sorties, à vous plonger dans les critiques des œuvres ou à trouver des recommandations personnalisées selon vos goûts, FinderCine est l'outil parfait pour satisfaire votre passion pour le septième art. Avec une interface conviviale et des fonctionnalités innovantes, nous vous offrons une expérience immersive et enrichissante, vous permettant de rester au courant des tendances actuelles, de participer à des discussions animées avec une communauté de passionnés, et de suivre vos créateurs favoris. Rejoignez-nous sur FinderCine et commencez dès aujourd'hui votre voyage cinématographique !</p>
</div>

<?php
var_dump($caroussel[0]);
?>
<div class="col-8">
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="3500">
    <div class="carousel-inner">
        <?php foreach ($caroussel as $index => $movie) : ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img class="d-block w-100" src="https://image.tmdb.org/t/p/w1280<?= $movie['backdrop_path'] ?>" alt="Slide <?= $index + 1 ?>">
                <div class="carousel-caption d-none d-md-block">
                    <div class="caption-poster">
                        <img src="https://image.tmdb.org/t/p/w500<?= $movie['poster_path'] ?>" alt="<?= $movie['title'] ?> Poster" class="poster">
                    </div>
                    <div class="caption-title">
                        <h5><?= $movie['title'] ?></h5>
                    </div>
                </div>
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