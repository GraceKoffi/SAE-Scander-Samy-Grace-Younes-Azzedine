<?php
require "Views/view_navbar.php"; ?>
<style>
    .titleError{
        margin-top:200px;
        margin-left: 100px;
    }

    .errorParagraphe{
        padding-top: 20px;
        margin-bottom: 50px;
        margin-left: 100px;
    }

    .error{
        margin-bottom: 100px;
        padding-bottom: 200px;
    }

    .button-acceuil{
        margin-left: 110px;
    }

    .bouton-favori{
        border-radius: 10px 5%;
        background-color: yellow;
        padding: 10px 20px;
        font-size: 15px;
    }
</style>
<?php
    if(strpos($tab, "Mail") !== false){
        $titre = "Regarder votre boite mail";
    }
    else if(strpos($tab, "reinitialiser")){
        $titre = "Mot de passe reinitisalier";
    }
    else if(strpos($tab, 'Merci')){
        $titre = "Merci pour votre message";
    }

    else {
        $titre = "Une erreur est survenue";
    }

    $paragraphe = $tab;
?>

<div class="container error">
    <div class="row mx-auto align-items-center">
        <div class="col">
            <h1 class="titleError"><?php echo $titre ?></h1>
            <p class="errorParagraphe"><?php echo $paragraphe ?></p>
        </div>
    </div>
    <div class="container button-acceuil">
        <div class="row align-items-center">
            <a href='?controller=home'>
                <button id='favoriButton' class='bouton-favori boutonFonctionnalite'>
                    Retour à l'acceuil
                </button>
            </a>
        </div>
    </div>
</div>





<?php require "Views/view_footer.php";


