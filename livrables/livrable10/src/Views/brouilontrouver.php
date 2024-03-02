<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Comparaison</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
    <script src="https://unpkg.com/scrollreveal@4.0.7/dist/scrollreveal.min.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: yellow !important;
            color: white !important;
        }
        * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        }


.wrapper {
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container {
    height: 400px;
    display: flex;
    flex-wrap: nowrap;
    justify-content: start;
}

.card {
    width: 100px;
    border-radius: .75rem;
    background-size: cover;
    cursor: pointer;
    overflow: hidden;
    border-radius: 2rem;
    margin: 0 10px;
    display: flex;
    align-items: flex-end;
    transition: .6s cubic-bezier(.28,-0.03,0,.99);
    box-shadow: 0px 10px 30px -5px rgba(0,0,0,0.8);
    position: relative;
}

.card > .row {
    color: white;
    display: flex;
    flex-wrap: nowrap;
}


.card > .row > .description {
    display: flex;
    color: yellow;
    justify-content: flex-start; /* Change center to flex-start */
    flex-direction: column;
    overflow: hidden;
    height: 100px;
    width: 600px;
    opacity: 0;
    transform: translateY(30px);
    transition-delay: .3s;
    transition: all .3s ease;
}
.card .row {
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%; /* Ajoutez cette ligne pour que la carte occupe toute la hauteur */
}

.card .description {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card .description a.button {
    align-self: flex-start;
}
.description p {
    color: yellow;
    padding-top: 5px;
}

.description a {
    color: black;
    padding-top: 5px;
}

.description h4 {
    text-transform: uppercase;
}

input {
    display: none;
}

input:checked + label {
    width: 800px;
}

input:checked + label .description {
    opacity: 1 !important;
    transform: translateY(0) !important;
}

.card[for="c1"] {
    background-image: url('Images/hHQpMa.jpg');
}
.card[for="c2"] {
    background-image: url('Images/movie-wallpapers-29.jpg');
}
.card[for="c3"] {
    background-image: url('Images/R.jpeg');
}
.card[for="c4"] {
    background-image: url('Images/cinema.png');
}

    
        .wrapper1{
            width: 100%;
            margin: 0 auto;
        }

        .banner-area {
            background: black;
            background-size: cover;
            background-position: center center;
            top: 0; /* Modification ici */
            height: 100vh;
            width: 100%;
            position: absolute;
        }

        .banner-area::after{
            content: '';
            position: absolute;
            top: 0;
            left 0;
            display: block;
            /* width: 100%; */
            /* height: 100vh; */
            background: black;
            opacity: .7;
            z-index: -1;
        }


        .banner-area h2{
            padding-top: 8%;
            font-size: 80px;
            color: yellow;
        }

        .banner-area button{
            color: yellow;
        }

        .content-area{
            width: 100%;
            height: 80vh;
            position: relative;
            background: white;
            top: 500px;
        }

        .content-area h2{
            font-size: 40px;
            margin: 0;
            padding-top: 30px;
            letter-spacing: 4px;
            color: black;
        }

        .content-area p{
            padding: 2% 0;
            line-height: 30px;
            text-align: justify;
        }


        .button {
    background-color: yellow;
    border: none;
    color: black;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px auto; /* Pour centrer le bouton horizontalement */
    cursor: pointer;
    width: 80%; /* Ajustez la largeur selon vos besoins */
    border-radius: 20px;
}
.button.btn-c1 {
    width: 25%; /* Ajustez la largeur selon vos besoins pour le bouton c1 */
}
.buttonAcceuil{
    background-color: yellow;
    border: none;
    border-radius: 20px;
    color: black;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.label{
    color: black;
}

.form{
    margin-top: 80px;
}
    </style>
</head>
<body>
    <?php
    require "Views/view_navbar.php";
    ?>
<div class="banner-area text-center">
    <h2>Lien</h2>
    <p>Découvrer les liens entre vos acteurs et vos films préférer</p>
    <a href="#form" class="buttonAcceuil">Découvrir</a>
    
</div>

    <div class="content-area">
        <div class="wrapper1 text-center">
            <h2 id="form">Trouver</h2>
        
            <form class="form" method="post" action="?controller=trouver&action=trouver">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="label" for="searchFilm">Champ 1</label>
                    <input type="text" class="form-control" id="searchFilm" name="champ1" placeholder="Entrez le nom d'un film ou acteur" required>
                </div>
                <div class="form-group col-md-6">
                    <label class="label" for="searchFilm">Champ 2</label>
                    <input type="text" class="form-control" id="searchActor" name="champ2" placeholder="Entrez le nom d'un film ou acteur" required>
                </div>
            </div>

            <div class="form-group">
                <label for="searchType">Type de recherche :</label>
                <select class="form-control" id="searchType" name="type">
                    <option value="film">Film</option>
                    <option value="acteur">Acteur</option>
                </select>
            </div>

            <button type="submit" class="button">Rechercher</button>
        </form>

        </div>
    </div>

    


    <div class="wrapper">
        <div class="container">
            <input type="radio" name="slide" id="c1" checked>
            <label for="c1" class="card">
                <div class="row">
                    <div class="description">
                        <h4>Recherche</h4>
                        <p>Rechercher vos acteurs et vos film préférer</p>
                        <a href="?controller=recherche" class="button btn-c1">Découvrir</a>
                    </div>
                </div>
            </label>
            <input type="radio" name="slide" id="c2" >
            <label for="c2" class="card">
                <div class="row">
                    <div class="description">
                        <h4>Chemin le plus court</h4>
                        <p>Découvrer le chemin le plus court entre vos acteur ou vos film </br>préférer</p>
                        <a href="?controller=rapprochement" class="button btn-c1">Découvrir</a>
                    </div>
                </div>
            </label>
            <input type="radio" name="slide" id="c3" >
            <label for="c3" class="card">
                <div class="row">
                    <div class="description">
                        <h4>Compte</h4>
                        <p>Connecter vous pour accéder à des fonctionnalité excptionnel</p>
                        <a href="?controller=connect" class="button btn-c1">Découvrir</a>
                    </div>
                </div>
            </label>
        </div>
    </div>

<?php require "Views/view_footer.php";?>
</body>
</html>



</body>
</html>
