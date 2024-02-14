<?php require "Views/view_navbar.php"; ?>
<style>
    .filter-input {
    margin-bottom: 20px;
    padding: 5px;
}
.pagination {
        display: flex;
        justify-content: center;
        list-style-type: none;
    }
    .pagination .page-item {
        margin: 0 5px;
    }
    .pagination .page-link {
        display: block;
        padding: 5px 10px;
        color: #007bff;
        text-decoration: none;
    }
    .pagination .page-item.active .page-link {
        color: #fff;
        background-color: #007bff;
    }
    .movie-list-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px;
        background-color: #292b2c; /* Couleur de fond */
        border-radius: 8px; /* Coins arrondis */
    }

    .movie-list-item img {
        width: 70px;
        height: 100px;
        margin-right: 20px;
        border-radius: 4px; /* Coins arrondis pour l'image */
    }

    .movie-list-item h4, .movie-list-item p {
        margin: 0;
        color: white;
    }

</style>

<div class="container mt-5">
        <h1>Recherche Avancée</h1>
        <form action="?controller=recherche&action=rechercher" method="post">
            <div class="form-group">
                <label for="search">Recherche</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Entrez le nom d'un film ou d'un acteur">
            </div>
            <div class="form-group">
                <label for="type">Type de recherche</label>
                <select class="form-control" id="type" name="type">
                    <option value="film">Film</option>
                    <option value="acteur">Acteur</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" id="filter">Filtres</button>
            <!-- Ajout des champs de recherche pour les films -->
<div id="filter-box-film" style="display: none;">

<select class="form-select mt-3 filter-input" name="types">
    <option value="">Sélectionner le type de film</option>
    <option value="tvShort">tvShort</option>
    <option value="tvMovie">tvMovie</option>
    <option value="tvMiniSeries">tvMiniSeries</option>
    <option value="videoGame">videoGame</option>
    <option value="short">short</option>
    <option value="tvSeries">tvSeries</option>
    <option value="movie">movie</option>
    <option value="tvEpisode">tvEpisode</option>
    <option value="video">video</option>
    <option value="tvSpecial">tvSpecial</option>
    <option value="tvPilot">tvPilot</option>
</select>


    
    <input type="text" class="form-control mt-3 filter-input" name="dateSortieMin" placeholder="Année minimale">
    <input type="text" class="form-control mt-3 filter-input" name="dateSortieMax" placeholder="Année maximale">

    
    <input type="text" class="form-control mt-3 filter-input" name="dureeMin" placeholder="Durée minimale (en minute)">
    <input type="text" class="form-control mt-3 filter-input" name="dureeMax" placeholder="Durée maximale (en minute)">



   
    <select id="choices-multiple-remove-button" name="genres[]" placeholder="Choisir 3 genres MAX" multiple>   
    <option value="Game-Show">Game-Show</option>
    <option value="Family">Family</option>
    <option value="Music">Music</option>
    <option value="Reality-TV">Reality-TV</option>
    <option value="Comedy">Comedy</option>
    <option value="Western">Western</option>
    <option value="Short">Short</option>
    <option value="Crime">Crime</option>
    <option value="War">War</option>
    <option value="Romance">Romance</option>
    <option value="Biography">Biography</option>
    <option value="Drama">Drama</option>
    <option value="Mystery">Mystery</option>
    <option value="Sci-Fi">Sci-Fi</option>
    <option value="Fantasy">Fantasy</option>
    <option value="Adventure">Adventure</option>
    <option value="Documentary">Documentary</option>
    <option value="Action">Action</option>
    <option value="Animation">Animation</option>
    <option value="Sport">Sport</option>
    <option value="Horror">Horror</option>
    <option value="Adult">Adult</option>
    <option value="News">News</option>
    <option value="Talk-Show">Talk-Show</option>
    <option value="Film-Noir">Film-Noir</option>
    <option value="Musical">Musical</option>
    <option value="Thriller">Thriller</option>
    <option value="History">History</option>
