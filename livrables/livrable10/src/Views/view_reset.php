<?php require "Views/view_navbar.php";?>

<style>
    .error{
        margin-top: 100px;
    }

    .inputReset{
        margin-top: 20px;
    }

    .labelReset{
        margin-top:10px;
    }

    .resetForm{
        margin-left: 10px;
    }

</style>

<div class="container error">
    <div class="row mx-auto align-items-center">
        <div class="col">
            <h1 class="titleError">Reinitilisation du mot de passe</h1>
            <p class="errorParagraphe">Ici vous pouvez réinitiliser votre mot de passe</p>
        </div>
    </div>
    <div class="container resetForm">
        <div class="row align-items-center">
            <div class="formulaire mx-auto col-md">
                <form action='?controller=resetFinal&action=resetFinal&token=<?php echo $_GET['token']; ?>' method='post'> 
                    <div class='form-group'>
                            <label for='token' class="labelReset">Réinitialiser votre mot de passe</label>
                                <div class="inputReset">
                                    <input type='text' class='form-control' id='passWord' name='passWord'>
                                </div>
                                
                                <div class="inputReset">
                                    <input type='submit' class='btn btn-primary submit-btn' value='Reinitialiser mot de passe'>
                                </div>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
</div>


