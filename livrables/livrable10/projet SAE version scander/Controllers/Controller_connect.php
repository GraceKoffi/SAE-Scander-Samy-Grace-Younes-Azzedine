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
                $this->action_render_user($_SESSION['username']);
                exit();
            }
        }
        else{
            $tab = ["tab" =>"Champ Manquant"];
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
