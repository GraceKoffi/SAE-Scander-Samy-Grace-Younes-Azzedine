<?php

class Controller_rapprochement extends Controller {
    public function action_fom_rapprochement()
    {
        $this->render("afficher_form_rapprochement");
    }

    public function action_afficher_rapprochement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier si les champs nécessaires sont définis
            if (isset($_POST['type'], $_POST['start'], $_POST['end'])) {
                $type = $_POST['type'];
                $start = $_POST['start'];
                $end = $_POST['end'];
    
                // Vérifier le type pour appeler la fonction appropriée du modèle
                $model = Model::getModel();
                if ($type === 'acteur') {
                    $result = $model->findShortestPathActeur($start, $end);
                } elseif ($type === 'film') {
                    $result = $model->findShortestPathFilm($start, $end);
                } else {
                    $message = ["message" => "Type de recherche non valide."];
                    $this->render("error", $message);
                    return;
                }
    
                // Vérifier si un résultat a été trouvé
                if ($result) {
                    $data = ["data" => $result];
                    $this->render("afficher_shortest_path", $data);
                } else {
                    $message = ["message" => "Aucun chemin trouvé."];
                    $this->render("error", $message);
                }
            } else {
                $message = ["message" => "Paramètres manquants."];
                $this->render("error", $message);
            }
        } else {
            // Redirection si la méthode HTTP n'est pas POST
            header("Location: ?controller=home");
            exit;
        }
    }
    

    public function action_default()
    {
        $this->action_fom_rapprochement();
    }
}
