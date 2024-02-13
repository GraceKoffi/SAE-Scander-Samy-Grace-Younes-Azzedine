<form action='?controller=resetFinal&action=resetFinal&token=<?php echo $_GET['token']; ?>' method='post'>
            <h2>Nouveau mot de passe</h2>    
            <div class='form-group'>
                    <label for='token'>Réinitialiser mot de passe</label>
                        <input type='text' class='form-control' id='passWord' name='passWord'>
                        <input type='submit' class='btn btn-primary submit-btn' value='Reinitialiser mot de passe'>
                </div>
            </form>

