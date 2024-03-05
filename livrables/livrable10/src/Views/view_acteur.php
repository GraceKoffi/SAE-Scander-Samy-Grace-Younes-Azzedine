<?php require "Views/view_navbar.php"; ?>
<style>

..middot{


font-size: 24px;
}
.btncommentaire {
background-color: #FFCC00; /* Couleur de fond initiale */
border: 2px solid #FFCC00; /* Couleur de bordure initiale */
color: white;
border-radius: 25px;
padding: 15px;
}

.btncommentaire:hover {
background-color: #c79f00; /* Couleur de fond au survol */
border: 2px solid #FFCC00; /* Couleur de bordure au survol */
}

/* Styliser spécifiquement l'état :active */
.btncommentaire:active {
background-color: #c79f00; /* Couleur de fond pendant le clic */
border: 2px solid #FFCC00; /* Couleur de bordure pendant le clic */
outline: none; /* Optionnel: supprime l'outline */
box-shadow: none; /* Optionnel: supprime l'ombre de la boîte (si vous utilisez Bootstrap) */
}
.aucunparticipant{

font-size:20px;
margin-top:30px;
}
.composent-card {
background-color: #333; /* Gris foncé */
box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23); /* Effet d'ombre 3D */
margin: 40px; /* Espacement entre les cartes */
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
font-size: 17px;/*taille de la police*/
}


