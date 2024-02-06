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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <img class="scroll-reveal logo" src="Images/findercine1.jpg" alt="Logo Musee de France" width="100">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="#champ1">Acceuil</a></li>
                <li class="nav-item"><a class="nav-link" href="#champ2">Recherche</a></li>
                <li class="nav-item"><a class="nav-link" href="#champ3">Trouver</a></li>
                <li class="nav-item"><a class="nav-link" href="#champ4">Rapprochement</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="?controller=connect&action=logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="jumbotron text-center">
        <h1 class="display-4">Bonjour, Utilisateur!</h1>
        <p class="lead">Bienvenue sur votre page de profil. Vous pouvez consulter ici toutes vos recherches.</p>
    </div>

    <div class="search-count">
        <h2>Nombre de recherches</h2>
        <p id="searchCount">Voux avez realiser <span id="counter">0</span> recherche(s)</p>
    </div>
    

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <!-- Ajoutez ici vos éléments de carrousel -->
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Précédent</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Suivant</span>
        </a>
    </div>

    <!-- Ajoutez ici d'autres sections selon vos besoins -->
<script>
    const targetCount = <?php echo 100000;?>; 
    const counterElement = document.getElementById('counter');
    function animateCounting(start, end, duration) {
        const startTime = new Date().getTime();
        const interval = setInterval(() => {
            const currentTime = new Date().getTime();
            const progress = Math.min((currentTime - startTime) / duration, 1);
            const count = Math.floor(start + progress * (end - start));
            counterElement.innerText = count;

            if (progress === 1) {
                clearInterval(interval);
            }
        }, 16); 
    }

    animateCounting(0, targetCount, 2000);
</script>
</body>
</html>