</select>

   
    <input type="text" class="form-control mt-3 filter-input" name="noteMin" placeholder="Note minimale (0-10)">
    <input type="text" class="form-control mt-3 filter-input" name="noteMax" placeholder="Note maximale (0-10)">

    
    <input type="text" class="form-control mt-3 filter-input" name="votesMin" placeholder="Votes minimaux">
    <input type="text" class="form-control mt-3 filter-input" name="votesMax" placeholder="Votes maximaux">
</div>





<div id="filter-box-acteur" style="display: none;">
<input type="text" class="form-control mt-5 filter-input" name="dateNaissance" placeholder="Date de naissance">
<input type="text" class="form-control mt-3 filter-input" name="dateDeces" placeholder="Date de décès">
<select id="choices-multiple-remove-button" name="metier[]" placeholder="Choisir 3 professions MAX" multiple>
    <option value="actor">Actor</option>
    <option value="talent_agent">Talent Agent</option>
    <option value="podcaster">Podcaster</option>
    <option value="soundtrack">Soundtrack</option>
    <option value="electrical_department">Electrical Department</option>
    <option value="writer">Writer</option>
    <option value="manager">Manager</option>
    <option value="script_department">Script Department</option>
    <option value="make_up_department">Make-Up Department</option>
    <option value="art_department">Art Department</option>
    <option value="director">Director</option>
    <option value="art_director">Art Director</option>
    <option value="music_department">Music Department</option>
    <option value="production_department">Production Department</option>
    <option value="publicist">Publicist</option>
    <option value="location_management">Location Management</option>
    <option value="visual_effects">Visual Effects</option>
    <option value="cinematographer">Cinematographer</option>
    <option value="special_effects">Special Effects</option>
    <option value="costume_designer">Costume Designer</option>
    <option value="casting_director">Casting Director</option>
    <option value="music_artist">Music Artist</option>
    <option value="transportation_department">Transportation Department</option>
    <option value="production_designer">Production Designer</option>
    <option value="editorial_department">Editorial Department</option>
    <option value="casting_department">Casting Department</option>
    <option value="executive">Executive</option>
    <option value="legal">Legal</option>
    <option value="composer">Composer</option>
    <option value="actress">Actress</option>
    <option value="sound_department">Sound Department</option>
    <option value="editor">Editor</option>
    <option value="costume_department">Costume Department</option>
    <option value="assistant">Assistant</option>
    <option value="stunts">Stunts</option>
    <option value="animation_department">Animation Department</option>
    <option value="camera_department">Camera Department</option>
    <option value="set_decorator">Set Decorator</option>
    <option value="producer">Producer</option>
    <option value="production_manager">Production Manager</option>
    <option value="choreographer">Choreographer</option>
    <option value="assistant_director">Assistant Director</option>
    <option value="miscellaneous">Miscellaneous</option>
</select>

</div>

            <button type="submit" class="btn btn-success">Rechercher</button>
        </form>








        <div id="results">
           
            <!-- Les résultats de la recherche apparaîtront ici -->
                   
            <?php if(!empty($recherchefilms)) : ?>

                <form method="post" action="?controller=recherche&action=trieFilm">
    <label for="tri_colonne">Trier par :</label>
    <select name="tri_colonne">
        <option value="primaryTitle">Titre</option>
        <option value="startyear">Année de sortie</option>
        <option value="runtimeminutes">Durée</option>
        <option value="averageRating">Note</option>
        <option value="numVotes">Nombre de vote</option>

    </select>

    <label for="tri_ordre">Ordre :</label>
    <select name="tri_ordre">
        <option value="ASC">Croissant</option>
        <option value="DESC">Décroissant</option>
    </select>

    <input type="submit" value="Trier">
</form>

                   
                        <?php 
/*

 <?php foreach($recherchefilms as $v) : ?>



$api_key = "9e1d1a23472226616cfee404c0fd33c1";
$id_imdb = $v['tconst'];
$url = "https://api.themoviedb.org/3/find/{$id_imdb}?api_key={$api_key}&external_source=imdb_id&language=fr";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);


$data = json_decode($response);

$portrait= null;




// Créez un tableau avec tous les résultats que vous voulez vérifier
$results = array_merge($data->movie_results, $data->tv_results, $data->tv_episode_results, $data->tv_season_results);

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

*/
?>
<button onclick="sortMovies('primarytitle')">Trier par Titre</button>
<button onclick="sortMovies('runtimeminutes')">Trier par Durée</button>

