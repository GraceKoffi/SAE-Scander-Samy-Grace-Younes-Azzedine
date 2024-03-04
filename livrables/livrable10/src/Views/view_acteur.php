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
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>
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
<div style="margin-top: 100px"></div>
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