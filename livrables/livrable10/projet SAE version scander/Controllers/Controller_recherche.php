<?php
class Controller_recherche extends Controller {

    public function action_home() {
        $m = Model::getModel();
        $tab = [];
        $this->render("recherche", $tab);
    }


    public function action_rechercher() {
        $m = Model::getModel();

        if ($_POST['type'] == 'film') {
            $titre = isset($_POST['search']) && $_POST['search'] !== '' ? $_POST['search'] : null;
            $types = isset($_POST['types']) && $_POST['types'] !== '' ? $_POST['types'] : null;
            $dateSortieMin = isset($_POST['dateSortieMin']) && $_POST['dateSortieMin'] !== '' ? $_POST['dateSortieMin'] : null;
            $dateSortieMax = isset($_POST['dateSortieMax']) && $_POST['dateSortieMax'] !== '' ? $_POST['dateSortieMax'] : null;
            $dureeMin = isset($_POST['dureeMin']) && $_POST['dureeMin'] !== '' ? $_POST['dureeMin'] : null;
            $dureeMax = isset($_POST['dureeMax']) && $_POST['dureeMax'] !== '' ? $_POST['dureeMax'] : null;
            $genresArray = isset($_POST['genres']) ? $_POST['genres'] : null;
            $noteMin = isset($_POST['noteMin']) && $_POST['noteMin'] !== '' ? $_POST['noteMin'] : null;
            $noteMax = isset($_POST['noteMax']) && $_POST['noteMax'] !== '' ? $_POST['noteMax'] : null;
            $votesMin = isset($_POST['votesMin']) && $_POST['votesMin'] !== '' ? $_POST['votesMin'] : null;
            $votesMax = isset($_POST['votesMax']) && $_POST['votesMax'] !== '' ? $_POST['votesMax'] : null;
            $genres = $this->buildGenresRegex($genresArray);
            $pageFilm = 1;
            $perPageFilm =  10;
            $_SESSION['orderby']=" CASE WHEN tr.numVotes IS NULL THEN 1 ELSE 0 END, tr.numVotes DESC ";
            $this->storeSessionValuesFilm($titre, $types, $dateSortieMin, $dateSortieMax, $dureeMin, $dureeMax, $genres, $noteMin, $noteMax, $votesMin, $votesMax, $perPageFilm);
            $resultatRecherche = $m->rechercheFilm(
                $titre, $types, $dateSortieMin, $dateSortieMax, $dureeMin, $dureeMax, $genres, $noteMin, $noteMax, $votesMin, $votesMax, $pageFilm, $perPageFilm, $_SESSION['orderby']);
            
            $tab = [
                "recherchefilms" => $resultatRecherche['recherchefilms'],
                "pageFilm" => $pageFilm,
                "perPageFilm" => $perPageFilm,
                "genres"=>$genres,
                "session"=>$_SESSION['orderby'],
                "totalResultatFilm" => $resultatRecherche['totalResultatFilm']
                
            ];
           
            $this->render("recherche", $tab);

            
        } elseif ($_POST['type'] == 'acteur') {
            $nom = isset($_POST['search']) && $_POST['search'] !== '' ? $_POST['search'] : null;
            $dateNaissance = isset($_POST['dateNaissance']) && $_POST['dateNaissance'] !== '' ? $_POST['dateNaissance'] : null;
            $dateDeces = isset($_POST['dateDeces']) && $_POST['dateDeces'] !== '' ? $_POST['dateDeces'] : null;
            $metierArray = isset($_POST['metier']) && $_POST['metier'] !== '' ? $_POST['metier'] : null;
            $metier = $this->buildGenresRegex($metierArray);
            $pageActeur = 1;
            $perPageActeur = 10;
            $_SESSION['orderby'] = " birthyear ";
            $this->storeSessionValuesActeur($nom,$dateNaissance,$dateDeces,$metier,$perPageActeur);
            $resultatActeur=$m->recherchepersonne($nom,$dateNaissance,$dateDeces,$metier,$pageActeur,$perPageActeur,$_SESSION['orderby']);

            $tab = ["recherchepersonne" => $resultatActeur['recherchepersonne'],
                    "pageActeur" => $pageActeur,
                    "perPageActeur" => $perPageActeur,
                    "metier"=>$metier,
                    "totalResultatActeur" => $resultatActeur['totalResultatActeur'],

        
        
        ];
        

            $this->render("recherche", $tab);
        }
    }



