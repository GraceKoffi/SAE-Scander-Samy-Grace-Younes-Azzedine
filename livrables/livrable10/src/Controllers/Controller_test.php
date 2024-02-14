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





<?php

class Model
{
    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;

    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;

    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {
        include "./credentials.php";
        $this->bd = new PDO($dsn, $login, $mdp);
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd->query("SET nameS 'utf8'");
    }

    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getInformationsActeur($id){

        $requete = $this->bd->prepare("SELECT 
            nconst, primaryname, birthyear, deathyear, primaryprofession
            FROM name_basics
            WHERE nconst = :id ;");

        $requete->bindParam(':id', $id, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);

    }

    public function getInformationsFilmParticipant($id){

        $requete = $this->bd->prepare("SELECT tb.primarytitle,tb.tconst
        FROM title_basics tb
        JOIN title_principals tp ON tb.tconst = tp.tconst
        LEFT JOIN title_ratings tr ON tb.tconst = tr.tconst
        WHERE tp.nconst = :id AND tr.numVotes > 10000
        ORDER BY RANDOM()
        LIMIT 4;");

        $requete->bindParam(':id', $id, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getInformationsActeurParticipant($id){

        $requete = $this->bd->prepare("SELECT 
        tp.nconst,
        nb.primaryName AS nomActeur,
        COALESCE(nb.birthyear::TEXT, 'Inconnu') AS dateActeur,
        COALESCE(tp.characters, 'Inconnu') AS nomDeScene
        
        
    FROM 
        title_principals tp
    JOIN 
        name_basics nb ON tp.nconst = nb.nconst
    WHERE 
        tp.category IN ('actor', 'actress')
        AND tp.tconst = :id ;");

        $requete->bindParam(':id', $id, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);

    }




    public function getInformationsMovie($id) {
        $requete = $this->bd->prepare("SELECT
        COALESCE(tb.primaryTitle, 'Inconnu') AS primaryTitle,
        COALESCE(tb.startYear::TEXT, 'Inconnu') AS startYear,
        COALESCE(tb.runtimeMinutes::TEXT, 'Inconnu') AS runtimeMinutes,
        COALESCE(tb.genres, 'Inconnu') AS genres,
        COALESCE(tr.averagerating::TEXT, 'Inconnu') AS averagerating
        
       
    FROM
        title_basics tb
        LEFT JOIN title_ratings tr ON tb.tconst = tr.tconst
        
       
    WHERE
        tb.tconst = :id ;"
        );
   
        
        $requete->bindParam(':id', $id, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }



    public function getInformationsDirector($id) {
        $requete = $this->bd->prepare("SELECT 
        tb.tconst,
       STRING_AGG(nb.primaryName, ', ') AS realisateur
    FROM 
        title_basics tb
    JOIN 
        title_principals tp ON tb.tconst = tp.tconst
    JOIN 
        name_basics nb ON tp.nconst = nb.nconst
    WHERE 
        tb.tconst = :id 
        AND tp.category = 'director'
    GROUP BY 
        tb.tconst
    HAVING 
        EXISTS (
            SELECT 1
            FROM title_principals
            WHERE tconst = :id AND category = 'director'
        ); ");
   


        
        $requete->bindParam(':id', $id, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }



    public function suggestion($mot) {
        $requete = $this->bd->prepare("(SELECT nconst AS id, primaryName AS name, 'acteur' AS type, birthYear AS date, primaryProfession AS role
        FROM name_basics
        WHERE primaryName ILIKE :mot
        LIMIT 2)
        
        UNION ALL
        
        (SELECT tconst AS id, primaryTitle AS name, 'film' AS type, startYear AS date, titleType AS role
        FROM title_basics
        WHERE primaryTitle ILIKE :mot
        LIMIT 3)
        
       
        LIMIT 5;
         ");
   

        $mot = trim($mot);
        $mot= "%".$mot."%";
        $requete->bindParam(':mot', $mot, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function voirtousresultat($mot) {
        $requete = $this->bd->prepare("(SELECT nconst AS id, primaryName AS name, 'acteur' AS type, birthYear AS date, primaryProfession AS role
        FROM name_basics
        WHERE primaryName ILIKE :mot )
        
        UNION ALL
        
        (SELECT tconst AS id, primaryTitle AS name, 'film' AS type, startYear AS date, titleType AS role
        FROM title_basics
        WHERE primaryTitle ILIKE :mot );
        
        
         ");
   

         $mot = trim($mot);//retirer les espace au debut et à la fin 
        $mot= "%".$mot."%";
        $requete->bindParam(':mot', $mot, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function rechercheFilm($titre, $types, $dateSortieMin, $dateSortieMax, $dureeMin, $dureeMax, $genres, $noteMin, $noteMax, $votesMin, $votesMax,$pageFilm,$perPageFilm,$orderby) {
        $sql = "SELECT COUNT(*) OVER() AS total, tb.tconst, tb.primaryTitle, tb.titletype, tb.startyear, tb.runtimeminutes, tb.genres, tr.averageRating, tr.numVotes
                FROM title_basics tb
                LEFT JOIN title_ratings tr ON tb.tconst = tr.tconst
                WHERE 1=1 ";
    
        if ($titre !== null) {
            $sql .= " AND tb.primaryTitle = :titre";
            //$sql .= " AND similarity(tb.primaryTitle, :titre) > 0.5";
        }
       
        if ($types !== null) {
            $sql .= " AND tb.titletype = :types";
        }
    
        if ($dateSortieMin !== null) {
            $sql .= " AND tb.startyear >= :dateSortieMin";
        }
    
        if ($dateSortieMax !== null) {
            $sql .= " AND tb.startyear <= :dateSortieMax";
        }
    
        if ($dureeMin !== null) {
            $sql .= " AND tb.runtimeminutes >= :dureeMin";
        }
    
        if ($dureeMax !== null) {
            $sql .= " AND tb.runtimeminutes <= :dureeMax";
        }
       
        if ($genres !== null) {
            $sql .= " AND tb.genres ~* :genres";
        }
        
    
        if ($noteMin !== null) {
            $sql .= " AND tr.averageRating>= :noteMin";
        }
    
        if ($noteMax !== null) {
            $sql .= " AND tr.averageRating <= :noteMax";
        }
    
        if ($votesMin !== null) {
            $sql .= " AND tr.numVotes >= :votesMin";
        }
    
        if ($votesMax !== null) {
            $sql .= " AND tr.numVotes <= :votesMax";
        }
       
        //$sql .= " ORDER BY $orderby";
        //$sql .= " LIMIT :perPageFilm OFFSET :offset;";



       

        $requete = $this->bd->prepare($sql);

      //$total = ($pageFilm - 1) * $perPageFilm;

        // Ajoutez les paramètres pour la pagination
        //$requete->bindParam(':perPageFilm', $perPageFilm, PDO::PARAM_INT);
        //$requete->bindParam(':offset', $total, PDO::PARAM_INT);
        //$requete->bindParam(':orderby', $orderby, PDO::PARAM_STR);
    
     
    

        if ($titre !== null) {
            //$titre = '%' . $titre . '%';
            $requete->bindParam(':titre', $titre, PDO::PARAM_STR);
        }

        if ($types !== null) {
                $requete->bindParam(':types', $types, PDO::PARAM_STR);
            }
        
        if ($dateSortieMin !== null) {
            $requete->bindParam(':dateSortieMin', $dateSortieMin, PDO::PARAM_INT);
        }
    
        if ($dateSortieMax !== null) {
            $requete->bindParam(':dateSortieMax', $dateSortieMax, PDO::PARAM_INT);
        }
    
        if ($dureeMin !== null) {
            $requete->bindParam(':dureeMin', $dureeMin, PDO::PARAM_INT);
        }
    
        if ($dureeMax !== null) {
            $requete->bindParam(':dureeMax', $dureeMax, PDO::PARAM_INT);
        }
    

        if ($genres !== null) {
            $requete->bindParam(':genres', $genres, PDO::PARAM_STR);
        }
    
    
        if ($noteMin !== null) {
            $requete->bindParam(':noteMin', $noteMin, PDO::PARAM_INT);
        }
    
        if ($noteMax !== null) {
            $requete->bindParam(':noteMax', $noteMax, PDO::PARAM_INT);
        }
    
        if ($votesMin !== null) {
            $requete->bindParam(':votesMin', $votesMin, PDO::PARAM_INT);
        }
    
        if ($votesMax !== null) {
            $requete->bindParam(':votesMax', $votesMax, PDO::PARAM_INT);
        }

    
        $requete->execute();
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        return [
            'totalResultatFilm' => $resultats[0]['total'],
            'recherchefilms' => $resultats
        ];
    }
    
    
        
    
    public function recherchepersonne($nom,$dateNaissance,$dateDeces,$metier,$pageActeur, $perPageActeur, $ordre) {
     $sql = "SELECT  COUNT(*) OVER() AS total, nconst, primaryname, birthyear, deathyear, primaryprofession
            FROM name_basics
            WHERE 1=1 ";
            

            if ($nom !== null) {
                $sql .= " AND similarity (primaryname, :nom) > 0.4 ";
            }
    
            if ($dateNaissance !== null) {
                $sql .= " AND birthyear = :dateNaissance ";
            }

            if ($dateDeces !== null) {
                $sql .= " AND deathyear = :dateDeces ";
            }
            if ($metier !== null) {
                $sql .= " AND primaryprofession ~* :metier";
            }
            $sql .= " ORDER BY " . $ordre;

            $sql .= " LIMIT :perPageActeur OFFSET :offset ;";
      

        $requete = $this->bd->prepare($sql);

      $total = ($pageActeur - 1) * $perPageActeur;

        // Ajoutez les paramètres pour la pagination
        $requete->bindParam(':perPageActeur', $perPageActeur, PDO::PARAM_INT);
        $requete->bindParam(':offset', $total, PDO::PARAM_INT);
           

            if ($nom !== null) {
                $nom = '%' . $nom . '%';
                $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
            }
            if ($dateNaissance !== null) {
                $requete->bindParam(':dateNaissance', $dateNaissance, PDO::PARAM_INT);
            }
            if ($dateDeces !== null) {
                $requete->bindParam(':dateDeces', $dateDeces, PDO::PARAM_INT);
            }
            if ($metier !== null) {
                $requete->bindParam(':metier', $metier, PDO::PARAM_STR);
            }
        $requete->execute();

        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        return [
            'totalResultatActeur' => $resultats[0]['total'],
            'recherchepersonne' => $resultats
        ];
    }
    

    public function FilmEnCommun($primaryName1, $primaryName2)
    {
        

        $sql = "SELECT tb.primaryTitle
        FROM title_basics AS tb
        JOIN title_principals AS tp1 ON tb.tconst = tp1.tconst
        JOIN title_principals AS tp2 ON tb.tconst = tp2.tconst
        JOIN name_basics AS nb1 ON tp1.nconst = nb1.nconst
        JOIN name_basics AS nb2 ON tp2.nconst = nb2.nconst
        WHERE nb1.primaryName = :actor1 AND nb2.primaryName = :actor2;"; //Type Acteur Facultatif
        
        $query = $this->bd->prepare($sql);
        $query->bindParam(':actor1', $primaryName1, PDO::PARAM_STR);
        $query->bindParam(':actor2', $primaryName2, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } 

    public function ActeurEnCommun($primaryTitle1, $primaryTitle2)
    {
       

        $sql = "SELECT DISTINCT nb1.nconst, nb1.primaryName
        FROM name_basics AS nb1
        JOIN title_principals AS tp1 ON nb1.nconst = tp1.nconst
        JOIN title_basics AS tb1 ON tp1.tconst = tb1.tconst
        JOIN title_principals AS tp2 ON nb1.nconst = tp2.nconst
        JOIN title_basics AS tb2 ON tp2.tconst = tb2.tconst
        WHERE tb1.primaryTitle = :movie1 AND tb2.primaryTitle = :movie2;"; //Type Acteur Facultatif
        $query = $this->bd->prepare($sql);
        $query->bindParam(':movie1', $primaryTitle1, PDO::PARAM_STR);
        $query->bindParam(':movie2', $primaryTitle2, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
}


    public function getNcont($primaryName){
        $sql = "SELECT nconst
                FROM name_basics
                WHERE primaryName = :primaryName";

        $query = $this->bd->prepare($sql);
        $PrimaryName = e($primaryName);
        $query->bindParam(':primaryName', $PrimaryName, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_NUM);
    }


    public function getTconst($primaryTitle){
        $sql = "SELECT tconst
                FROM title_basics
                WHERE primaryTitle = :primaryTitle;
                ";
        $query = $this->bd->prepare($sql);
        $PrimaryTitle = e($primaryTitle);
        $query->bindParam(':primaryTitle', $PrimaryName, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_NUM);
    }
    
    public function getUserId($username) {
        $sql = "SELECT userId FROM UserData WHERE username = :username";
        $query = $this->bd->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function userExist($username) {
        $sql = "SELECT EXISTS(SELECT 1 FROM UserData WHERE username = :username) as exists";
        $query = $this->bd->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }


    public function getUserData($username) {
        $userId = $this->getUserId($username)["userid"];

        $totalSearchSql = "SELECT COUNT(*) AS totalRecherches FROM RechercheData WHERE userId = :userId";
        $totalSearchQuery = $this->bd->prepare($totalSearchSql);
        $totalSearchQuery->bindParam(':userId', $userId, PDO::PARAM_INT);
        $totalSearchQuery->execute();
        $totalSearch = $totalSearchQuery->fetch(PDO::FETCH_ASSOC);
        
        
        $sql = "SELECT
        MAX(CASE WHEN typeRecherche = 'Trouver' THEN rehcercheTime END) AS Trouver,
        MAX(CASE WHEN typeRecherche = 'Rapprochement' THEN rehcercheTime END) AS Rapprochement,
        MAX(CASE WHEN typeRecherche = 'Recherche' THEN rehcercheTime END) AS Recherche
        FROM
            RechercheData
        WHERE
            userId = :userId
        GROUP BY
            userId;
        ";
        $results = $this->bd->prepare($sql);
        $results->bindParam(':userId', $userId, PDO::PARAM_INT);
        $results->execute();

        $RechercheTime = $results->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT
        COUNT(CASE WHEN typeRecherche = 'Trouver' THEN 1 END) AS CountTrouver,
        COUNT(CASE WHEN typeRecherche = 'Rapprochement' THEN 1 END) AS CountRapprochement,
        COUNT(CASE WHEN typeRecherche = 'Recherche' THEN 1 END) AS CountRecherche
        FROM
            RechercheData
        WHERE
            userId = :userId;
        ";
        $results = $this->bd->prepare($sql);
        $results->bindParam(':userId', $userId, PDO::PARAM_INT);
        $results->execute();
        $TotalParType = $results->fetch(PDO::FETCH_ASSOC);
        
        
        return [
            "Total" => $totalSearch,
            "RecherTime" => $RechercheTime,
            "TotalParType" => $TotalParType
        ];
    }

    public function addUser($data) {
        if ($this->userExist($data["username"])["exists"] == false) {
            try {
                $insertSql = "INSERT INTO UserData (username, password, connectionTime)
                VALUES (:username, :password, CURRENT_TIMESTAMP);";
                $insertQuery = $this->bd->prepare($insertSql);
                $insertQuery->bindParam(':username', $data["username"], PDO::PARAM_STR);
                $password = password_hash($data["password"], PASSWORD_BCRYPT);
                $insertQuery->bindParam(':password', $password, PDO::PARAM_STR);
                $insertQuery->execute();
    
                return [
                    "status" => "OK",
                    "message" => "Add Successfully"
                ];
            }
            catch(PDOException $e){
                return [
                    "status" => "KO",
                    "message" => "Error adding user : ". $e->getMessage()
                ];
            }
        } else {
            return [
                "status" => "KO",
                "message" => "This user already exists"
            ];
        }
    }

    public function addUserRecherche($data) {
        try {
            $userId = $this->getUserId($data["UserName"])["userid"];

            $sql = "INSERT INTO RechercheData (userId, typeRecherche, motCle, rehcercheTime) VALUES (:userId, :TypeRecherche, :MotsCles, CURRENT_TIMESTAMP)";
            $query = $this->bd->prepare($sql);
            $query->bindParam(':userId', $userId, PDO::PARAM_INT);
            $query->bindParam(':TypeRecherche', $data["TypeRecherche"], PDO::PARAM_STR);
            if(is_array($data["MotsCles"])){
                $MotCle = implode(", ", $data["MotsCles"]);
            }
            else{
                $MotCle = $data["MotsCles"];
            }
            $query->bindParam(':MotsCles', $MotCle, PDO::PARAM_STR);
            $query->execute();
        }
        catch(PDOException $e){
            return [
                "status" => "KO",
                "message" => "Error adding data: " . $e->getMessage()
            ];
        }
    }

    public function loginUser($data) {
    
        $pwdMatchSql = "SELECT password FROM UserData WHERE username = :username";
        $pwdMatchQuery = $this->bd->prepare($pwdMatchSql);
        $pwdMatchQuery->bindParam(':username', $data['username'], PDO::PARAM_STR);
        $pwdMatchQuery->execute();
        $pwd_match = $pwdMatchQuery->fetch(PDO::FETCH_ASSOC);
        $this->updateConnectionTime($this->getUserId($data['username'])["userid"]);
        if (password_verify($data["password"], $pwd_match["password"])) {
            return $this->getUserData($data["username"]);
        } else {
            return [
                "status" => "KO",
                "message" => "Password doesn't match"
            ];
        }
    }

    public function updateConnectionTime($userId){
        $sql = "UPDATE UserData SET connectionTime = CURRENT_TIMESTAMP WHERE userId = :userId";
        $query = $this->bd->prepare($sql);
        $query->bindParam(":userId", $userId, PDO::PARAM_INT);
        return $query->execute();
    }
    

    public function updatePassword($data) {
        try {
            $sql = "UPDATE UserData
            SET password = :nouveauPassword
            WHERE userId = :userId;";
            $query = $this->bd->prepare($sql);
            $password = password_hash($data["password"], PASSWORD_BCRYPT);
            $query->bindParam(':nouveauPassword', $password, PDO::PARAM_STR);
            $query->bindParam(':userId', $data["userId"], PDO::PARAM_STR);
            $query->execute();
    
            return [
                "status" => "OK",
                "message" => "Update Successfully"
            ];
        } catch (PDOException $e) {
            return [
                "status" => "KO",
                "message" => "Error updating password: " . $e->getMessage()
            ];
        }
    }
    
    public function updateUsername($data) {
        try {
            $sql = "UPDATE UserData
                    SET username = :nouveauUsername
                    WHERE userId = :userId;";
            $query = $this->bd->prepare($sql);
            $query->bindParam(':nouveauUsername', $data['username'], PDO::PARAM_STR);
            $query->bindParam(':userId', $data["userId"], PDO::PARAM_STR);
            $query->execute();
    
            return [
                "status" => "OK",
                "message" => "Update Successfully"
            ];
        } catch (PDOException $e) {
            return [
                "status" => "KO",
                "message" => "Error updating username: " . $e->getMessage()
            ];
        }
    }

    public function getUserDataSettings($username){
        $userId = $this->getUserId($username)["userid"];
        $sql = "SELECT * FROM UserData WHERE userId = :userId";
        $query = $this->bd->prepare($sql);
        $query->bindParam(":userId", $userId, PDO::PARAM_INT); // Utilisez :userId ici
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateSettings($ancien_username, $username, $name, $email, $newPassword, $country)
    {
    $updateFields = [];
    $updateParams = [];

    if ($username != null) {
        $updateFields[] = 'username = :username';
        $updateParams[':username'] = $username;
    }

    if ($name != null) {
        $updateFields[] = 'name = :name';
        $updateParams[':name'] = $name;
    }

    if ($email != null) {
        $updateFields[] = 'email = :email';
        $updateParams[':email'] = $email;
    }

    if ($newPassword != null) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $updateFields[] = 'password = :password';
        $updateParams[':password'] = $hashedPassword;
    }

    if ($country != null) {
        $updateFields[] = 'country = :country';
        $updateParams[':country'] = $country;
    }

    if (!empty($updateFields)) {
        $sql = 'UPDATE UserData SET ' . implode(', ', $updateFields) . ' WHERE userId = :userId';
        $query = $this->bd->prepare($sql);
        $updateParams[':userId'] = $this->getUserId($ancien_username)['userid'];

        return $query->execute($updateParams);
    }
    return false;
    }

    public function getRechercherData($data){
        $userId = $this->getUserId($data["username"])["userid"];
        $sql = "SELECT * FROM RechercheData WHERE userId = :userId AND TypeRecherche = :typeData;";
        $query = $this->bd->prepare($sql);
        $query->bindParam(":userId", $userId, PDO::PARAM_STR);
        $query->bindParam(":typeData", $data["type"], PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
}











<div class="container">
<h2>Tableau Triable</h2>
<table id="monTableau" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Type</th>
            <th>Date</th>
            <th>Durée (en minute)</th>
            <th>Genres</th>
        </tr>
    </thead>
    <tbody>
        
    <?php foreach ($recherchetitre as $v) : ?>
                <tr>
                <a href="?controller=home&action=information_acteur&id=<?= e($v['nconst']) ?>">
                    <td> <?= e($v['primarytitle']) ?></td>
                    <td> <?= e($v['titletype']) ?></td>
                    <td> <?= e($v['startyear']) ?> </td>
                    <td> <?= e($v['runtimeminutes']) ?> </td>
                    <td> <?= e($v['genres']) ?> </td>
                </a>   
                </tr>
            <?php endforeach ?> 
       
    </tbody>
</table>
</div>

<script>
$(document).ready(function() {
$('#monTableau').DataTable({
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
    }
});
});
</script>