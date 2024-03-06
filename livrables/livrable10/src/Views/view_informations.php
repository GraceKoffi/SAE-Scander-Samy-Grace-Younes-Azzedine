<?php require "Views/view_navbar.php"; ?>

<style>
.middot{


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
        color: #888; /* Couleur de la note, vous pouvez ajuster selon vos préférences */
        margin-top: 10px; /* Espace entre le titre et la note */
        }

/* CSS pour le message "Aucun commentaire" */
        .no-comments {
            font-size: 16px;
            font-weight: bold;
            color: #888; /* Couleur du texte pour le cas où il n'y a pas de commentaires */
            text-align: center;
            margin-top: 20px; /* Espace entre le message et le reste du contenu */
        }

        .modal-content{
            background-color: black;
        }

        .star-container {
            margin-top: -15px;
            margin-left: -5px;
            display: flex;
            align-items: center; /* Aligne les étoiles verticalement */
        }
        .star {
            font-size: 20px; /* Taille des étoiles */
            color: black; /* Couleur des étoiles */
            margin-right: 5px; /* Espacement entre les étoiles */
        }

        

        .star-button {
            font-size: 50px; /* Taille de l'étoile */
            color: white; /* Couleur de l'étoile */
            background: none;
            border: none;
            cursor: pointer;
    }

</style>

<?php
if(isset($_GET['retour'])){
    $retour = trim(e($_GET['retour']));
    switch ($retour) {
        case 1:
            $message = "Commentaire ajouté avec succés";
            $alertClass = "alert-success";
            $image='icons8-check-50.png';
            break;
        case -1:
            $message = "Une erreur est survenu";
            $alertClass = "alert-danger";
            $image='icons8-warning-50.png';
            break;
        default:
            $message = "";
            $alertClass = "";
    }


    // Si un message a été défini, afficher l'alerte
    if ($message != "") {
        echo "<div id='myAlert' class='alert $alertClass alert-dismissible fade show' 
        role='alert' style='position: fixed; top: 0; width: 100%; z-index: 9999;'>
          <div style='padding-top: 10px'>
            <p style='border-left:2px solid black ;padding-left: 5px'>
              <img style='transform: scale(0.7); padding-bottom: 2px;' src='Images/$image' alt='warning'>$message
            </p>
        </div>
      </div>";
    }
    
    
}

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
$couverture = "./Images/cinemadepannage.jpg";
$portrait= "./Images/depannage.jpg";
$overview= 'Inconnu';



// Créez un tableau avec tous les résultats que vous voulez vérifier
$results = array_merge($data->movie_results, $data->tv_results, $data->tv_episode_results, $data->tv_season_results);