<?php

$nombreElementsParPage = 10;
$pageActuelle = 1; // Commencer à la page 1, modifiez cette valeur selon vos besoins
$totalElements = count($recherchefilms);
$totalPages = ceil($totalElements / $nombreElementsParPage);


// Calcul de l'index de début pour la page actuelle
$debut = ($pageActuelle - 1) * $nombreElementsParPage;

// Extraction des éléments pour la page actuelle
$elementsPageActuelle = array_slice($recherchefilms, $debut, $nombreElementsParPage);

// Affichage des éléments de la page actuelle
for ($page = 1; $page <= $totalPages; $page++) {
    echo "<div id='page$page' class='page' style='display: none;'>";
    $debut = ($page - 1) * $nombreElementsParPage;
    $fin = min($debut + $nombreElementsParPage, $totalElements);
    for ($i = $debut; $i < $fin; $i++) {
        $film = $recherchefilms[$i];
        // Affichez ici les détails de chaque film
        echo "<div class='container'>";
        echo "<div class='row'>";
        echo "<div class='col-md-6'>";
        echo "<div class='movie-list-item'>";
        echo "<div>";
        echo "<h4>" . e($film['primarytitle']) . "</h4>";
        echo "<p>" . e($film['startyear']) . " - " . e($film['runtimeminutes']) . " minutes</p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
}
for ($page = 1; $page <= $totalPages; $page++) {
    echo "<button onclick='showPage($page)'>$page</button>";
}




?>


                <?php
                /*


<div class="container">
    <div class="row">
            <div class="col-md-6">
                <a href="?controller=home&action=information_movie&id=<?= e($v['tconst']) ?>" class="text-decoration-none">
                    <div class="movie-list-item">
                        <div>
                            <h4><?= e($v['primarytitle']) ?></h4>
                            <p><?= e($v['startyear']) ?> - <?= e($v['runtimeminutes']) ?> minutes</p>
                        </div>
                    </div>
                </a>
            </div>
    </div>
</div>


                    <?php endforeach ?> 
               


                



                
                $totalPagesFilm = ceil($totalResultatFilm / $perPageFilm);
$range = 5;
$start = max($pageFilm - $range, 1);
$end = min($pageFilm + $range, $totalPagesFilm);



?>

<ul class="pagination" style="center">
    <?php
    // Génération des liens de pagination
    for ($i = $start; $i <= $end; $i++) :
    ?>
        <li class="page-item <?php echo ($pageFilm == $i) ? 'active' : ''; ?>">
            <a class="page-link" href="?controller=recherche&action=paginationFilm&pageFilm=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
    <?php endfor; ?>

    <?php if ($end < $totalPagesFilm) : ?>
        <li class="page-item">
            <a class="page-link" href="#">...</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="?controller=recherche&action=paginationFilm&pageFilm=<?php echo $totalPagesFilm; ?>"><?php echo $totalPagesFilm; ?></a>
        </li>
    <?php endif; ?>
</ul>

  <?php */ ?>              


                <?php elseif(!empty($recherchepersonne)) : ?>
                    
                <table class="table table-striped" style="margin-top: 30px;">
                    <tr> <th scope="col">id</th><th scope="col">Prénom Nom</th> <th scope="col">Naissance(année)</th><th scope="col">Decès(année)</th> <th scope="col">Métier</th> 

                    <?php foreach ($recherchepersonne as $v) : ?>
                        <tr>
                        <td> <a href="?controller=home&action=information_acteur&id=<?= e($v['nconst']) ?>"><?= e($v['nconst']) ?></a></td>
                            <td> <?= e($v['primaryname']) ?></td>
                            <td> <?= e($v['birthyear']) ?> </td>
                            <td> <?= e($v['deathyear']) ?> </td>
                            <td> <?= e($v['primaryprofession']) ?> </td>
                            
                        </tr>
                    <?php endforeach ?> 
                </table> 

                <?php
                $totalPagesActeur= ceil($totalResultatActeur / $perPageActeur);
$range = 5;
$start = max($pageActeur - $range, 1);
$end = min($pageActeur + $range, $totalPagesActeur);

?>

<ul class="pagination" style="center">
    <?php
    // Génération des liens de pagination
    for ($i = $start; $i <= $end; $i++) :
    ?>
        <li class="page-item <?php echo ($pageActeur == $i) ? 'active' : ''; ?>">
            <a class="page-link" href="?controller=recherche&action=paginationActeur&pageActeur=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
    <?php endfor; ?>

    <?php if ($end < $totalPagesActeur) : ?>
        <li class="page-item">
            <a class="page-link" href="#">...</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="?controller=recherche&action=paginationActeur&pageActeur=<?php echo $totalPagesActeur; ?>"><?php echo $totalPagesActeur; ?></a>
        </li>
    <?php endif; ?>
</ul>
                
            <?php endif; ?>
       </div>
    </div>



    
    <script>
   $(document).ready(function() {
    function updateFilters() {
        var type = $('#type').val();
        if (type == 'film') {
            $('#filter-box-film').show(); // Afficher la div du filtre de film
            $('#filter-box-acteur').hide(); // Masquer la div du filtre d'acteur
             $('.filter-input').val('');
            $('.filter-input[type="checkbox"]').prop('checked', false);
        } else if (type == 'acteur') {
            $('#filter-box-acteur').show(); // Afficher la div du filtre d'acteur
            $('#filter-box-film').hide(); // Masquer la div du filtre de film
            $('.filter-input').val('');
            $('.filter-input[type="checkbox"]').prop('checked', false);
        }
    }

    $('#filter').click(function() {
        if ($('#filter-box-film').is(':visible') || $('#filter-box-acteur').is(':visible')) {
            $('#filter-box-film').hide();
            $('#filter-box-acteur').hide();
            $('.filter-input').val('');
            $('.filter-input[type="checkbox"]').prop('checked', false);
        } else {
            updateFilters();
        }
    });

    $('#type').change(function() {
        if ($('#filter-box-film').is(':visible') || $('#filter-box-acteur').is(':visible')) {
            updateFilters();
        }
    });
});




var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
    removeItemButton: true,
    maxItemCount: 3,
    searchResultLimit: 4,
    renderChoiceLimit: 1000 
});

     
     
