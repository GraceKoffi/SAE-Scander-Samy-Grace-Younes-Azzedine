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
        

        

        
    }

    public function action_default()
    {
        return $this->action_fom_trouver();
    }

}