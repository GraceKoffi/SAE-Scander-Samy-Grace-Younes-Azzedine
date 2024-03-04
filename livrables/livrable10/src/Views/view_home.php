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


.scroll-btn:hover {
    opacity: 1; /* Pleine opacité au survol */
    transform: translateY(-50%) scale(1.1); /* Effet de zoom au survol */
}



/* Optionnel: style pour les icônes des boutons si vous utilisez des icônes */
.scroll-btn span {
    display: inline-block;
    /* Styles pour ajuster l'icône si nécessaire */
}
/* Style initial pour les boutons de défilement: invisibles */
.scroll-btn {
    opacity: 0;
    visibility: hidden; /* Ajoutez visibility pour un retrait complet */
    transition: opacity 0.5s, visibility 0.5s; /* Assurez-vous d'inclure visibility dans la transition */
}

/* Faire apparaître les boutons uniquement lors du survol du conteneur de défilement */
.scrolling-container:hover .scroll-btn {
    opacity: 1;
    visibility: visible; /* Les rend visible */
}

/* Styles supplémentaires pour les boutons (comme précédemment) */
.scroll-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: transparent; /* Par exemple, une couleur de fond jaune */
    color: #FFCC00; 
    border: none;
    cursor: pointer;
    z-index: 10;
    
}

.scroll-btn.left {
    left: 0;
    margin-left: -102px;
    font-size: 55px;

}

.scroll-btn.right {
    right: 0;
    margin-right: -102px;
    font-size: 55px;
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
    border: 2px solid #FFCC00; /* Encadrement blanc lors du survol */
    text-decoration: none !important;
    color: inherit !important;
}

.card-title {
    color: white; /* Titre en blanc */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: 18px; 
}

.card-subtitle {
    font-size: 15px; 
    
}

.star {
    width: 16px; /* Ajustez selon la taille de votre image */
}
.rating {
    display: flex;
    align-items: center; /* Centre verticalement */
    gap: 5px; /* Espace entre l'étoile et la note */
}
.note {
    color: yellow; /* Note en jaune */
    font-size: 1rem;
}

body {
    background: linear-gradient(to bottom, #0c0c0c, #1f1f1f); /* Dégradé du noir (#0c0c0c) vers le blanc (#1f1f1f) */
    margin: 0;
    font-family: 'Calibri', sans-serif;
    color: white;
}



.carousel-backdrop {
    position: relative;
    filter: brightness(70%); /* Diminue la luminosité pour un effet sombre */
}

.carousel-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0)); /* Dégradé de transparent à noir */
    color: white;
    padding: 20px; /* Espace autour du contenu */
    display: flex;
    align-items: center;
    justify-content: start; /* Aligner les enfants à gauche */
    z-index: 2;
}

.poster {
    width: 180px; /* Largeur du poster */
    margin-left: 70px; /* Espace depuis le côté gauche du carrousel */
    align-self: start; /* Aligner le poster en haut du conteneur .carousel-overlay */
    margin-top: -100px; /* Positionner le poster plus haut par rapport à sa position initiale */
    margin-right: 50px; 
    z-index: 2;
}

.carousel-caption {
    left: 15%; /* Positionner le titre plus à gauche */
    bottom: 20px; /* Positionner le titre plus en bas par rapport à sa position initiale */
    right: auto; /* Désactiver la position droite par défaut */
    text-align: left; /* Aligner le texte à gauche */
    z-index: 2;
}


.carousel-item {
    position: relative;
}

/* Cela crée un effet flou sur le bas de l'image du carrousel */
.carousel-item::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 200px; /* Augmentez cette valeur pour un effet de flou plus étendu */
    background: linear-gradient(to top, rgba(0,0,0,0.9) 50%, transparent); /* Ajustez le dégradé pour plus de flou */
    z-index: 1;
}