.custom-modal {
            color: black;
        }

        /* Style personnalisé pour le texte du formulaire */
        .custom-form-label {
            color: black;
        }

        /* Style personnalisé pour le bouton d'envoi */
        .custom-submit-btn {
            background-color: white;
            color: black;
        }
        .comment-bubble {
            background-color: yellow;
            color: black;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        /* Style personnalisé pour le nom de l'auteur */
        .comment-author {
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Style personnalisé pour la note du commentaire */
        .comment-note {
            margin-bottom: 5px;
        }

        .check{
            color: black;
        }
        .titre{
            color: black;
        }
        /* Style pour le fil des notes */
        .rating-range {
            display: flex;
            justify-content: space-between;
            padding: 0 15px;
            margin-top: 10px;
        }

        .note{
            color: black;
        }
        
        .form{
            text-align: center;
        }

        .comment-rating {
        font-size: 14px;
        font-weight: bold;
        color: #007bff; /* Couleur de la note, vous pouvez ajuster selon vos préférences */
        margin-top: 5px; /* Espace entre le titre et la note */
        }

/* CSS pour le message "Aucun commentaire" */
        .no-comments {
            font-size: 16px;
            font-weight: bold;
            color: #888; /* Couleur du texte pour le cas où il n'y a pas de commentaires */
            text-align: center;
            margin-top: 20px; /* Espace entre le message et le reste du contenu */
        }

</style>


<?php 
if(isset($_GET['retour'])){
    $retour = trim(e($_GET['retour']));
    switch ($retour) {
        case 1:
            $message = "Commentaire ajouté avec succés";
            $alertClass = "alert-success";
            break;
        case -1:
            $message = "Une erreur est survenu";
            $alertClass = "alert-danger";
            break;
        default:
            $message = "";
            $alertClass = "";
    }


    // Si un message a été défini, afficher l'alerte
    if ($message != "") {
        echo "<div id='myAlert' class='alert $alertClass alert-dismissible fade show' role='alert' style='position: fixed; top: 0; width: 100%; z-index: 9999;'>
                $message
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
    
}
$api_key = "9e1d1a23472226616cfee404c0fd33c1";
$id_acteur = '';
if(isset($_GET['id'])){
    $id_acteur = $_GET['id'];
} 
else if(isset($_GET['acteurId'])){
    $id_acteur = $_GET['acteurId'];
}

$couvertures = []; 
foreach ($titre as $id_f){
    $tconst= $id_f['tconst'];
    $url = "https://api.themoviedb.org/3/find/{$tconst}?api_key={$api_key}&external_source=imdb_id";
    $response = file_get_contents($url);
    $data = json_decode($response, true); // true pour obtenir le résultat en array

    // Fusionner tous les résultats possibles
    $results = array_merge($data['movie_results'], $data['tv_results'], $data['tv_episode_results'], $data['tv_season_results']);

    
    foreach ($results as $result) {
        if (isset($result['backdrop_path']) && $result['backdrop_path'] !== null) {
            $couvertures[] = "https://image.tmdb.org/t/p/w1280" . $result['backdrop_path'];
          
            break; // Sortir de la boucle dès qu'une couverture est trouvée
        }
    }
    

}

if (empty($couvertures)) { // Si aucune couverture n'est trouvée, utiliser une image de dépannage
    $couvertures[] = "./Images/cinemadepannage.jpg";
}

$url = "https://api.themoviedb.org/3/find/{$id_acteur}?api_key={$api_key}&external_source=imdb_id";

$response = file_get_contents($url);
$data = json_decode($response);
$portrait= "./Images/depannage.jpg";

if (isset($data->person_results[0]->profile_path) && $data->person_results[0]->profile_path !== null) {
    $portrait = "https://image.tmdb.org/t/p/w400" . $data->person_results[0]->profile_path;
}


  ?>  
    
    
     
 <div style="position: relative; margin-top:35px;">
    <div class="row">
        <!-- Couverture -->
        <div class="backdrop col-md-12" style="z-index: 1;">
        <img id="imageCourante" class="img-fluid" src="<?= $couvertures[0]; ?>"  alt="Couverture" style="filter: opacity(70%) brightness(15%);width: 12800px;height: 800px;">        
    </div>
    </div>




    
    <div class="row" style="position: absolute; top: 100px; left: 100px; width: 100%; margin-top: 35px; z-index: 2;"> <!-- Superpose sur la couverture -->
        <!-- Portrait à gauche -->
        <div class="afficheportrait col-md-3 ml-3">
            <img class="img-fluid w-100" src="<?= $portrait ?>" alt="Portrait"> 
        </div>
        <div class="col-md-1"></div> <!-- Espace entre le portrait et le bloc d'info -->
        <div class="col-md-7 mr-3">
            <div class="blocinfo" style="background-color: transparent;"> <!-- Le fond peut être ajusté pour améliorer la lisibilité -->
                <h1><?= ($info['primaryname'] ?? 'Inconnu'); ?></h1>
                <p>Année : <?= ($info['birthyear'] ?? 'Inconnu'); ?> &nbsp;&nbsp;&nbsp;<span class="middot">&middot;</span> &nbsp;&nbsp;&nbsp;  Métier : <?= ($info['primaryprofession'] ?? 'Inconnu'); ?></p>
                <button style="margin-top: 320px;" type="button" class=" btncommentaire" data-toggle="modal" data-target=".bd-example-modal-lg">Commentaire</button>
            </div>
        </div>
    </div>
</div>


  






<?php
if (isset($_SESSION['username'])) {
     // Récupérez la valeur de filmId depuis l'URL
    $favori = isset( $_SESSION['favoriActeur']) ?  $_SESSION['favoriActeur'] : 'false';
    $texteBouton = ($favori === 'true') ? 'Retirer Favori' : 'Ajouter Favori';
    $couleurBouton = ($favori === 'true') ? 'yellow' : 'white';
    echo "
    <div class='film' data-favori='$favori'>
        <h2 id='titreFilm'>Mon Film Préféré</h2>
        <a href='?controller=home&action=favorie_acteur&acteurId=$id_acteur'>
            <button id='favoriButton' class='bouton-favori' style='background-color: $couleurBouton;'>$texteBouton</button>
        </a>
    </div>
    ";
}
?>
<!-- La modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
            <!-- En-tête de la modal -->
            <div class="modal-header">
                <h5 class="modal-title titre">Commentaires</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Corps de la modal -->
            <div class="modal-body">
                <!-- Affichage des commentaires -->
                <!-- Exemple de données commentaires -->
                <?php
                if (!empty($commentaires)) {
                    $m = Model::getModel();
                    foreach ($commentaires as $commentaire) {
                        if($commentaire['anonyme']){
                            $author = $m->getUsername($commentaire['userid'])['username'];
                        }
                        else{
                            $author = 'Anonyme';
                        }
                        
                        $title = $commentaire['titrecom'];
                        $content = $commentaire['commentary'];
                        $rating = $commentaire['rating'];
                ?>
                        <div class="comment-bubble">
                            <div class="comment-author"><?php echo $author; ?></div>
                            <div class="comment-title"><?php echo $title; ?></div>
                            <div class="comment-rating">Note : <?php echo $rating; ?></div>
                            <?php echo $content; ?>
                        </div>
                <?php
                    }
                } else {
                ?>
                    <div class="no-comments">Aucun commentaire</div>
                <?php
                }
                ?>
            </div>

            <!-- Pied de la modal -->
            <div class="modal-footer form">
                <!-- Formulaire pour ajouter un commentaire -->
                <form id="commentForm" action="?controller=home&action=ajoutComActeur&id=<?php echo $id_acteur;?>" method="post">
                    <div class="form-group">
                        <label class="custom-form-label">Anonyme :</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="anonymous" id="anonymousYes" value="0" checked required>
                            <label class="form-check-label check" for="anonymousYes">Oui</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="anonymous" id="anonymousNo" value="1" required>
                            <label class="form-check-label check" for="anonymousNo">Non</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="commentTitle" class="custom-form-label">Titre du commentaire :</label>
                        <input type="text" class="form-control" id="commentTitle" name="commentTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="commentNote" class="custom-form-label">Note :</label>
                        <!-- Fil des notes -->
                        <div class="rating-range note">
                            <span>0</span>
                            <span>1</span>
                            <span>2</span>
                            <span>3</span>
                            <span>4</span>
                            <span>5</span>
                        </div>
                        <!-- Note (1-5) -->
                        <input type="range" class="form-control-range" id="commentNote" name="commentNote" min="0" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="commentInput" class="custom-form-label">Ajouter un commentaire :</label>
                        <textarea class="form-control" id="commentInput" name="commentInput" rows="3" style="color: black;" required></textarea>
                    </div>
                    <div class="alert alert-danger" role="alert" id="alertNotLoggedIn" style="display: none;">
                        Vous devez être connecté pour envoyer un commentaire.
                    </div>

                    <button type="submit" class="btn btn-primary custom-submit-btn" id="submitBtn">Envoyer</button>
            </form>

            </div>
        </div>
    </div>
</div>
<?php var_dump($titre); 
var_dump($couvertures);
?>
<div class="container mt-4">
<h3 style="    border-left:2px solid #FFCC00;padding-left: 6px;">Connu pour : </h3>
    <div class="row">
    <?php if(empty($titre)): ?>
            <p class="aucunparticipant">Aucun titre.</p>
        <?php else: ?>
        <?php foreach($titre as $v) : ?>
            <?php 
                $id_film = $v['tconst'];
                $url = "https://api.themoviedb.org/3/find/{$id_film}?api_key={$api_key}&external_source=imdb_id";

            
                $response = file_get_contents($url);
                $data = json_decode($response);
                $portrait_film = "./Images/depannage.jpg";
                $results = array_merge($data->movie_results, $data->tv_results, $data->tv_episode_results, $data->tv_season_results);

                foreach ($results as $result) {
                    if (isset($result->poster_path) && $result->poster_path!== null) {
                        $portrait_film = "https://image.tmdb.org/t/p/w500" . $result->poster_path;
                        break;  // Sortir de la boucle dès qu'une valeur est trouvée
                    }
                }
               
            ?>
            <div class="col-md-3 custom-card d-flex align-items-stretch"> <!-- Choisissez la classe de colonne Bootstrap en fonction de votre mise en page -->
            <a href="?controller=home&action=information_movie&id=<?php echo $id_film; ?>" class="card composent-card" style="width: 200px;">
                    <img src=<?= $portrait_film ?> alt="Poster" class="card-img-top">
                    <div class="card-body">
                        <h2 class="card-title"><?= $v['primarytitle'] ?></h2>
                        <h3 class="card-title"><?= $v['startyear'] ?></h3>
                       
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>



<script>
$(document).ready(function() {
    var couvertures = <?php echo json_encode($couvertures); ?>; // Votre tableau PHP de couvertures converti en JSON
    var indexCourant = 0;

    setInterval(function() {
        // Incrémenter l'indexCourant ou le réinitialiser si on a atteint la fin du tableau
        indexCourant = (indexCourant + 1) % couvertures.length;
        // Mettre à jour la source de l'image
        $('#imageCourante').attr('src', couvertures[indexCourant]);
    }, 3000); // Change l'image toutes les 3000 millisecondes (3 secondes)
});

</script>


<?php require "Views/view_footer.php"; ?>