<?php require "Views/view_navbar.php"; ?>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>

<div class="container mt-3">
    <div class="card">
      <div class="card-header filter-header">
        Filtres de recherche
        <a class="float-right" href="#">Développer tout</a>
      </div>
      <div class="card-body filter-body">
        <form>
          <!-- Nom du titre -->
          <div class="form-group">
            <label for="titleName">Nom du titre</label>
            <input type="text" class="form-control" id="titleName" placeholder="Par exemple, Le Parrain">
          </div>

          <!-- Type de titre -->
          <div class="form-group">
            <label>Type de titre</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="movie">
              <label class="form-check-label" for="movie">
                Film
              </label>
            </div>
            <!-- Répétez cette structure pour les autres options comme série télévisée, mini-série, etc. -->
          </div>

          <!-- D'autres filtres comme Date de sortie, Notes IMDb, etc. peuvent être ajoutés ici -->
          
          <!-- Submit button -->
          <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>
      </div>
    </div>
  </div>

<h1>Recherche Avancée</h1>

<p>Bienvenue sur Findercine, où chaque recherche est une porte ouverte vers un univers riche et varié de divertissement. Notre fonction de recherche avancée vous permet d'explorer facilement notre vaste collection de films, séries, jeux vidéo et courts métrages. Plongez-vous dans l'action, explorez des mondes fantastiques et découvrez de nouveaux favoris en quelques clics seulement.</p>

<div class="row">

<div class="col-4">
<div class="card shadow-sm m-5">
<div class="card-header filter-header">


<h3 class="card-title mb-3">Filtres</h3>

<form action="?controller=recherche&action=rechercher" method="post">


<label for="search">Titre</label>
<input type="text" class="form-control-sm" id="search" name="search" placeholder="Entrez le nom d'un film ou d'un acteur">
<div id="search-error" style="display: none; color: red;">Veuillez entrer au moins un caractère.</div>

<div>
                    <label for="typeselection" class="form-label">Type de recherche</label>
                    <select class="form-select-sm" id="typeselection" name="typeselection">
                        <option value="titre">Titre</option>
                        <option value="personne">Personne</option>
                    </select>
                </div>


<div id="filter-box-titre" style="display: none;">
<label for="types" class="form-label">Type du titre</label>
<select class="form-select filter-input" name="types">
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

<label for="dateSortieMin" class="form-label">Sortie après l'année</label>
<input  type="text" class="form-control filter-input" id="dateSortieMin" name="dateSortieMin" placeholder="Année minimale">
<div id="dateSortieMin-error" style="display: none; color: red;">Veuillez entrer une année valide (min 1000 - max 2025) </div>
<label for="dateSortieMax" class="form-label">Sortie avant l'année</label>
<input type="text" class="form-control  filter-input" id="dateSortieMax" name="dateSortieMax" placeholder="Année maximale">
<div id="dateSortieMax-error" style="display: none; color: red;">Veuillez entrer une année valide (min 1000 - max 2025)</div>
<div id="dateSortieRange-error" style="display: none; color: red;">L'année minimale doit être inférieure à l'année maximale et ne pas dépasser 2025.</div>

    
    <label for="dureeMin" class="form-label">Dure plus de (min)</label>
    <input type="text" class="form-control filter-input" id="dureeMin" name="dureeMin" placeholder="Durée minimale (en minute)">
    <div id="dureeMin-error" style="display: none; color: red;">Veuillez entrer une durée valide (min 0 - max 100000)</div>
    <label for="dureeMax" class="form-label">Dure moins de (min)</label>
    <input type="text" class="form-control  filter-input" id="dureeMax" name="dureeMax" placeholder="Durée maximale (en minute)">
    <div id="dureeMax-error" style="display: none; color: red;">Veuillez entrer une durée valide (min 0 - max 100000)</div>
    <div id="dureeRange-error" style="display: none; color: red;">L'année minimale doit être inférieure à l'année maximale et ne pas dépasser 2025.</div>



   
    <select  id="choices-multiple-remove-button" name="genres[]" placeholder="Choisir 3 genres MAX" multiple>   
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
</div><!-- filtre titre -->
<div id="filter-box-personne" style="display: none;">
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

</div><!-- filtre personne -->

<button type="submit" id="buttonrechercher" class="btn btn-success mt-3">Rechercher</button>
            </form>