$(document).ready(function() {
    var table = $('#example').DataTable({
        searchPanes: true
    });
    table.searchPanes.container().prependTo(table.table().container());
    table.searchPanes.resizePanes();
})



document.addEventListener('DOMContentLoaded', function() {
    var nombreElementsParPage = 10; // Nombre d'éléments à afficher par page
    var table = document.querySelector('#table tbody'); // Sélection du corps du tableau
    var rows = table.querySelectorAll('tr'); // Toutes les lignes du tableau
    var totalPages = Math.ceil(rows.length / nombreElementsParPage); // Calcul du nombre total de pages

    function showPage(page) {
        var start = (page - 1) * nombreElementsParPage;
        var end = start + nombreElementsParPage;
        rows.forEach(function(row, index) {
            row.style.display = (index >= start && index < end) ? '' : 'none'; // Affiche les lignes de la page actuelle
        });
    }

    // Initialisation - afficher la première page
    showPage(1);

    // Génération des contrôles de pagination (exemple simplifié)
    var pagination = document.createElement('div');
    for (let i = 1; i <= totalPages; i++) {
        var btn = document.createElement('button');
        btn.innerText = i;
        btn.addEventListener('click', function() { showPage(i); });
        pagination.appendChild(btn);
    }
    document.body.appendChild(pagination); // Ajoute les boutons de pagination au body (à ajuster selon votre structure HTML)
});






// Déclarer une variable globale pour stocker les données originales
var originalData = [];

// Fonction pour trier les films
function sortMovies(criteria) {
    originalData.sort((a, b) => {
        if (criteria === 'primarytitle') {
            return a.primarytitle.localeCompare(b.primarytitle);
        } else if (criteria === 'runtimeminutes') {
            return a.runtimeminutes - b.runtimeminutes;
        }
    });
    showPage(1); // Afficher la première page après le tri
}

