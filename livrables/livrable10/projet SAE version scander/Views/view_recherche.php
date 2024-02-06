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

<div class="container">
        <h1>Recherche de films et d'acteurs</h1>
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

                    <?php foreach($recherchefilms as $v) : ?>
                        <?php 
/*
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
               


                
                <?php
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




    </script>





<?php require "Views/view_footer.php"; ?>