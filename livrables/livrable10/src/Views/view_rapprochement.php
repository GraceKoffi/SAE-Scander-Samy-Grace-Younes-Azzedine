<script src="https://unpkg.com/scrollreveal@4.0.7/dist/scrollreveal.min.js"></script>

<style>
        body {
            margin: 0;
            padding: 0;
            font-family: Helvetica, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden; /* Allow horizontal scrolling if necessary */
            overflow-y: auto; /* Allow vertical scrolling */
        }




        #canvas {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 0;
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
    

    .paragraphe{
        margin-top: 100px;
    }

    .form{
        margin-top: 100px;
    }
    .fonctionnalite{
        margin-top: 100px;
    }

</style>

<body>
<canvas id="canvas"></canvas>    
<?php require "Views/view_navbar.php";?>
<!-- <header>
    <img class="scroll-reveal logo" src="Images/findercine1.jpg" alt="Logo Musee de France" width="100">
    <nav class="scroll-reveal">
        <a class="translate" href="?controller=home">Accueil</a>
        <a class="translate" href="?controller=recherche">Rechercher</a>
        <a class="translate" href="?controller=trouver">Trouver</a>
        <a class="translate" href="?controller=rapprochement">Rapprochement</a>
        <a class="translate" href="?controller=connect"></a>
    </nav>
</header> -->
<div class="paragraphe">
    <h1 style="color: #000;">Explorez l'univers fascinant du cinéma</h1>
    <p style="color: #000;">
        Découvrez la magie du septième art à travers des connexions uniques. Notre fonctionnalité de rapprochement vous permet de lier deux films ou deux personnalités à travers une chaîne captivante. Sélectionnez vos favoris et explorez les acteurs et les films qui les unissent !
    </p>
</div>

<div class="form-container form">
    <h2 class="form-title">Lancez-vous</h2>
    <form action="?controller=rapprochement&action=rapprochement" method="post" style="text-align: center;">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <input type="text" placeholder="Champ 1" class="form-input" id="champ1" name="champ1" required>
            <input type="text" placeholder="Champ 2" class="form-input" id="champ2" name="champ2" required>
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




<?php require "Views/view_footer.php";?>
</body>

<script>

// Get the canvas element and set its width and height
var canvas = document.getElementById('canvas');
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

// Get the context of the canvas
var ctx = canvas.getContext('2d');

// Create an array to store the dots
var dotsArray = [];

// Define the Dot class
class Dot {
    constructor(x, y) {
        this.x = x;
        this.y = y;
        this.speedX = (Math.random() - 0.5) * 3;
        this.speedY = (Math.random() - 0.5) * 3;
        this.size = Math.random() * 5 + 1;
    }

    // Method to draw a dot
    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2, false);
        ctx.fillStyle = '#000';
        ctx.fill();
    }

    // Method to update the position of a dot
    update() {
        this.x += this.speedX;
        this.y += this.speedY;

        if (this.x < 0 || this.x > canvas.width) {
            this.speedX *= -1;
        }

        if (this.y < 0 || this.y > canvas.height) {
            this.speedY *= -1;
        }

        this.draw();
    }

    // Method to calculate the distance to another dot
    distanceTo(otherDot) {
        var dx = this.x - otherDot.x;
        var dy = this.y - otherDot.y;
        return Math.sqrt(dx * dx + dy * dy);
    }
}

// Function to initialize the dots
function initDots() {
    for (var i = 0; i < 50; i++) {
        var x = Math.random() * canvas.width;
        var y = Math.random() * canvas.height;
        dotsArray.push(new Dot(x, y));
    }
}

// Function to animate the dots
function animateDots() {
    requestAnimationFrame(animateDots);
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (var i = 0; i < dotsArray.length; i++) {
        dotsArray[i].update();
    }

    connectDots(); // Call the new function
}

// Function to draw lines between close dots
function connectDots() {
    for (var i = 0; i < dotsArray.length; i++) {
        for (var j = i + 1; j < dotsArray.length; j++) {
            var dot1 = dotsArray[i];
            var dot2 = dotsArray[j];

            var distance = dot1.distanceTo(dot2);
            if (distance < 100) { // You can adjust this value
                ctx.beginPath();
                ctx.moveTo(dot1.x, dot1.y);
                ctx.lineTo(dot2.x, dot2.y);
                ctx.strokeStyle = '#000';
                ctx.stroke();
            }
        }
    }
}

// Call the functions
initDots();
animateDots();


</script>