// Fonction pour afficher la page spécifiée
function showPage(page) {
    var start = (page - 1) * nombreElementsParPage;
    var end = start + nombreElementsParPage;
    var rows = originalData.slice(start, end);

    // Supprimer les lignes existantes du tableau
    table.innerHTML = '';

    // Ajouter les lignes de la page actuelle au tableau
    rows.forEach(function(row) {
        table.appendChild(row);
    });
}

    </script>





<?php require "Views/view_footer.php"; ?>



<?php require "Views/view_navbar.php"; ?>



<div class="container mt-5">
    <h1>Recherche Avancée</h1>
    <div class="card">
        <div class="card-body">
            <form action="?controller=recherche&action=rechercher" method="post">
                <div class="form-group mb-3">
                    <label for="search">Recherche*</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Entrez le nom d'un film ou d'un acteur">
                    <div id="search-error" style="display: none; color: red;">Veuillez entrer au moins un caractère.</div>
             
                </div>
                <div class="form-group mb-3">
                    <label for="types">Type de recherche</label>
                    <select class="form-select" id="typeselection" name="typeselection">
                        <option value="titre">Titre</option>
                        <option value="personne">Personne</option>
                    </select>
                </div>
                <div id="filter-box-titre" style="display: none;">
                <select class="form-select mt-3 filter-input" name="types">
    <option value="">Sélectionner le type de film</option>
    <option value="tvShort">tvShort</option>
    <option value="tvMovie">tvMovie</option>
    <option value="tvMiniSeries">tvMiniSeries</option>
    <option value="videoGame">videoGame</option>
    <option value="short">short</option>
    <option value="tvSeries">tvSeries</option>
    <option value="movie">movie</option>
    <option value="tvEpisode">tvEpisode</option>
    <option value="video">video</option>
    <option value="tvSpecial">tvSpecial</option>
    <option value="tvPilot">tvPilot</option>
</select>


<input type="text" class="form-control mt-3 filter-input" id="dateSortieMin" name="dateSortieMin" placeholder="Année minimale">
<div id="dateSortieMin-error" style="display: none; color: red;">Veuillez entrer une année valide (min 1000 - max 2025) </div>
<input type="text" class="form-control mt-3 filter-input" id="dateSortieMax" name="dateSortieMax" placeholder="Année maximale">
<div id="dateSortieMax-error" style="display: none; color: red;">Veuillez entrer une année valide (min 1000 - max 2025)</div>
<div id="dateSortieRange-error" style="display: none; color: red;">L'année minimale doit être inférieure à l'année maximale et ne pas dépasser 2025.</div>

    

    <input type="text" class="form-control mt-3 filter-input" name="dureeMin" placeholder="Durée minimale (en minute)">
    <div id="dureeMax-error" style="display: none; color: red;">Veuillez entrer une durée valide (min 0 - max 100000)</div>
    <input type="text" class="form-control mt-3 filter-input" name="dureeMax" placeholder="Durée maximale (en minute)">
    <div id="dureeMin-error" style="display: none; color: red;">Veuillez entrer une durée valide (min 0 - max 100000)</div>
    <div id="dureeRange-error" style="display: none; color: red;">L'année minimale doit être inférieure à l'année maximale et ne pas dépasser 2025.</div>



   
    <select id="choices-multiple-remove-button" name="genres[]" placeholder="Choisir 3 genres MAX" multiple>   
    <option value="Game-Show">Game-Show</option>
    <option value="Family">Family</option>
    <option value="Music">Music</option>
    <option value="Reality-TV">Reality-TV</option>
    <option value="Comedy">Comedy</option>
    <option value="Western">Western</option>
    <option value="Short">Short</option>
    <option value="Crime">Crime</option>
    <option value="War">War</option>
    <option value="Romance">Romance</option>
    <option value="Biography">Biography</option>
    <option value="Drama">Drama</option>
    <option value="Mystery">Mystery</option>
    <option value="Sci-Fi">Sci-Fi</option>
    <option value="Fantasy">Fantasy</option>
    <option value="Adventure">Adventure</option>
    <option value="Documentary">Documentary</option>
    <option value="Action">Action</option>
    <option value="Animation">Animation</option>
    <option value="Sport">Sport</option>
    <option value="Horror">Horror</option>
    <option value="Adult">Adult</option>
    <option value="News">News</option>
    <option value="Talk-Show">Talk-Show</option>
    <option value="Film-Noir">Film-Noir</option>
    <option value="Musical">Musical</option>
    <option value="Thriller">Thriller</option>
    <option value="History">History</option>