</div><!-- card -->
</div><!-- card body-->           
</div><!-- col md 3-->
<div class="col-7">

<div class="container m-5">
    <h3>Résultats "xxxxx"</h3>
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
                <tr><td colspan='7'>Aucun résultat trouvé.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
            </div><!--container tableau -->


</div><!-- col md 7-->


</div><!-- rows -->



            <script>
$(document).ready(function() {
    // Initialisation de DataTables
    $('#monTableau').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
        }
    });
});



    // Affichage des filtres selon la sélection
    function afficherFiltresSelonSelection() {
        var typeSelection = $('#typeselection').val();
        if (typeSelection === 'titre') {
            $('#filter-box-titre').show();
            $('#filter-box-personne').hide();
        } else if (typeSelection === 'personne') {
            $('#filter-box-personne').show();
            $('#filter-box-titre').hide();
        }
    }

    afficherFiltresSelonSelection();
    
    $('#typeselection').change(afficherFiltresSelonSelection);
 
    // Validation du champ de recherche
    $('form').submit(function(e) {
        var dateSortieMinValue = $('#dateSortieMin').val().trim();
    var searchInput = $('#search').val().trim();
    var dateSortieMaxValue = $('#dateSortieMax').val().trim();
    var dureeMinValue = $('#dureeMin').val().trim();
    var dureeMaxValue = $('#dureeMax').val().trim();
        
      if (!searchInput) { // Si le champ de recherche est vide
            e.preventDefault(); // Empêcher la soumission du formulaire
            $('#search-error').show();
            
        }
   

        
        if (dateSortieMinValue && (!dateSortieMinValue.match(/^[12]\d{3}$/) )|| parseInt(dateSortieMinValue) > 2025) {
            e.preventDefault();
            $('#dateSortieMin-error').show();
            
           
        } else {
            $('#dateSortieMin-error').hide();
            
        } 
        
        if (dateSortieMaxValue && (!dateSortieMaxValue.match(/^[12]\d{3}$/)) || parseInt(dateSortieMaxValue) > 2025) {
            e.preventDefault();
            $('#dateSortieMax-error').show();
            
        } else {
            $('#dateSortieMax-error').hide();
        }

        if (dateSortieMinValue && dateSortieMaxValue && parseInt(dateSortieMinValue) > parseInt(dateSortieMaxValue)) {
            e.preventDefault();
            $('#dateSortieRange-error').show();
            $('#dateSortieMax-error').hide();
            $('#dateSortieMin-error').hide();
            
        } else {
            $('#dateSortieRange-error').fadeOut();
        }


        if (dureeMinValue && (!dureeMinValue.match(/^\d+$/)) || parseInt(dureeMinValue) < 0 || parseInt(dureeMinValue) > 100000) {
            e.preventDefault();
            $('#dureeMin-error').show();
            console.log("entree min");
            
        } else {
            $('#dureeMin-error').hide();
        }

        if (dureeMaxValue && (!dureeMaxValue.match(/^\d+$/)) || parseInt(dureeMaxValue) < 0 || parseInt(dureeMaxValue) > 100000) {
            e.preventDefault();
            $('#dureeMax-error').show();
            
        } else {
            $('#dureeMax-error').hide();
        }

        if (dureeMinValue && dureeMaxValue && parseInt(dureeMinValue) > parseInt(dureeMaxValue)) {
            e.preventDefault();
            $('#dureeRange-error').show();
            $('#dureeMax-error').hide();
            $('#dureeMin-error').hide();
            
        } else {
            $('#dureeRange-error').hide();
        }

    });

  
    $('#search').on('input', function() {
        $('#search-error').hide();
    });
    $('#dateSortieMin').on('input', function() {
        $('#dateSortieMin-error').hide();
        $('#dateSortieRange-error').hide();
    });
    $('#dateSortieMax').on('input', function() {
        $('#dateSortieMax-error').hide();
        $('#dateSortieRange-error').hide();
    });
    $('#dureeMin').on('input', function() {
        $('#dureeMin-error').hide();
        $('#dureeRange-error').hide();
    });
    $('#dureeMax').on('input', function() {
        $('#dureeMax-error').hide();
        $('#dureeRange-error').hide();
    });
</script>







<?php require "Views/view_footer.php"; ?>