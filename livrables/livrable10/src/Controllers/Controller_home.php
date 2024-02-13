<?php

Class Controller_home extends Controller{

    public function action_home(){
        // Vérifiez si c'est une requête AJAX.
        if (isset($_POST["suggestion"])) {
            $m = Model::getModel();
            $suggestions = $m->suggestion($_POST["suggestion"]);
            
            // Renvoyer les suggestions sous forme de JSON.
            echo json_encode($suggestions);
            return; // Important pour éviter le rendu d'une vue après une réponse AJAX.
        }
    
        // Si ce n'est pas une requête AJAX, continuez avec le rendu normal de la page.
        $this->render("home");
    }
    
    public function action_voirtousresultat(){
        $m = Model::getModel();
        if (isset($_POST["search-input"])){

            $tab = [ 'resultat' => $m->voirtousresultat($_POST["search-input"]),
                            
                        
                        ];
                    $this->render("voirtousresultat", $tab);

        }
        else{

            $tab = [ 'resultat' => $m->voirtousresultat($_GET["mot"]),
                            
                        
                      ];
                    $this->render("voirtousresultat", $tab);

                    }      


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