</select>

   
    <input type="text" class="form-control mt-3 filter-input" name="noteMin" placeholder="Note minimale (0-10)">
    <input type="text" class="form-control mt-3 filter-input" name="noteMax" placeholder="Note maximale (0-10)">

    
    <input type="text" class="form-control mt-3 filter-input" name="votesMin" placeholder="Votes minimaux">
    <input type="text" class="form-control mt-3 filter-input" name="votesMax" placeholder="Votes maximaux">
</div>



                    <!-- Ajoutez d'autres champs de filtre ici selon vos besoins -->
                </div>
                <div id="filter-box-personne" style="display: none;">
                    <!-- Ajoutez les champs de filtre pour 'personne' ici -->
                    <input type="text" class="form-control mt-5 filter-input" name="dateNaissance" placeholder="Date de naissance">
<input type="text" class="form-control mt-3 filter-input" name="dateDeces" placeholder="Date de décès">
<select id="choices-multiple-remove-button" name="metier[]" placeholder="Choisir 3 professions MAX" multiple>
    <option value="actor">Actor</option>
    <option value="talent_agent">Talent Agent</option>
    <option value="podcaster">Podcaster</option>
    <option value="soundtrack">Soundtrack</option>
    <option value="electrical_department">Electrical Department</option>
    <option value="writer">Writer</option>
    <option value="manager">Manager</option>
    <option value="script_department">Script Department</option>
    <option value="make_up_department">Make-Up Department</option>
    <option value="art_department">Art Department</option>
    <option value="director">Director</option>
    <option value="art_director">Art Director</option>
    <option value="music_department">Music Department</option>
    <option value="production_department">Production Department</option>
    <option value="publicist">Publicist</option>
    <option value="location_management">Location Management</option>
    <option value="visual_effects">Visual Effects</option>
    <option value="cinematographer">Cinematographer</option>
    <option value="special_effects">Special Effects</option>
    <option value="costume_designer">Costume Designer</option>
    <option value="casting_director">Casting Director</option>
    <option value="music_artist">Music Artist</option>
    <option value="transportation_department">Transportation Department</option>
    <option value="production_designer">Production Designer</option>
    <option value="editorial_department">Editorial Department</option>
    <option value="casting_department">Casting Department</option>
    <option value="executive">Executive</option>
    <option value="legal">Legal</option>
    <option value="composer">Composer</option>
    <option value="actress">Actress</option>
    <option value="sound_department">Sound Department</option>
    <option value="editor">Editor</option>
    <option value="costume_department">Costume Department</option>
    <option value="assistant">Assistant</option>
    <option value="stunts">Stunts</option>
    <option value="animation_department">Animation Department</option>
    <option value="camera_department">Camera Department</option>
    <option value="set_decorator">Set Decorator</option>
    <option value="producer">Producer</option>
    <option value="production_manager">Production Manager</option>
    <option value="choreographer">Choreographer</option>
    <option value="assistant_director">Assistant Director</option>
    <option value="miscellaneous">Miscellaneous</option>
</select>

</div>
                </div>
                <button type="submit" class="btn btn-success mt-3">Rechercher</button>
            </form>
        </div>
    </div>
