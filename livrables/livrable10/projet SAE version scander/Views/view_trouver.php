
<script src="https://unpkg.com/scrollreveal@4.0.7/dist/scrollreveal.min.js"></script>

<style>
      body {
            margin: 0;
            padding: 0;
            font-family: Helvetica, sans-serif;
            background-color: black;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: linear-gradient(#b992db);
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .logo {
            width: 100px;
            height: 100px;
            background-image: url('Images/findercine1.jpg');
            background-size: cover;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        nav {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            position: relative;
        }

        nav a:before {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #fff;
            visibility: hidden;
            transform: scaleX(0);
            transition: all 0.3s ease-in-out;
        }

        nav a:hover:before {
            visibility: visible;
            transform: scaleX(1);
        }

        .header-text-container {
            text-align: center;
            color: white;
            margin-top: 50px;
        }

        .header-text-container h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .header-text-container p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .image-container {
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
        }

        .image-wrapper {
            margin: 10px;
            text-align: center;
            flex-basis: calc(33.33% - 20px);
            transition: transform 0.5s ease-in-out, filter 0.5s ease-in-out, blur 0.5s ease-in-out;
            overflow: hidden;
        }

        .large-image {
            width: 100%;
            height: auto;
            transition: transform 0.5s ease-in-out;
        }


        #filmCount {
            text-align: center;
            color: white;
            font-size: 1.5em;
            margin-top: 20px;
        }


        .form-container {
            position: relative;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            width: 70%;
            text-align: center;
            border-radius: 10px;
        }

        .form-input {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .form-input::placeholder {
            color: white;
        }

        .form-title {
            color: white;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .select-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .form-submit {
            background-color: #b992db;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .form-submit:hover {
            background-color: #906bb2;
        }

       .footer {
            margin-top: auto;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
        }

        .footer-section {
            flex: 1;
            text-align: center;
        }

        .footer-bottom {
            text-align: center;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
        }


        

        .footer-links li {
            transition: transform 0.4s;
            padding-top: 40px;
            padding-right: 55px;

        }
        footer a {
            color: #ffffff !important; 
            text-decoration: none !important; 
        }


        .footer-links li:hover {
            color: #ffffff !important; 
            font-weight: bold; 
            transform: scale(1.3);
        }
        
        .feature-section {
        background-color: rgba(0, 0, 0, 0.5);
        padding: 50px 0;
        text-align: center;
    }

    .feature-section h2 {
        color: #fff;
        font-size: 2em;
        margin-bottom: 30px;
    }

    .image-container {
        display: flex;
        justify-content: space-around;
        align-items: stretch;
        flex-wrap: wrap;
    }

    .image-wrapper {
        margin: 20px;
        text-align: center;
        flex-basis: calc(30% - 40px); 
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.5s ease-in-out, box-shadow 0.5s ease-in-out;
    }

     .image-wrapper:hover {
        transform: scale(1.05);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
    } 

    .large-image {
        width: 100%;
        height: auto;
        border-bottom: 2px solid #eee;
    }

    .image-wrapper h3 {
        font-size: 1.5em;
        margin: 20px 0 10px;
        color: #333;
    }

    .image-wrapper p {
        font-size: 1em;
        color: #777;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #b992db;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        transform: scale(1.05);
        background-color: #906bb2;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
    }

    .feature-section h3{
        color : #fff;
    }

    .feature-section p {
        color : #fff;
    }

    
    </style>
<body style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 1)), url('Images/54qqo354uyy11.jpg'); background-size: cover; background-attachment: fixed;">

<header>
    <img class="scroll-reveal logo" src="Images/findercine1.jpg" alt="Logo Musee de France" width="100">
    <nav class="scroll-reveal">
        <a class="translate" href="?controller=home">Accueil</a>
        <a class="translate" href="?controller=recherche">Rechercher</a>
        <a class="translate" href="?controller=trouver">Trouver</a>
        <a class="translate" href="?controller=rapprochement">Rapprochement</a>
        <a class="translate" href="?controller=Connect">Login</a>
    </nav>
</header>

<div class="header-text-container scroll-reveal">
    <h1>Trouver</h1>
    <p>
        <span>Bienvenue sur notre page "Trouver" ! Explorez le monde captivant des films et des personnalités du cinéma <br>
        en découvrant les connexions qui les unissent. Cette fonctionnalité unique vous permet de <br>
        sélectionner deux films ou deux personnes, puis de découvrir les acteurs ou les films qu'ils ont en commun
        </span>
    </p>
    <p id="filmCount" class="scroll-reveal">Avec plus de <span id="counter">0</span> films !</p>
</div>

<div class="image-container">
    <div class="image-wrapper scroll-reveal">
        <img class="large-image" src="Images/cars-3-8k-disney-movie_1536401767.jpg.webp" alt="Image 1">
    </div>
    <div class="image-wrapper scroll-reveal">
        <img class="large-image" src="Images/Spider-Man-Across-the-Spider-Verse-Movie-2023-4K-Wallpaper-jpg.webp" alt="Image 2">
    </div>
</div>

<div class="form-container scroll-reveal">
    <h2 class="form-title">Lancez-vous</h2>
    <form action="?controller=trouver&action=trouver" method="post" style="text-align: center;">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <input type="text" placeholder="Champ 1" class="form-input" id="champ1" name="champ1">
            <input type="text" placeholder="Champ 2" class="form-input" id="champ2" name="champ2">
        </div>
        <div class="select-container">
            <select class="form-input" name="type">
                <option value="Film">Film</option>
                <option value="Acteur">Acteur</option>
            </select>
        </div>
        <br>
        <input type="submit" value="Envoyer" class="form-submit">
    </form>
</div>






<section class="feature-section scroll-reveal">
    <h2>Découvrez nos fonctionnalités</h2>
    
    <div class="image-container">
        <!-- Fonctionnalité "Rechercher" -->
        <div class="image-wrapper scroll-reveal">
            <img class="large-image" src="Images/HD-wallpaper-the-flash-2023-movie-poster.jpg" alt="Rechercher">
            <h3>Rechercher</h3>
            <p>Explorez notre vaste base de données pour trouver des films, des acteurs et bien plus encore.</p>
            <a href="?controller=recherche" class="btn">En savoir plus</a>
        </div>

        <!-- Fonctionnalité "Rapprochement" -->
        <div class="image-wrapper scroll-reveal">
            <img class="large-image" src="Images/54qqo354uyy11.jpg" alt="Rapprochement">
            <h3>Rapprochement</h3>
            <p>Découvrez les liens entre deux films ou deux personnalités du cinéma grâce à notre fonctionnalité de rapprochement.</p>
            <a href="?controller=rapprochement" class="btn">En savoir plus</a>
        </div>
    </div>
</section>



<footer class="scroll-reveal footer">
    <div class="footer-content">
        <div class="footer-section about">
            <h2 class="translate" data-en="About Us" data-fr="À propos">À propos</h2>
            <p>Projet Universitaire</p>
        </div>
        <div class="footer-section links">
            <ul class="list-inline footer-links">
                <li class="list-inline-item"><a href="#"><img src="./Images/facebook.png" alt="Facebook"></a></li>
                <li class="list-inline-item"><a href="#"><img src="./Images/twitter.png" alt="Twitter"></a></li>
                <li class="list-inline-item"><a href="#"><img src="./Images/instagram.png" alt="Instagram"></a></li>
                <li class="list-inline-item"><a href="#"><img src="./Images/linkedin.png" alt="LinkedIn"></a></li>
                <li class="list-inline-item"><a href="#"><img src="./Images/youtube.png" alt="YouTube"></a></li>
            </ul>
        </div>
        <div class="footer-section contact">
            <h2 class="translate" data-en="Contact Us" data-fr="Contactez-nous">Contactez-nous</h2>
            <div class="contact-info">
                <p><i class="fas fa-map-marker-alt"></i> 1 Rue de la Légion d'Honneur, 75007 Paris, France</p>
                <p><i class="fas fa-envelope"></i> info@sae2024.com</p>
                <p><i class="fas fa-phone"></i> +33 1 23 45 67 89</p>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; 2024 Findercine. Tous droits réservés.
    </div>
</footer>

<script>
    ScrollReveal().reveal('.scroll-reveal', {
        delay: 200,
        distance: '100px',
        duration: 800,
        origin: 'bottom',
        reset: true,
        viewFactor: 0.6
    });

    const targetCount = 20000; 
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