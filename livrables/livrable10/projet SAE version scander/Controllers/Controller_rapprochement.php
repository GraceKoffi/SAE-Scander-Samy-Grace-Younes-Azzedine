<?php
Class Controller_rapprochement extends Controller{
    public function action_fom_rapprochement()
    {
        $this->render("rapprochement", []);
    }
    
    public function action_rapprochement()
    {
        if (isset($_POST['champ1']) && isset($_POST['champ2']) && isset($_POST['type'])) {
            $m = Model::getModel();
        
            $debut = '';
            $fin = '';
            $val1 = '';
            $val2 = '';
        
            if (e($_POST['type']) == "Film") {
                $debut = 'tconst1';
                $fin = 'tconst2';
                $val1 = $m->getTconst(e($_POST['champ1']))[0];
                $val2 = $m->getTconst(e($_POST['champ2']))[0];
            } else {
                $debut = 'nconst1';
                $fin = 'nconst2';
                $val1 = $m->getNcont(e($_POST['champ1']))[0];
                $val2 = $m->getNcont(e($_POST['champ2']))[0];
            }
        
            $postData = array(
                $debut => $val1,
                $fin => $val2,
                // Ajoutez d'autres données si nécessaire
            );
        
            // Convertir le tableau en format JSON
            $jsonData = json_encode($postData);
        
            // URL de l'API
            $apiUrl = 'http://127.0.0.1:5001/result';
        
            // Configuration des options pour la requête HTTP POST
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/json",
                    'method'  => 'POST',
                    'content' => $jsonData,
                ),
            );
        
            // Créer un contexte pour la requête HTTP POST
            $context  = stream_context_create($options);
        
            // Exécuter la requête HTTP POST et récupérer la réponse
            $apiResponse = @file_get_contents($apiUrl, false, $context); // Utilisation de @ pour supprimer les avertissements
        
        if ($apiResponse !== false) {
                // Traiter la réponse de l'API (la réponse est généralement en format JSON)
                $result = json_decode($apiResponse, true);
        
                // Faire quelque chose avec le résultat
                $tab = ["tab" => $result];
                $this->render("rapprochement_result", $tab);
            
        }
        }else{
            $tab = ["tab" => "Champ manquant"];
            $this->render("error", $tab);
        }
        
    }

    
    public function action_default()
    {
        $this->action_fom_rapprochement();
    }
}