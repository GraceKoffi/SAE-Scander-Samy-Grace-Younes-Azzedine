<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .logo {
            width: 100px;
            height: 100px;
            background-image: url('Images/findercine1.jpg');
            background-size: cover;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
        .search-count {
            background-color: black;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            color: white;
            padding: 50px 0;
            text-align: center;
        }

        .card {
            display: grid;
            grid-template-columns: 300px;
            grid-template-rows: 210px 210px 80px;
            grid-template-areas: "image" "text" "stats";

            border-radius: 18px;
            background: white;
            box-shadow: 5px 5px 15px rgba(0,0,0,0.9);
            font-family: roboto;
            text-align: center;
            transition: 0.5s ease;
            cursor: pointer;
            margin:30px;
            }

        .card-image {
            grid-area: image;
            }
        .card-text {
            grid-area: text;
            }
        .card-stats {
            grid-area: stats; 
            }


        .card-image {
            grid-area: image;
            background: url("Images/54qqo354uyy11.jpg");
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            background-size: cover;
            }

        .card-text {
            grid-area: text;
            margin: 25px;
            }
        .card-text .date {
            color: rgb(255, 7, 110);
            font-size:13px;
            }
        .card-text p {
            color: grey;
            font-size:15px;
            font-weight: 300;
            }
        .card-text h2 {
            margin-top:0px;
            font-size:28px;
            }

        .card-stats {
            grid-area: stats; 
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: 1fr;

            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            background: grey;
            }

        .card-stats .stat {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

            color: white;
            padding:10px;
            }

        .card:hover {
            transform: scale(1.15);
            box-shadow: 5px 5px 15px rgba(0,0,0,0.6);
        }
        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh; /* Ajustez la hauteur selon vos besoins */
        }
        .favorites-container {
            display: flex;
            justify-content: space-around;
            margin: 20px;
        }

        .favorites-div {
            width: 45%;
            border: 1px solid #ccc;
            padding: 20px;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }
        .view-all-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        .view-all-link:hover {
            text-decoration: underline;
        }

        .favori-message {
            text-align: center;
            color: #333;
            font-size: 18px;
            margin-bottom: 15px;
        }
        
        .paragraphe{
            margin-top: 80px;
        }
  </style>
