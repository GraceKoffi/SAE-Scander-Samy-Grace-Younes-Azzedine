<?php
session_start(); 

Class Controller_Connect extends Controller{
    public function action_form(){
        $this->render("connect_user", []);
    }
    
    public function action_render_user($username){
        $m = Model::getModel();
        $result = $m->getUserData($username);   
        $this->render("connect_user", $result);
        
    }

    public function action_settings(){
        #$m = Model::getModel();
        #$tab = $m->getUserDataSettings($_SESSION['username']);
        #$this->render("connect_setting", $tab);
        $this->render("connect_setting", []);
    }


    public function action_login(){
        if(isset($_POST['userName']) && isset($_POST['passWord'])){
            $m = Model::getModel();
            $result = $m->loginUser([
                "username" => e($_POST['userName']), 
                "password" => e($_POST['passWord'])
            ]);
            if(isset($result['status']) && $result['status'] == "KO"){
                $tab = $result['message'];
                $this->render("error", $tab);
            }
            else{
                $_SESSION['username'] = e($_POST['userName']); 
                $this->action_render_user(e($_POST['userName']));
            }
        }
        else{
            $tab = ["Champ Manquant"];
            $this->render("error", $tab);
        }

    }
    
    public function action_signup(){
        if(isset($_POST['userName']) && isset($_POST['passWord'])){
            $m = Model::getModel();
            $result = $m->addUser([
                "username" => e($_POST['userName']), 
                "password" => e($_POST['passWord'])
            ]);
            if(isset($result['status']) && $result['status'] == "KO"){
                $tab = $result['message'];
                $this->render("error", $tab);
            }
            else{
                $_SESSION['username'] = e($_POST['userName']); 
                $this->action_render_user(e($_POST['userName']));
            }
        }
        else{
            $tab = ["Champ Manquant"];
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