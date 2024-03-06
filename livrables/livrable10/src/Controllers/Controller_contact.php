<?php
class Controller_contact extends Controller{
    public function action_contact(){
        if(isset($_SESSION['username'])){
            $m = Model::getModel();
            $email = $m->emailExist($_SESSION['username']);
            $name = $m->getName($_SESSION['username']);
            $tab = [
                "tab" => [$email, $name]
            ];
            $this->render("contact", $tab);

        }
        $this->render("contact", []);
    }
    

    public function action_send(){
        $mail = require "mailer.php"; 
        if(isset($_POST['email']) && isset($_POST['nom']) && isset($_POST['message'])){
            $email = trim(e($_POST['email']));
            $name = trim(e($_POST['nom']));
            $message = trim(e($_POST['message']));
            $mail->addAddress($email);
            $mail->Subject = "Merci pour votre message $name";
            $mail->Body = <<<END

            Votre message : $message

            END;
            try {
                $mail->send();
                $tab = ["tab" => "Merci pour votre message"];
                $tab[] = ["notification" => "Mail envoyer"];
                $this->render("error", $tab);

            } catch (Exception $e) {

                $tab = ["tab" => "Une erreur est survenu"];
                $this->render("error", $tab);

            }

        }
        else{
            $tab = ["tab" => "Une erreur est survenu"];
            $this->render("error", $tab);

        }
    }
    
    
    public function action_default(){
        $this->action_contact();
    }
}