</style>
<div class="m-4">
<h1 style="margin-top:100px">FinderCine</h1>
<p> 
Bienvenue sur FinderCine, votre nouvelle destination incontournable pour tous les cinéphiles ! Tout comme IMDB, FinderCine vous propose un univers complet dédié au cinéma et à la télévision, où vous pouvez explorer une base de données exhaustive de films, séries TV, acteurs, réalisateurs, et bien plus encore. Que vous cherchiez à découvrir les dernières sorties, à vous plonger dans les critiques des œuvres ou à trouver des recommandations personnalisées selon vos goûts, FinderCine est l'outil parfait pour satisfaire votre passion pour le septième art. Avec une interface conviviale et des fonctionnalités innovantes, nous vous offrons une expérience immersive et enrichissante, vous permettant de rester au courant des tendances actuelles, de participer à des discussions animées avec une communauté de passionnés, et de suivre vos créateurs favoris. Rejoignez-nous sur FinderCine et commencez dès aujourd'hui votre voyage cinématographique !</p>
</div>
<div class="row m-2">

<div class="col-8">

<h3 class="m-4" style="border-left:2px solid #FFCC00;padding-left: 6px;"> Populaire </h3>
    <div id="carouselExampleControls" class="carousel slide ml-4" data-ride="carousel" data-interval="3500">
        <div class="carousel-inner">
            <?php foreach ($caroussel['results'] as $index => $movie) : ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <img class="d-block w-100 carousel-backdrop" src="https://image.tmdb.org/t/p/w1280<?= $movie['backdrop_path'] ?>" alt="Slide <?= $index + 1 ?>">
                    <div class="carousel-overlay">
                        <img src="https://image.tmdb.org/t/p/w500<?= $movie['poster_path'] ?>" alt="<?= $movie['title'] ?> Poster" class="poster">
                        <h5><?= $movie['title'] ?></h5>
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

<div class="col-3">
<h3 class="mr-4 mt-4 mb-4" style="border-left:2px solid #FFCC00;padding-left: 6px;">Films les mieux notés</h3>

<?php 
$index = 0;
foreach ($filmnote['results'] as $i) : 
    if ($index % 3 == 0) : 
        if ($index != 0) : ?> </div> <?php endif;?> 
        <div class="card-group" style="<?= $index > 0 ? 'display:none;' : 'display:block;' ?>"> <!-- Affiche le premier groupe, cache les autres -->
    <?php endif; ?>

    <div class="card" style="background:#333; margin: 10px; margin-bottom: 63px;">
        <div class="row">
            <img class="col-md-4" src="https://image.tmdb.org/t/p/w400<?= $i['poster_path'] ?>" alt="">
            <div class="container col-md-7 mt-4">
                <h2 class="card-1" style="font-size:15px"><?= $i['title'] ?></h2>
                <p class="card-2" style="font-size:15px"><?= $i['release_date'] ?></p>
            </div>
        </div>
    </div>

<?php 
$index++; 
endforeach; 
if ($index != 0) : ?> </div> <?php endif; // Ferme le dernier groupe 
?>
</div>


 </div>
        

<?php foreach ($filmsParGenre as $index=>$movie) : ?>
    <div class="container films-section" style="margin-top:20px;">
    <h5 style="border-left:2px solid #FFCC00;padding-left: 6px; margin-top:80px;"><?= $index ?></h5>
    <div class="scrolling-container" >
    <div class="scrolling-wrapper">

    <?php foreach ($movie as $movies) : ?>
        

        <a href="?controller=home&action=information_movie&id=<?= $movies['tconst'] ?>"  class="card composent-card" style="width: 200px;">
        <img src="" alt="Poster" class="card-img-top" data-tconst="<?= $movies['tconst'] ?>">
        <div class="card-body">
        <h5 class="card-title"><?= $movies['primarytitle'] ?></h5>
        <h6 class="card-subtitle mb-2 mt-2 text-muted"><?= $movies['startyear'] ?></h6>
        <div class="rating">
        <img src="./images/star.png" alt="Star" class="star">
        <span class="note"><?= $movies['averagerating']?></span>
        </div>
        </div>
        </a>
    <?php endforeach ; ?>

    </div>
    <button class="scroll-btn left"><</button>
    <button class="scroll-btn right">></button>
    </div>
    </div>
<?php endforeach ; ?>



<script src="Js/home.js"></script>
    <?php require "Views/view_footer.php"; ?>