<?php

Class Controller_home extends Controller{

    public function action_home(){
        $m = Model::getModel();
        $tab = [ 
        
            ];
        $this->render("home", $tab);

    }

    public function action_information_movie(){
        $m = Model::getModel();
        $tab = [ 'info' => $m->getInformationsMovie($_GET["id"]),
                  'realisateur'=>$m->getInformationsDirector($_GET["id"]),
                  'acteur'=>$m->getInformationsActeurParticipant($_GET["id"]),
            
            ];
        $this->render("informations", $tab);


    }
    public function action_information_acteur(){
        $m = Model::getModel();
        $tab = [ 'titre'=>$m->getInformationsFilmParticipant($_GET["id"]),
                  'info'=>$m->getInformationsActeur($_GET["id"]),
                  
            
            ];
        $this->render("acteur", $tab);


    }

    public function action_contact(){
        $m = Model::getModel();
        $tab = [ 
                  
            
            ];
        $this->render("contact", $tab);


    }
    public function action_default(){

        $this->action_home();

    }

}