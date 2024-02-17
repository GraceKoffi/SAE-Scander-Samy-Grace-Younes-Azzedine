<?php
class Controller_recherche extends Controller {

    public function action_home() {
        $m = Model::getModel();
        $tab = [];
        $this->render("recherche", $tab);
    }


    public function action_rechercher() {
        $m = Model::getModel();

        if ($_POST['typeselection'] == 'titre') {
            $titre = isset($_POST['search']) && trim($_POST['search']) !== '' ? $_POST['search'] : null;
            $types = isset($_POST['types']) ? $_POST['types'] : null;
            $dateSortieMin = isset($_POST['dateSortieMin']) && trim($_POST['dateSortieMin']) !== '' ? $_POST['dateSortieMin'] : null;
            $dateSortieMax = isset($_POST['dateSortieMax']) && trim($_POST['dateSortieMax']) !== '' ? $_POST['dateSortieMax'] : null;
            $dureeMin = isset($_POST['dureeMin']) && trim($_POST['dureeMin']) !== '' ? $_POST['dureeMin'] : null;
            $dureeMax = isset($_POST['dureeMax']) && trim($_POST['dureeMax']) !== '' ? $_POST['dureeMax'] : null;
            $genresArray = isset($_POST['genres']) ? $_POST['genres'] : null;
            $genres = $this->buildGenresRegex($genresArray);
            $noteMin = isset($_POST['noteMin']) && $_POST['noteMin'] !== '' ? $_POST['noteMin'] : null;
            $noteMax = isset($_POST['noteMax']) && $_POST['noteMax'] !== '' ? $_POST['noteMax'] : null;
            $votesMin = isset($_POST['votesMin']) && $_POST['votesMin'] !== '' ? $_POST['votesMin'] : null;
            $votesMax = isset($_POST['votesMax']) && $_POST['votesMax'] !== '' ? $_POST['votesMax'] : null;
            
            $tab = [
                "recherchetitre" =>  $m->rechercheTitre($titre, $types, $dateSortieMin, $dateSortieMax, $dureeMin, $dureeMax, $genres, $noteMin, $noteMax, $votesMin, $votesMax), 
                "titrerecherche" => $titre,  
                 
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
            $this->render("rechercheavancee_resultat", $tab);

            


        } elseif ($_POST['typeselection'] == 'personne') {
            $nom= isset($_POST['search']) && trim($_POST['search']) !== '' ? $_POST['search'] : null;            
            $dateNaissanceMin = isset($_POST['dateNaissanceMin']) && trim($_POST['dateNaissanceMin']) !== '' ? $_POST['dateNaissanceMin'] : null;
            $dateNaissanceMax = isset($_POST['dateNaissanceMax']) && trim($_POST['dateNaissanceMax']) !== '' ? $_POST['dateNaissanceMax'] : null;
            $dateDecesMin = isset($_POST['dateDecesMin']) && trim($_POST['dateDecesMin']) !== '' ? $_POST['dateDecesMin'] : null;
            $dateDecesMax = isset($_POST['dateDecesMax']) && trim($_POST['dateDecesMax']) !== '' ? $_POST['dateDecesMax'] : null;
            $metierArray = isset($_POST['metier']) && $_POST['metier'] !== '' ? $_POST['metier'] : null;
            $metier = $this->buildGenresRegex($metierArray);
            
            

            $tab = ["recherchepersonne" =>$resultatActeur=$m->recherchepersonne($nom,$dateNaissanceMin,$dateNaissanceMax,$dateDecesMin,$dateDecesMax,$metier),
        
        
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