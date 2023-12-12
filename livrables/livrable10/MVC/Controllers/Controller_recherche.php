<?php
Class Controller_recherche extends Controller{

    public function action_fom_rechercher(){  

        $this->render("recherche");

    }


    public function action_get_suggestions() {
        if (isset($_GET['type']) && isset($_GET['recherche'])) {
            $type = $_GET['type'];
            $recherche = $_GET['recherche'];

            $db = Model::getModel();

            if ($type === 'nom') {
                $suggestions = $db->get_NameSuggestions($recherche);
            } elseif ($type === 'titre') {
                $suggestions = $db->get_TitleSuggestions($recherche);
            } else {
                // Gérer le type inconnu, si nécessaire
                $suggestions = [];
            }

            // Envoyer les suggestions au format JSON
            echo json_encode($suggestions);
        } else {
            // Gérer les paramètres manquants, si nécessaire
            echo json_encode([]);
        }
    }

    public function action_afficher(){
        if(isset($_POST['type']) and (isset($_POST['recherche']) and $_POST['recherche'] !=='')){
            if($_POST['type'] == 'nom'){
                $db = Model::getModel();
                if (sizeof($db->form_recherche_acteur(e($_POST['recherche']))) != 0){
                    $data = ["data" => $db->form_recherche_acteur(e($_POST['recherche']))];
                    $this->render("afficher", $data);
                }
                else{
                    $data = ["data" => $db->get_info_acteur(e($_POST['recherche']))];
                    $this->render("afficher", $data);
                }
            }
            else if($_POST['type'] == 'titre'){
                $db = Model::getModel();
                if(sizeof($db->form_recherche_film(e($_POST['recherche']))) != 0){
                    $data = ["data" => $db->form_recherche_film(e($_POST['recherche']))];
                    $this->render("afficher", $data);
                }
                else{
                    $data = ["data" => $db->get_info_film(e($_POST['recherche']))];
                    $this->render("afficher", $data);
                }
            }
            else {
                $message = ["message" => "Une erreur dans la selection de la recherche"];
                $this->render("error", $message);

            }
      
            
        }
        else{
                $message = ["message" => "Valeur manquante"];
                $this->render("error", $message);
        }    
    }


    public function action_afficher_film(){
        $db = Model::getModel();
        $data = ["data" => $db->form_recherche_film(e($_GET['id']))];
        $this->render("afficher_film", $data);

    }


    public function action_afficher_acteur(){
        $db = Model::getModel();
        $data = ["data" => $db->form_recherche_acteur(e($_GET['nom']))];
        $this->render("afficher", $data);


    }





    public function action_default()
    {
        $this->action_fom_rechercher() ;
    }

}
