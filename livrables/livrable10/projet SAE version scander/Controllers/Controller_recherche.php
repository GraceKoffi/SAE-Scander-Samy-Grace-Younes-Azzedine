<?php
class Controller_recherche extends Controller {

    public function action_home() {
        $m = Model::getModel();
        $tab = [];
        $this->render("recherche", $tab);
    }


    public function action_rechercher() {
        $m = Model::getModel();

        if ($_POST['type'] == 'titre') {
            $titre = isset($_POST['search']) && $_POST['search'] !== '' ? $_POST['search'] : null;
            $types = isset($_POST['types']) && $_POST['types'] !== '' ? $_POST['types'] : null;
            $dateSortieMin = isset($_POST['dateSortieMin']) && $_POST['dateSortieMin'] !== '' ? $_POST['dateSortieMin'] : null;
            $dateSortieMax = isset($_POST['dateSortieMax']) && $_POST['dateSortieMax'] !== '' ? $_POST['dateSortieMax'] : null;
            $dureeMin = isset($_POST['dureeMin']) && $_POST['dureeMin'] !== '' ? $_POST['dureeMin'] : null;
            $dureeMax = isset($_POST['dureeMax']) && $_POST['dureeMax'] !== '' ? $_POST['dureeMax'] : null;
            $genresArray = isset($_POST['genres']) ? $_POST['genres'] : null;
            $genres = $this->buildGenresRegex($genresArray);
        
            
            $tab = [
                "recherchetitre" =>  $m->rechercheTitre($titre, $types, $dateSortieMin, $dateSortieMax, $dureeMin, $dureeMax, $genres),     
            ];
            
            if(isset($_SESSION['username'])){
                $data = [
                    "UserName" => $_SESSION['username'],
                    "TypeRecherche" => "Recherche",
                    "MotsCles" => $_POST['search']
                ];
                $result = $m->addUserRecherche($data);
                if(!empty($result)){
                    $tab = ["tab" => $result["message"]];
                    $this->render("error", $tab);
                }
            }
            $this->render("recherche", $tab);

            


        } elseif ($_POST['type'] == 'personne') {
            $nom = isset($_POST['search']) && $_POST['search'] !== '' ? $_POST['search'] : null;
            $dateNaissance = isset($_POST['dateNaissance']) && $_POST['dateNaissance'] !== '' ? $_POST['dateNaissance'] : null;
            $dateDeces = isset($_POST['dateDeces']) && $_POST['dateDeces'] !== '' ? $_POST['dateDeces'] : null;
            $metierArray = isset($_POST['metier']) && $_POST['metier'] !== '' ? $_POST['metier'] : null;
            $metier = $this->buildGenresRegex($metierArray);
            
            $resultatActeur=$m->recherchepersonne($nom,$dateNaissance,$dateDeces,$metier,$pageActeur,$perPageActeur,$_SESSION['orderby']);

            $tab = ["recherchepersonne" => $resultatActeur['recherchepersonne'],
        
        
        ];
        

            $this->render("recherche", $tab);
        }
    }




    public function action_default() {
        $this->action_home();
    }
// Fonction pour construire la regex pour les genres
private function buildGenresRegex($aArray) {
    $a = "";
    if ($aArray !== null) {
        foreach ($aArray as $g) {
            $a .= "(?=.*" . $g . ")";
        }
    }
    else{

        $a=null;
    }
    return $a;
}

}