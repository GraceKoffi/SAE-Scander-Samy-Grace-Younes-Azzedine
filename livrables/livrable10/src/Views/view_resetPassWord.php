
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <!-- Inclure Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    .bouton{
        margin-top: 20px;
    }

    .top{
        margin-top: 100px;
    }
    .left{
        margin-left: 100px;
    }
    .buttonAnuler{
        color: white !important;
    }
</style>
<body>
<?php
require "Views/view_navbar.php";
if(isset($_GET['retour'])){
        $retour = trim(e($_GET['retour']));
        switch ($retour) {
            case 1:
                $message = "Mail Eenvoyer";
                $alertClass = "alert alert-success";
            case -1:
                $message = "Utilisateur inconnu";
                $alertClass = "alert-danger";
                break;
            case -2:
                $message = "Une erreur est surnvenu";
                $alertClass = "alert-danger";
                break;    
            case 2:
                $message = "Email inconnu";
                $alertClass = "alert-danger";
                break;
            case 3:
                $message = "Mail envoyer regardez votre boite mail";
                $alertClass = "alert-success";
            case -3 :
                $message = "Token inconnu";
                $alertClass = "alert-danger";
            case -4 :
                $message = "Le token a expiré";
                $alertClass = "alert-danger";

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
    
if(isset($tab)){
    $message = $tab['Message'] ?? ''; // Si 'Message' n'est pas défini dans le tableau, $message sera une chaîne vide.
    $username = $tab['username'] ?? ''; // Si 'username' n'est pas défini dans le tableau, $username sera une chaîne vide.
    $type = $tab['type'] ?? ''; // Si 'type' n'est pas défini dans le tableau, $type sera une chaîne vide.
    $email = $tab['email'] ?? ''; // Si 'email' n'est pas défini dans le tableau, $email sera une chaîne vide.

}else{
    $message = "";
    $username = "";
    $type = "";
    $email = "";
}



echo "<div class='conatiner top left'>";
    echo "<div class='row'";

    echo "
        <div class='col'>
    ";
    if(isset($_GET['etape'])){
        if($_GET['etape'] == 1){
            echo "
            <form action='?controller=resetPassWord&action=resetEtape1' method='post'>
                <div class='form-group'>
                    <h2>Veuillez saisir un utilisateur</h2>
                    <label for='username'>Nom d'utilisateur</label>
                        <input type='text' class='form-control' id='username' name='username' required>
                        <input type='submit' class='bouton btn btn-primary submit-btn' value='Passer prochaine etape'>
                        <a href='?' class='bouton btn btn-default buttonAnuler' id='cancel-changes'>Annuler</a>
                </div>
            </form>
            ";
        }
        if($_GET['etape'] == 2){
            echo "
            <form action='?controller=resetPassWord&action=resetEtape2' method='post'>
                <div class='form-group'>";
                    if($type == 1){
                         echo "
                            <h2>$message  $username</h2>
                                <label for='email'>Saisir une adresse mail</label>
                                    <input type='email' class='form-control' id='email' name='email' required>
                                        <input type='submit' class='btn btn-primary submit-btn' value='Passer prochaine etape'>
                                        <button type='submit' class='btn' id='save-changes'>
                                            <a href='?controller=resetPassWord&action=resetEtape1' 
                                            class='bouton btn btn-default buttonAnuler' id='cancel-changes'>Revenir en arriére</a>
                                        </button>
                                        </div>
                                    </form>
                            ";
                    }
                    else{
                        
                        echo "

                            <h2>$message  $username</h2>
                                <label for='email'>Adresse e-mail</label>
                                    <input type='email' class='form-control' id='email' name='email' value='$email' required disabled>
                                    <button type='button' class'btn btn-outline-secondary' id='edit-email'>Edit</button>
                                    <input type='submit' class='btn btn-primary submit-btn' value='Passer prochaine etape'>
                                        <button type='submit' class='bouton btn' id='save-changes'>
                                         <a href='?controller=resetPassWord&action=resetEtape1' 
                                    class='bouton btn btn-default buttonAnuler' id='cancel-changes'>Revenir en arriére</a>
                                </button>
                            </div>
                        </form>
                        ";
                    }
        }
    }   
            echo "</div>";
        echo "</div>";
    echo "</div>";
echo "</div>";
?>
    <!-- Inclure Bootstrap JS (facultatif) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    // Supposons que l'ID de votre alerte est 'myAlert'
    var alertElement = document.getElementById('myAlert');

    // Faire disparaître l'alerte après 3 secondes
    window.setTimeout(function() {
        alertElement.setAttribute('hidden', true);
    }, 2000);

    function toggleFieldAndHideButton(editBtn, inputField) {
                inputField.disabled = !inputField.disabled;
                editBtn.style.display = inputField.disabled ? 'inline-block' : 'none';
            }
    var editEmailBtn = document.getElementById("edit-email");
    var emailInput = document.getElementById("email");
    
    editEmailBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editEmailBtn, emailInput);
            });

    </script>
</body>
</html>