    public function action_paginationFilm() {
        $m = Model::getModel();
        $pageFilm = $_GET['pageFilm'];
        $resultatRecherche=$m->rechercheFilm(
            $_SESSION['search'], $_SESSION['types'], $_SESSION['dateSortieMin'], $_SESSION['dateSortieMax'],
            $_SESSION['dureeMin'], $_SESSION['dureeMax'], $_SESSION['genres'], $_SESSION['noteMin'],
            $_SESSION['noteMax'], $_SESSION['votesMin'], $_SESSION['votesMax'], $pageFilm, $_SESSION['perPageFilm'], $_SESSION['orderby']);
        $tab = [
            "recherchefilms" => $resultatRecherche['recherchefilms'],
            "pageFilm" => $pageFilm,
            "session"=>$_SESSION['orderby'],
            "genres"=>$_SESSION['genres'],
            "perPageFilm" => $_SESSION['perPageFilm'],
            "totalResultatFilm" => $resultatRecherche['totalResultatFilm'] 
        ];

        $this->render("recherche", $tab);
    }

    public function action_paginationActeur () {
        $m = Model::getModel();
        $pageActeur = $_GET['pageActeur'];
        $perPageActeur = $_SESSION['perPageActeur'];
        $resultatActeur=$m->recherchepersonne(
            $_SESSION['search'],
            $_SESSION['dateNaissance'],
            $_SESSION['dateDeces'],
            $_SESSION['metier'],
         $pageActeur, $perPageActeur,$_SESSION['orderby']);
        $tab = [
            "recherchepersonne" => $resultatActeur['recherchepersonne'],
            "metier"=> $_SESSION['metier'],
            "pageActeur" => $pageActeur,
            "perPageActeur" => $perPageActeur,
            "totalResultatActeur" => $resultatActeur['totalResultatActeur'] 
        ];

        


        $this->render("recherche", $tab);
    }

   

    public function action_trieFilm(){
        $m = Model::getModel();
        $tri_colonne = $_POST['tri_colonne'];
        $tri_ordre = $_POST['tri_ordre'];
        $_SESSION['orderby'] = $tri_colonne . " " . $tri_ordre;
       
       
        $pageFilm=1;
       
        $resultatRecherche=$m->rechercheFilm(
            $_SESSION['search'], $_SESSION['types'], $_SESSION['dateSortieMin'], $_SESSION['dateSortieMax'],
            $_SESSION['dureeMin'], $_SESSION['dureeMax'], $_SESSION['genres'], $_SESSION['noteMin'],
            $_SESSION['noteMax'], $_SESSION['votesMin'], $_SESSION['votesMax'], $pageFilm, $_SESSION['perPageFilm'], $_SESSION['orderby']);
        $tab = [
            "recherchefilms" => $resultatRecherche['recherchefilms'],
            "pageFilm" => $pageFilm,
            "session"=>$_SESSION['orderby'],
            "perPageFilm" => $_SESSION['perPageFilm'],
            "genres"=>$_SESSION['genres'],
            "totalResultatFilm" => $resultatRecherche['totalResultatFilm'] 
        ];

        $this->render("recherche", $tab);


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

    // Fonction pour stocker les valeurs dans la session
    private function storeSessionValuesFilm($titre, $types, $dateSortieMin, $dateSortieMax, $dureeMin, $dureeMax, $genres, $noteMin, $noteMax, $votesMin, $votesMax, $perPageFilm) {
        $_SESSION['search'] = $titre;
        $_SESSION['types'] = $types;
        $_SESSION['dateSortieMin'] = $dateSortieMin;
        $_SESSION['dateSortieMax'] = $dateSortieMax;
        $_SESSION['dureeMin'] = $dureeMin;
        $_SESSION['dureeMax'] = $dureeMax;
        $_SESSION['genres'] = $genres;
        $_SESSION['noteMin'] = $noteMin;
        $_SESSION['noteMax'] = $noteMax;
        $_SESSION['votesMin'] = $votesMin;
        $_SESSION['votesMax'] = $votesMax;
        $_SESSION['perPageFilm'] = $perPageFilm;
    }
    private function storeSessionValuesActeur($nom,$dateNaissance,$dateDeces,$metier,$perPageActeur) {
        $_SESSION['search'] = $nom;
        $_SESSION['dateNaissance'] = $dateNaissance;
        $_SESSION['dateDeces'] = $dateDeces;
        $_SESSION['metier'] = $metier;
        $_SESSION['perPageActeur'] = $perPageActeur;
       
    }
}