</div>







        <div class="container">
    
    <table id="monTableau" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Date</th>
                <th>Durée (en minute)</th>
                <th>Genres</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assurez-vous que $recherchetitre est initialisé comme un tableau
            $recherchetitre = (isset($recherchetitre) && is_array($recherchetitre)) ? $recherchetitre : [];
            ?>

            <?php if (!empty($recherchetitre)): ?>
                <?php foreach ($recherchetitre as $v): ?>
                    <tr>
                        <td><a href="?controller=home&action=information_movie&id=<?= e($v['tconst']) ?>"><?= e($v['primarytitle']) ?></a></td>
                        <td><?= e($v['titletype']) ?></td>
                        <td><?= e($v['startyear']) ?></td>
                        <td><?= e($v['runtimeminutes']) ?></td>
                        <td><?= e($v['genres']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan='5'>Aucun résultat trouvé.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
            </div>



            <script>
$(document).ready(function() {
    // Initialisation de DataTables
    $('#monTableau').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
        }
    });

    function afficherFiltresSelonSelection() {
        var typeSelection = $('#typeselection').val();
        if (typeSelection === 'titre') {
            $('#filter-box-titre').show();
            $('#filter-box-personne').hide();
        } else if (typeSelection === 'personne') {
            $('#filter-box-personne').show();
            $('#filter-box-titre').hide();
        }
        console.log(typeSelection);
    }

    afficherFiltresSelonSelection();
    
    $('#typeselection').change(afficherFiltresSelonSelection);

    // Validation du formulaire avant soumission
    $('form').submit(function(e) {
        var isValid = true;
        var searchValue = $('#search').val().trim();
        var dateSortieMinValue = $('#dateSortieMin').val().trim();
        var dateSortieMaxValue = $('#dateSortieMax').val().trim();
        var dureeMinValue = $('#dureeMin').val().trim();
        var dureeMaxValue = $('#dureeMax').val().trim();

        // Vérifie que le champ de recherche n'est pas vide
        if (searchValue === '') {
            $('#search-error').show();
            isValid = false;
        } else {
            $('#search-error').hide();
        }

        // Validations pour la date de sortie et la durée
        if (!dateSortieMinValue.match(/^[12]\d{3}$/) || parseInt(dateSortieMinValue) > 2025) {
            e.preventDefault();
            $('#dateSortieMin-error').show();
            isValid = false;
        } else {
            $('#dateSortieMin-error').hide();
        }

        if (!dateSortieMaxValue.match(/^[12]\d{3}$/) || parseInt(dateSortieMaxValue) > 2025) {
            e.preventDefault();
            $('#dateSortieMax-error').show();
            isValid = false;
        } else {
            $('#dateSortieMax-error').hide();
        }

        if (dateSortieMinValue && dateSortieMaxValue && parseInt(dateSortieMinValue) > parseInt(dateSortieMaxValue)) {
            e.preventDefault();
            $('#dateSortieRange-error').show();
            isValid = false;
        } else {
            $('#dateSortieRange-error').hide();
        }

        if (!dureeMinValue.match(/^\d+$/) || parseInt(dureeMinValue) < 0 || parseInt(dureeMinValue) > 100000) {
            e.preventDefault();
            $('#dureeMin-error').show();
            isValid = false;
        } else {
            $('#dureeMin-error').hide();
        }

        if (!dureeMaxValue.match(/^\d+$/) || parseInt(dureeMaxValue) < 0 || parseInt(dureeMaxValue) > 100000) {
            e.preventDefault();
            $('#dureeMax-error').show();
            isValid = false;
        } else {
            $('#dureeMax-error').hide();
        }

        if (dureeMinValue && dureeMaxValue && parseInt(dureeMinValue) > parseInt(dureeMaxValue)) {
            e.preventDefault();
            $('#dureeRange-error').show();
            isValid = false;
        } else {
            $('#dureeRange-error').hide();
        }

        // Empêche la soumission du formulaire si des validations échouent
        if (!isValid) {
            e.preventDefault();
        }

        // Cache les messages d'erreur lors de la correction par l'utilisateur
        $('input').on('input', function() {
            $('.error').hide();
        });
    });

    // Cache les messages d'erreur lors de la correction par l'utilisateur pour les sélecteurs
    $('select').on('change', function() {
        $('.error').hide();
    });
});
</script>






<?php require "Views/view_footer.php"; ?>