foreach ($results as $result) {
    if (isset($result->backdrop_path) && $result->backdrop_path !== null) {
        $couverture = "https://image.tmdb.org/t/p/w1280" . $result->backdrop_path;
        break;  // Sortir de la boucle dès qu'une valeur est trouvée
    }
    if (isset($result->still_path) && $result->still_path!== null) {
        $couverture = "https://image.tmdb.org/t/p/w1280" . $result->still_path;
        break;  // Sortir de la boucle dès qu'une valeur est trouvée
    }
}
foreach ($results as $result) {
    if (isset($result->poster_path) && $result->poster_path!== null) {
        $portrait = "https://image.tmdb.org/t/p/w400" . $result->poster_path;
        break;  // Sortir de la boucle dès qu'une valeur est trouvée
    }
    if (isset($result->still_path) && $result->still_path!== null) {
        $portrait = "https://image.tmdb.org/t/p/w400" . $result->still_path;
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
 
 <div style="position: relative; margin-top:35px;">
    <div class="row">
        <!-- Couverture -->
        <div class="backdrop col-md-12" style="z-index: 1;">
            <img class="img-fluid" src="<?= $couverture ?>" alt="Couverture" style="filter: opacity(70%) brightness(15%);width: 12800px;height: 800px;">
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
                <h1><?= ($info[0]['primarytitle'] ?? 'Inconnu'); ?>
                <?php 
                        if(isset($_SESSION['username'])) {
                            $favori = isset($_SESSION['favori']) ? $_SESSION['favori'] : 'false';
                            if($favori == 'false'){
                                echo "<span><a href='?controller=home&action=favorie_movie&filmId=$id_imdb'><button style='font-size: 50px;
                                                            color: white;
                                                            background: none;
                                                            border: none; 
                                                            cursor: pointer;'>
                                                            ★</button></a>
                                    </span>";
                            }
                            else{
                                        echo "<span><a href='?controller=home&action=favorie_movie&filmId=$id_imdb'><button style='font-size: 50px;
                                        color: yellow;
                                        background: none;
                                        border: none; 
                                        cursor: pointer;'>
                                        ★</button></a>
                                </span>";
                            }
                        }
                        ?>

                </h1>
                <p>Durée : <?= (!empty($info[0]['runtimeminutes']) ? $info[0]['runtimeminutes'] . ' minutes' : 'Inconnu'); ?> &nbsp;&nbsp;&nbsp; <span class="middot">&middot;</span> &nbsp;&nbsp;&nbsp;  Année : <?= ($info[0]['startyear'] ?? 'Inconnu'); ?> &nbsp;&nbsp;&nbsp;<span class="middot">&middot;</span> &nbsp;&nbsp;&nbsp;  Genres : <?= ($info[0]['genres'] ?? 'Inconnu'); ?></p>
                <h6 style="margin-top: 50px;">Synopsis</h6>
                <p><?= ($overview ?? 'Inconnu'); ?></p>
                <div class="row" style="margin-top: 50px;margin-bottom: 50px;">
                    <div class="col-md-4">
                        <h6>Note sur 10</h6>
                        <p><?= ($info[0]['averagerating'] ?? 'Inconnu'); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h6>Réalisateur</h6>
                        <p><?= ($realisateur['realisateur'] ?? 'Inconnu'); ?></p>
                    </div>
                    <div class="col-md-4 ">
                        <h6>Type</h6>
                        <p><?= ($info[0]['titletype'] ?? 'Inconnu'); ?></p>
                    </div>
                </div>
                <button type="button" class=" btncommentaire" data-toggle="modal" data-target=".bd-example-modal-lg">Commentaire</button>
            </div>
        </div>
    </div>
</div>

                




<!-- La modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
            <!-- En-tête de la modal -->
            <div class="modal-header">
                <h5 class="modal-title titre" style="color: yellow; margin-top: 5px">Commentaires <img style="transform: scale(0.9);"src="./images/icons8-message-48.png" alt="Star" class="star"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: yellow;">
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
                            <div class="comment-author">Par <?php echo $author; ?></div>
                            <div class="comment-title">
                                <p style="border-left:2px solid black;padding-left: 6px;"><?php echo $title; ?></p>
                            </div>
                        <div class="star-container">
                            <?php 
                                for($i = 0; $i<$rating; $i++){
                                    echo "
                                    <span class='star'>★</span>
                                    ";
                                }
                            ?>
                            <!-- Ajoutez plus d'étoiles ici si nécessaire -->
                        </div>
                        <div class="comment-rating">
                            <?php echo $content; ?>
                        </div>
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
            <div style="padding-right: 50px;"class="modal-form col-12">
            <hr style="margin-left: 20px; border: none; height: 2px; background-color: #999;">
                <div class="container formulaire">
                    <div class="row">

                        <div class="col-12">
                <!-- Formulaire pour ajouter un commentaire -->
                                <form id="commentForm" action="?controller=home&action=ajoutComMovie&id=<?php echo $id_imdb;?>" method="post">
                                    <div class="form-group">
                                        
                                        <label class="custom-form-label" style="padding-left: 10px; margin-top: 20px; color: white;">Anonyme :</label>
                                        <div class="form-check">
                                        <select class="custom-select" name="anonymous" id="anonymous" style="max-width: 120px; border-top-right-radius: 0; border-bottom-right-radius: 0;" required>
                                                                                <option value="0">Oui</option>
                                                                                <option value="1" selected>Non</option>
                                                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="commentTitle" class="custom-form-label" style="margin-top: 20px; color: white;">Titre du commentaire :</label>
                                        <input type="text" class="form-control" id="commentTitle" name="commentTitle" required placeholder="Titre" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="commentNote" class="custom-form-label" style="margin-top: 20px; color: white;">Note :</label>
                                        <!-- Fil des notes -->
                                        <div class="form-check">
                                        <select class="custom-select" name="commentNote" id="commentNote" style="max-width: 120px; border-top-right-radius: 0; border-bottom-right-radius: 0;" required>
                                                                                <option value="0" selected>0</option>
                                                                                <option value="1">1</option>
                                                                                <option value="2">2</option>
                                                                                <option value="3">3</option>
                                                                                <option value="4">4</option>
                                                                                <option value="5">5</option>
                                                                                <option value="6">6</option>
                                                                                <option value="7">7</option>
                                                                                <option value="8">8</option>
                                                                                <option value="9">9</option>
                                                                                <option value="10">10</option>
                                                                            </select>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="commentInput" class="custom-form-label" style="margin-top: 20px; color: white;">Ajouter un commentaire :</label>
                                        <textarea class="form-control" id="commentInput" name="commentInput" rows="3" style="color: black;" required placeholder="Commentaire"></textarea>
                                    </div>
                                    <div class="alert alert-danger" role="alert" id="alertNotLoggedIn" style="display: none;">
                                        Vous devez être connecté pour envoyer un commentaire.
                                    </div>

                                    <button type="submit" id="buttontrouver" class="btn btn-warning mt-3 mx-auto" style =" color: white;display: block; padding-bottom: 5px;" >Envoyer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <h3 style="border-left:2px solid #FFCC00;padding-left: 6px;"> Participants </h3>
    <div class="row">
    <?php if(empty($acteur)): ?>
            <p class="aucunparticipant">Aucun participant connu.</p>
        <?php else: ?>
        <?php foreach($acteur as $v) : ?>
            <?php 
                $id_acteur = $v['nconst'];
                $url = "https://api.themoviedb.org/3/find/{$id_acteur}?api_key={$api_key}&external_source=imdb_id";


                $response = file_get_contents($url);
                $data = json_decode($response);
                $profilePath = null;
               
                if (isset($data->person_results[0]->profile_path) && $data->person_results[0]->profile_path !== null) {
                    $profilePath = $data->person_results[0]->profile_path;
                }
               
            ?>
            <div class="col-md-3 custom-card d-flex align-items-stretch"> <!-- Choisissez la classe de colonne Bootstrap en fonction de votre mise en page -->
            <a href="?controller=home&action=information_acteur&id=<?php echo $id_acteur; ?>" class="card composent-card" style="width: 200px;">
            <?php $imageSrc = ($profilePath !== null) ? "https://image.tmdb.org/t/p/w500{$profilePath}" : "./Images/depannage.jpg"; ?>
            <img src="<?php echo $imageSrc; ?>" alt="Poster" class="card-img-top">                  
                    <div class="card-body">
                        <h2 class="card-title"><?= $v['nomacteur'] ?></h2>
                        <h3 class="card-title"><?= $v['dateacteur'] ?></h3>
                        <h4 class="card-title"><?= $v['nomdescene'] ?></h4>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


<script src="Js/informations.js"></script>


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
        var alertElement = document.getElementById('myAlert');
  var initialOpacity = 1; // Opacité initiale (complètement visible)
  var fadeDuration = 5000; // Durée du fondu en millisecondes (2 secondes)

// Fonction pour réduire l'opacité progressivement
var alertElement = document.getElementById('myAlert');
    alertElement.style.opacity = 1; // Afficher l'alerte

    // Faire disparaître l'alerte après 2 secondes avec un effet de fondu et un flou
    setTimeout(function() {
        fadeOutAndBlur();
    }, 2000);

    // Fonction pour réduire l'opacité progressivement et augmenter le flou
    function fadeOutAndBlur() {
        var currentTime = 0;
        var interval = 50; // Intervalle de mise à jour (50 ms)
        var fadeDuration = 500; // Durée du fondu en millisecondes (0.5 seconde)
        var maxBlur = 5; // Niveau maximal de flou

        var fadeInterval = setInterval(function() {
            currentTime += interval;
            var opacity = 1 - (currentTime / fadeDuration); // Calcul de l'opacité
            var blurAmount = (currentTime / fadeDuration) * maxBlur; // Calcul du niveau de flou

            alertElement.style.opacity = Math.max(opacity, 0); // Assurez-vous que l'opacité ne devienne pas négative
            alertElement.style.filter = `blur(${blurAmount}px)`; // Appliquer le flou

            if (currentTime >= fadeDuration) {
                clearInterval(fadeInterval); // Arrêtez l'intervalle lorsque l'opacité atteint 0
                alertElement.setAttribute('hidden', true); // Masquez complètement l'alerte
            }
        }, interval);
    }
     var submitBtn = document.getElementById('submitBtn');
    var alertNotLoggedIn = document.getElementById('alertNotLoggedIn');

    submitBtn.addEventListener('click', function() {
        // Vérifier si la variable de session existe
       
        <?php if (!isset($_SESSION['username'])) : ?>
            // Afficher l'alerte si l'utilisateur n'est pas connecté
            alertNotLoggedIn.style.display = 'block';
            // Empêcher l'envoi du formulaire
            event.preventDefault();
        <?php endif; ?>
    });
    </script>

        <?php require "Views/view_footer.php"; ?>
