<?php

Class Controller_home extends Controller{

    public function action_home(){
        $m = Model::getModel();
        if (isset($_POST["suggestion"])) {
           
            $suggestions = $m->suggestion($_POST["suggestion"]);
            
            // Renvoyer les suggestions sous forme de JSON.
            echo json_encode($suggestions);
            return; // Important pour éviter le rendu d'une vue après une réponse AJAX.
        }
        
        $tab = [ 'caroussel' => $m->filmpopulaire(),]; 
                            
                        
           $this->render("home",$tab);
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
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        else if(isset($_GET['filmId'])){
            $id = $_GET['filmId'];
        }
        if(isset($_SESSION['username'])){
            $userId = $m->getUserId($_SESSION['username'])["userid"];
            var_dump($m->favorieExistFilm($userId, trim(e($id))));
            
            if(empty($m->favorieExistFilm($userId, trim(e($id))))){
                $_SESSION['favori'] = 'false';
            }
            else{
                $_SESSION['favori'] = 'true';
            }
        }
        $tab = [ 'info' => $m->getInformationsMovie(trim(e($id))),
                  'realisateur'=>$m->getInformationsDirector(trim(e($id))),
                  'acteur'=>$m->getInformationsActeurParticipant(trim(e($id))),
            
            ];
            $this->render("informations", $tab);
        


    }
    public function action_information_acteur(){
        $m = Model::getModel();
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        else if(isset($_GET['acteurId'])){
            $id = $_GET['acteurId'];
        }
        if(isset($_SESSION['username'])){
            $userId = $m->getUserId($_SESSION['username'])["userid"];
            if(empty($m->favorieExistFilm($userId, trim(e($id))))){
                $_SESSION['favori'] = 'false';
            }
            else{
                $_SESSION['favori'] = 'true';
            }
        }
        $tab = [ 'titre'=>$m->getInformationsFilmParticipant(trim(e($id))),
                  'info'=>$m->getInformationsActeur(trim(e($id))),
                  
            
            ];
        $this->render("acteur", $tab);


    }

    public function action_contact(){
        $m = Model::getModel();
        $tab = [ 
                  
            
            ];
        $this->render("contact", $tab);


    }
    public function action_favorie_movie(){
        $m = Model::getModel();
        if(isset($_GET['filmId'])){
            $userId = $m->getUserId($_SESSION['username'])["userid"];
            if(empty($m->favorieExistFilm($userId, trim(e($_GET['filmId']))))){
                $m->AddFavorieFilm($userId, trim(e($_GET['filmId'])));
                
            }
            else{
                $m->RemoveFavorieFilm($userId, trim(e($_GET['filmId'])));
            }
            $this->action_information_movie();
        }
    }

    public function action_favorie_acteur(){
        $m = Model::getModel();
        if(isset($_GET['acteurId'])){
            $userId = $this->getUserId($_SESSION['username'])["userid"];
            if(empty($m->favorieExistActeur($userId, trim(e($_GET['acteurId']))))){
                $m->AddFavorieActeur($userId, trim(e($_GET['acteurId'])));

            }
            else{
                $m->RemoveFavorieActeur($userId, trim(e($_GET['acteurId'])));
            }
            $this->action_information_acteur();
        }
    }

    
    public function action_default(){

        $this->action_home();

    }

}