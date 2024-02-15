<!DOCTYPE html>
<html lang="fr">
<head>
    <title>FinderCine</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
<link rel="stylesheet" href="./css/style.css">

   
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-very-dark fixed-top" style="background-color: #000000;">

    <a class="navbar-brand" href="?controller=home&action=home"><img src="./images/logo2.png" alt="Logo"></a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            
        <li class="nav-item">
        <a class="nav-link" href="?controller=home&action=home">
        <img src="./images/home1.png" alt="Favicon Accueil"> Accueil
        </a></li>
        
        

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false"><img src="./images/movie.png" alt="Favicon Fonctionnalite">
       Fonctionnalité
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <li><a class="dropdown-item" href="?controller=recherche&action=home"><img src="./images/search1.png" alt="Favicon Trouver">Recherche Avancée</a></li>
            <li><a class="dropdown-item" href="?controller=trouver&action=fom_trouver"> <img src="./images/liens.png" alt="Favicon Liens">Liens</a></li>
            <li><a class="dropdown-item" href="?controller=rapprochement&action=fom_rapprochement"><img src="./images/data1.png" alt="Favicon data">Chemins le plus court</a></li>
          </ul>
        </li>
        </ul>
    </div>

   
     
    <div class="search-container" style="position: relative;">
    <form class="input-group barrederecherche" action="?controller=home&action=voirtousresultat" method="POST">
        <input type="text" class="form-control" name="search-input" id="search-input" placeholder="Recherche un film, une serie, un acteur, ..." aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" id="search-btn" style="background-color: #FFCC00; border: 1px solid #FFCC00;" >
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
    <div id="search-suggestions"></div>
</div>






    <div class="ml-auto">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link login_onglet" href="?controller=connect">
                    <img src="./images/profil.png" alt="Favicon Login" class="favicon"> <!-- Assurez-vous que le chemin d'accès à l'icône est correct -->
                    <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Login'; ?>
                </a>
            </li>
        </ul>
    </div>
</nav>
<script src="Js/navbar.js"></script>