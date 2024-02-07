<?php

Class Controller_Connect extends Controller{
    public function action_form(){
        $this->render("connect", []);
    }
    
    public function action_render_user($username){
        $m = Model::getModel();
        $result = $m->getUserData($username);   
        $tab = ["tab" => $result];
        $this->render("connect_user", $tab);
        
    }

    public function action_settings(){
        $m = Model::getModel();
        $tab =["tab" => $m->getUserDataSettings($_SESSION['username'])];
        $this->render("connect_setting", $tab);
    }

    public function action_render_rechercheData(){
        $m = Model::getModel();
        if(isset($_GET["type"])){
            $data = [
                "username" => $_SESSION['username'],
                "type" => trim(e($_GET['type']))
            ];
            $tab = ["tab" => $m->getRechercherData($data)];
            $this->render("rechercheData", $tab);    
        }
        else{
            $tab = ["tab" => "Valeur manquant"];
            $this->render("error", $tab);
        }
    }

    public function action_login(){
        if(isset($_POST['userName']) && isset($_POST['passWord'])){
            $m = Model::getModel();
            $result = $m->loginUser([
                "username" => trim(e($_POST['userName'])), 
                "password" => trim(e($_POST['passWord']))
            ]);
            if(isset($result['status']) && $result['status'] == "KO"){
                $tab =["tab" => $result['message']];
                $this->render("error", $tab);
            }
            else{
                $_SESSION['username'] = trim(e($_POST['userName']));
                $_SESSION['password'] = trim(e($_POST['passWord']));
                $this->action_render_user($_SESSION['username']);
                exit();
            }
        }
        else{
            $tab = ["tab" =>"Champ Manquant"];
            $this->render("error", $tab);
        }

    }

    public function action_updateSettings(){
            // Récupérez les données du formulaire
            $username = isset($_POST["username"]) ? $_POST["username"] : null;
            $name = isset($_POST["Name"]) ? $_POST["Name"] : null;
            $email = isset($_POST["email"]) ? $_POST["email"] : null;
            $newPassword = isset($_POST["newPassword"]) ? $_POST["newPassword"] : null;
            $country = isset($_POST["country"]) ? $_POST["country"] : null;

            // Appelez la méthode du modèle pour mettre à jour les paramètres
            $model = Model::getModel();
            $result = $model->updateSettings(trim(e($username)), trim(e($name)), trim(e($email)), trim(e($newPassword)), trim(e($country)));
            if(!$result != false){
               $_SESSION['username'] = trim(e($username));
               $this->action_render_user($username);
            }
            else{
                $tab = ["tab" =>"Error"];
                $this->render("error", $tab);
            }
            
    }
    
    public function action_signup(){
        if(isset($_POST['userName']) && isset($_POST['passWord'])){
            $m = Model::getModel();
            $result = $m->addUser([
                "username" => trim(e($_POST['userName'])), 
                "password" => trim(e($_POST['passWord']))
            ]);
            if(isset($result['status']) && $result['status'] == "KO"){
                $tab =["tab" => $result['message']];
                $this->render("error", $tab);
            }
            else{
                $_SESSION['username'] = trim(e($_POST['userName']));
                $_SESSION['password'] = trim(e($_POST['passWord']));
                $this->action_render_user($_SESSION['username']);
                exit();
            }
        }
        else{
            $tab = ["tab" =>"Champ Manquant"];
            $this->render("error", $tab);
        }
    }
    
    public function action_logout(){
        session_unset(); 
        session_destroy(); 
        $this->action_form();
    }
    
    public function action_default(){
        if(isset($_SESSION['username'])){
            $this->action_render_user($_SESSION['username']);
        }
        else{
            $this->action_form();
        }
    }
}
