<style>
    /* Import Google font - Poppins */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
body{
  min-height: 100vh;
  width: 100%;
  background-color: black;
}
.container{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  max-width: 430px;
  width: 100%;
  background: #fff;
  border-radius: 7px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.3);
}
.container .registration{
  display: none;
}
#check:checked ~ .registration{
  display: block;
}
#check:checked ~ .login{
  display: none;
}
#check{
  display: none;
}
.container .form{
  padding: 2rem;
}
.form header{
  font-size: 2rem;
  font-weight: 500;
  text-align: center;
  margin-bottom: 1.5rem;
}
 .form input{
   height: 60px;
   width: 100%;
   padding: 0 15px;
   font-size: 17px;
   margin-bottom: 1.3rem;
   border: 1px solid #ddd;
   border-radius: 6px;
   outline: none;
 }
 .form input:focus{
   box-shadow: 0 1px 0 rgba(0,0,0,0.2);
 }
.form a{
  font-size: 16px;
  color: #009579;
  text-decoration: none;
}
.form a:hover{
  text-decoration: underline;
}
.form input.button{
  color: #fff;
  background: #009579;
  font-size: 1.2rem;
  font-weight: 500;
  letter-spacing: 1px;
  margin-top: 1.7rem;
  cursor: pointer;
  transition: 0.4s;
}
.form input.button:hover{
  background: #006653;
}
.signup{
  font-size: 17px;
  text-align: center;
  margin-right: 500px;
}
.signup label{
  color: #009579;
  cursor: pointer;
}
.signup label:hover{
  text-decoration: underline;
}

.submit-btn {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    transition-duration: 0.4s;
}

.submit-btn:hover {
    background-color: white; 
    color: black; 
    border: 2px solid #4CAF50;
}
.mdp{
  margin-bottom: 20px;
}

  
</style>

  <?php
    require "Views/view_navbar.php";
    // Récupérer la variable 'retour' de l'URL
    if(isset($_GET['retour'])){
        $retour = trim(e($_GET['retour']));
        switch ($retour) {
            case 0:
                $message = "Cet utilisateur n'existe pas";
                $alertClass = "alert-danger";
                break;
            case -1:
                $message = "Aucun Champ saisie veuillez saisir un champs";
                $alertClass = "alert-danger";
                break;
            case -2:
                $message = "Le mot de passe saisie ne correspond pas au premier mot de passe saisie";
                $alertClass = "alert-danger";
                break;
            case -3:
                $message = "Une erreur est survenue dans la création du compte";
                $alertClass = "alert-danger";
                break;
            case -4:
                $message = "Une erreur est survenue lors de la connection à votre compte";
                $alertClass = "alert-danger";
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
                    <p style='border-left:2px solid black ;padding-left: 5px;'>
                      <img style='transform: scale(0.7); padding-bottom: 2px;' src='Images/icons8-warning-50.png' alt='warning'>$message
                    </p>
                </div>
              </div>";
        }
    }
    ?> 
<div class="container formulaire">
    <input type="checkbox" id="check">
    <div class="login form">
        <h1>Connection</h1>
        <form id="loginForm" action="?controller=connect&action=login" method="post">
          <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur.</div>
            <input type="text" placeholder="Entrer votre nom d'utilisateur" name="userName" class="form-control" required>
            <div class="invalid-feedback">Veuillez entrer votre mot de passe.</div>
            <input type="password" placeholder="Entrer votre mot de passe" name="passWord" class="form-control" required>
            <div class="mdp">
            <a href="?controller=resetPassWord">Mot de passe oublier ?</a>
            </div>
            <input type="submit" class="btn btn-primary submit-btn" value="Connection">
        </form>
        <div class="signup">
            <span class="signup">Pas de compte ?
             <label for="check">Creer un compte</label>
            </span>
        </div>
    </div>
    <div class="registration form">
        <h1>Creer un compte</h1>
        <form id="signupForm" action="?controller=connect&action=signup" method="post">
          <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur.</div>
            <input type="text" placeholder="Entrer votre nom d'utilisateur" name="userName" class="form-control" required>
            <div class="invalid-feedback">Veuillez créer un mot de passe.</div>
            <input type="password" id="signupPassword" placeholder="Créer un mot de passe" name="passWord" class="form-control" required>
            <div class="invalid-feedback">Veuillez confirmer votre mot de passe.</div>
            <input type="password" id="confirmPassword" placeholder="Confirmer votre mot de passe" class="form-control" name="secondPassword" required>
            <input type="submit" class="btn btn-primary submit-btn" value="Creer un compte">
        </form>
      
        <div class="signup">
            <span class="signup">Vous avez un compte
             <label for="check">Connection</label>
            </span>
        </div>
      </div>
    </div>
</div>



<script>
// JavaScript pour valider le formulaire
   // Supposons que l'ID de votre alerte est 'myAlert'
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

document.getElementById('loginForm').addEventListener('submit', function(event) {
    var inputs = this.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].value == '') {
            inputs[i].classList.add('is-invalid');
            event.preventDefault();
        } else {
            inputs[i].classList.remove('is-invalid');
        }
    }
});


</script>
