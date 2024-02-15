<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login & Registration Form</title>
  <!---Custom CSS File--->
  <link rel="stylesheet" href="style.css">
</head>
<body>
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
  
</style>
<body>   
<!-- <img class="scroll-reveal logo" src="Images/findercine1.jpg" alt="Logo Musee de France" width="100">
    <nav class="scroll-reveal">
        <a class="translate" href="?controller=home">Accueil</a>
        <a class="translate" href="?controller=recherche">Rechercher</a>
        <a class="translate" href="?controller=trouver">Trouver</a>
        <a class="translate" href="?controller=rapprochement">Rapprochement</a> -->

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
                $message = "Aucun Champ saisie";
                $alertClass = "alert-danger";
                break;
            case -2:
                $message = "Le mot de passe saisie ne correspond pas";
                $alertClass = "alert-danger";
                break;
            case -3:
                $message = "Une erreur est survenue dans l'enregistrement";
                $alertClass = "alert-danger";
                break;
            case -4:
                $message = "Une erreur est survenue dans la connection à votre compte";
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
<div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
        <h1>Connection</h1>
        <form id="loginForm" action="?controller=connect&action=login" method="post">
          <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur.</div>
            <input type="text" placeholder="Entrer votre nom d'utilisateur" name="userName" class="form-control" required>
            <div class="invalid-feedback">Veuillez entrer votre mot de passe.</div>
            <input type="password" placeholder="Entrer votre mot de passe" name="passWord" class="form-control" required>
            <a href="?controller=resetPassWord">Mot de passe oublier ?</a>
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



<script>
// JavaScript pour valider le formulaire
   // Supposons que l'ID de votre alerte est 'myAlert'
var alertElement = document.getElementById('myAlert');

// Faire disparaître l'alerte après 3 secondes
window.setTimeout(function() {
    alertElement.setAttribute('hidden', true);
}, 2000);

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

// document.getElementById('signupForm').addEventListener('submit', function(event) {
//     var inputs = this.getElementsByTagName('input');
//     for (var i = 0; i < inputs.length; i++) {
//         if (inputs[i].value == '') {
//             inputs[i].classList.add('is-invalid');
//             event.preventDefault();
//         } else {
//             inputs[i].classList.remove('is-invalid');
//         }
//     }
//     var password = document.getElementById('signupPassword').value;
//     var confirmPassword = document.getElementById('confirmPassword').value;
//     if (password != confirmPassword) {
//         document.getElementById('confirmPassword').classList.add('is-invalid');
//         event.preventDefault();
//     } else {
//         document.getElementById('confirmPassword').classList.remove('is-invalid');
//     }
// });

</script>

</body>
</html>