</head>
<body>
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <img class="scroll-reveal logo" src="Images/findercine1.jpg" alt="Logo Musee de France" width="100">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="?controller=home">Acceuil</a></li>
                <li class="nav-item"><a class="nav-link" href="?controller=recherche">Recherche</a></li>
                <li class="nav-item"><a class="nav-link" href="?controller=trouver">Trouver</a></li>
                <li class="nav-item"><a class="nav-link" href="?controller=rapprochement">Rapprochement</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="?controller=connect&action=settings">Settings</a></li>
                <li class="nav-item"><a class="nav-link" href="?controller=connect&action=logout">Logout</a></li>
            </ul>
        </div>
    </nav> -->
    <?php
    require "Views/view_navbar.php";
    // Récupérer la variable 'retour' de l'URL
    if(isset($_GET['retour'])){
        $retour = trim(e($_GET['retour']));
        switch ($retour) {
            case 1:
                $message = "Modification pris en compte";
                $alertClass = "alert-success";
                break;
            case 0:
                $message = "Aucune modification";
                $alertClass = "alert-secondary";
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
    ?>

    <div class="jumbotron paragraphe text-center">
        <h1 class="display-4">Salut, <?php echo $_SESSION['username'];?> !</h1>
        <p class="lead">Bienvenue sur votre page de profil. Vous pouvez consulter ici toutes vos recherches.</p>
        <p id="searchCount">Voux avez realiser <span id="counter"><?php echo $tab["Total"]["totalrecherches"];?></span> recherche(s)</p>
        <a href="?controller=connect&action=logout"><button class="btn btn-primary">Logout</button></a>
       
    </div>
    
<a href="?controller=connect&action=render_rechercheData&type=Recherche">
<div class="card-container">
    <div class="card">
        <div class="card-image"></div>
            <div class="card-text">
                <?php
                if($tab["TotalParType"]["countrecherche"] == 0){
                    $formattedDateTime = "Pas de recherche realiser";
                }
                else{
                    $rechercheTime = $tab["RecherTime"]["recherche"];
                    $formattedDateTime = "Realiser le ".date("d/m/Y H:i", strtotime($rechercheTime));
                }
                ?>
                <span class="date"><?php echo $formattedDateTime; ?></span>    
                <h2>Recherche</h2>
                <p>Vous retrouver ici votre historique de Recherche</p>
            </div>
        <div class="card-stats">
                <div class="stat">
                    <div class="value"><sup></sup></div>
                        <div class="type"></div>
                    </div>
            <div class="stat">
            <div class="value"><?php echo $tab["TotalParType"]["countrecherche"];?></div>
            <div class="type">Element(s)</div>
            </div>
        </div>
    </div>
</a>
    
<a href="?controller=connect&action=render_rechercheData&type=Trouver">
    <div class="card">
    <div class="card-image"></div>
    <div class="card-text">
        <?php
        if($tab["TotalParType"]["counttrouver"] == 0){
            $formattedDateTime = "Pas de recherche realiser";
        }
        else{
            $rechercheTime = $tab["RecherTime"]["trouver"];
            $formattedDateTime = "Realiser le ".date("d/m/Y H:i", strtotime($rechercheTime));
        }
        ?>
        <span class="date"><?php echo $formattedDateTime; ?></span>
        <h2>Trouver</h2>
        <p>Vous retrouver ici votre historique de Trouver</p>
    </div>
    <div class="card-stats">
        <div class="stat">
        <div class="value"><sup></sup></div>
        <div class="type"></div>
        </div>
        <div class="stat">
        <div class="value"><?php echo $tab["TotalParType"]["counttrouver"]?></div>
        <div class="type">Element(s)</div>
        </div>
    </div>
    </div>
</a>

<a href="?controller=connect&action=render_rechercheData&type=Rapprochement">
    <div class="card">
    <div class="card-image"></div>
    <div class="card-text">
        <?php
        if($tab["TotalParType"]["countrapprochement"] == 0){
            $formattedDateTime = "Pas de recherche realiser";
        }
        else{
            $rechercheTime = $tab["RecherTime"]["rapprochement"];
            $formattedDateTime = "Realiser le ".date("d/m/Y H:i", strtotime($rechercheTime));
        }
        ?>
        <span class="date"><?php echo $formattedDateTime; ?></span>
        <h2>Rapprochement</h2>
        <p>Vous retrouver ici votre historique de Rapprochement</p>
    </div>
    <div class="card-stats">
        <div class="stat">
        <div class="value"><sup></sup></div>
        <div class="type"></div>
        </div>
        <div class="stat">
        <div class="value"><?php echo $tab["TotalParType"]["countrapprochement"]?></div>
        <div class="type">Element(s)</div>
        </div>
    </div>
    </div>
</a>

</div>
<div class="favorites-container">
        <div class="favorites-div" id="filmFavorites">
            <h2>Favorite Films</h2>
            <p class="favori-message">Vous avez <?php echo $tab['TotalFavorieFilm']['favoriefilmcount']; ?> favoris.</p>
            <ul id="filmList">
                <!-- List of favorite films -->
            </ul>
            <a href="view-all-films.php" class="view-all-link">Voir tous les films favoris</a>
        </div>

        <div class="favorites-div" id="actorFavorites">
            <h2>Favorite Actors</h2>
            <p class="favori-message">Vous avez <?php echo $tab['TotalFavorieActeur']['favorieacteurcount']; ?> favoris.</p>
            <ul id="actorList">
                <!-- List of favorite actors -->
            </ul>
            <a href="view-all-actors.php" class="view-all-link">Voir tous les acteurs favoris</a>
        </div>
    </div>
<script>
   // Supposons que l'ID de votre alerte est 'myAlert'
var alertElement = document.getElementById('myAlert');

// Faire disparaître l'alerte après 3 secondes
window.setTimeout(function() {
    alertElement.setAttribute('hidden', true);
}, 2000);

</script>
<?php require "Views/view_footer.php"; ?>
</body>
</html>
