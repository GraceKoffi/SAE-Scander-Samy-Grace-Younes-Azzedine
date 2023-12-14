<?php
Class Controller_trouver extends Controller{


    public function action_fom_trouver()
    {
        $this->render("trouver");
    }
    

    public function action_get_suggestions() {
        if (isset($_GET['type']) && isset($_GET['recherche'])) {
            $type = $_GET['type'];
            $recherche = $_GET['recherche'];

            $db = Model::getModel();

            if ($type === 'acteur') {
                $suggestions = $db->get_NameSuggestions($recherche);
            } elseif ($type === 'film') {
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


    public function action_afficher()
    {
        if(isset($_POST['type']) and (isset($_POST['recherche1']) and $_POST['recherche1'] !== '') and (isset($_POST['recherche2']) and $_POST['recherche2'] !== ''))
        {
            if($_POST['type'] == 'acteur')
            {
                $db = Model::getModel();
                $data = ["data" => $db->recherche_film($_POST['recherche1'], $_POST['recherche2'])];
                $this->render("trouver_afficher_film", $data);

            }
            else if($_POST['type'] == 'film')
            {
                $db = Model::getModel();
                $data = ["data" => $db->rechercher_acteur($_POST['recherche1'], $_POST['recherche2'])];
                $this->render("trouver_afficher_acteur", $data);
            }
            else 
            {
                $message = ["message" => "Une erreur est survenue"];
                $this->render("error", $message);
            }
        }
        else
        {
            $message = ["message" => "Valeur manquante"];
            $this->render("error", $message);
        }

        

        
    }

    public function action_default()
    {
        return $this->action_fom_trouver();
    }

}