<?php
class Controller_resetPassWord extends Controller{
    public function action_resetIHM($tab, $etape){
        $_GET['etape'] = $etape;
        $this->render("resetPassWord", $tab);
    }

    public function action_resetEtape1(){
        if(isset($_POST['username'])) {
            $m = Model::getModel();
            if($m->userExist(trim(e($_POST['username'])))["exists"] == true) {
                $_SESSION['usernameResetPass'] = trim(e($_POST['username']));
                $email = $m->emailExist(trim(e($_POST['username'])));
                var_dump($email);
                if(empty($email)) {
                    $tab = [
                        "tab" => ["Message" => "Aucun email saisie pour l'utilisateur", 
                        "username" => trim(e($_POST['username'])), 
                        "type" => 1]
                    ];
                    $this->action_resetIHM($tab, 2);
                }
                else{
                    $_SESSION['passWordActif'] = $email;
                    $tab = [ 
                        "tab" => ["Message" => "Email trouver pour l'utilisateur", 
                        "username" => trim(e($_POST['username'])), 
                        "type" => 2, 
                        "email" => $email]
                    ];
                    $this->action_resetIHM($tab, 2);
                }
            }
            else{
                $_GET['retour'] = -1;
                $this->action_resetIHM([], 1);

            }
         }else{
            $this->action_default();
         }
    }

    public function action_resetEtape2(){
        if(isset($_SESSION['usernameResetPass'])){
                $m = Model::getModel();
                $result = $m->CreateToken($_SESSION['usernameResetPass']);
                if($result['status'] == "OK"){
                    $token = $result['token'];
                    $mail = require "mailer.php"; 
                    if(isset($_POST['email'])){
                        $email = trim(e($_POST['email']));
                    }
                    else{
                        $email = $_SESSION['passWordActif'];
                    }
                    var_dump($email[0]);
                    $mail->addAddress($email[0]);
                    $mail->Subject = "Password Reset";
                    $mail->Body = <<<END

                    Click <a href="http://localhost/sae/SAE-Scander-Samy-Grace-Younes-Azzedine/livrables/livrable10/src/?controller=resetFinal&token=$token">here</a> 
                    to reset your password.

                    END;

                    try {
                        $email = $email[0];
                        $mail->send();
                        $tab = ["tab" => "Mail envoyer à $email regarder votre boite mail"];
                        $this->render("error", $tab);


                    } catch (Exception $e) {

                        $_GET['retour'] = -2;
                        echo $e;
                        $this->action_resetIHM([], 2);

                    }
                }
                else{
                    $_GET['retour'] = -2;
                    $this->action_resetIHM([], 2);
                }
            }
            else{
                $_GET['retour'] = -2;
                $this->action_resetIHM([], 2);

            }
    }


    public function action_resetEtape3(){
        if(isset($_GET['token'])){
            $m = Model::getModel();
            /*
            $result = $m->getUserIdWithToken(trim(e($_GET['token'])));
            $_SESSION['userId'] = $result['userId'];
            */
            $this->render("reset", []);
            /*
            if($result["type"] == 1){
                $_GET["retour"] = -3;
                $this->action_resetIHM([], 1);
            }
            else if($result['type'] == 2){
                $_GET['retour'] = -4;
                $this->action_resetIHM([], 1);
            }
            else{
                $_SESSION['userId'] = $result['userId'];
                $this->render("reset", []);
            }
            */
            }
        }
    
    public function action_resetFinal(){
        if(isset($_POST['passWord']) && isset($_GET['token'])){
            $m = Model::getModel();
            $result = $m->getUserIdWithToken(trim(e($_GET['token'])));
            $data = [
                "userId" => $result["userId"],
                "password" => trim(e($_POST['passWord']))
            ];
            $result = $m->updatePassword($data);
            if($result['status'] == "OK"){
                $tab = ["tab" => "message ok"];
                $this->render("reset", $tab);
            }
            else{
                $tab = ["tab" => "Error dans la modification du mot de passe"];
                $this->render("error", $tab);
            }
        }
    }
    
    public function action_default(){
        $etape = 1;
        $tab = [];
        $this->action_resetIHM($tab, $etape);
    }
}