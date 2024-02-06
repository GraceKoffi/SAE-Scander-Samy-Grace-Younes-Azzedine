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
        JOIN title_ratings tr ON tb.tconst = tr.tconst
        
       
    WHERE
        tb.tconst = :id ;"
        );
   
        
        $requete->bindParam(':id', $id, PDO::PARAM_INT);
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



  
    public function rechercheFilm($titre, $types, $dateSortieMin, $dateSortieMax, $dureeMin, $dureeMax, $genres, $noteMin, $noteMax, $votesMin, $votesMax,$pageFilm,$perPageFilm,$orderby) {
        $sql = "SELECT COUNT(*) OVER() AS total, tb.tconst, tb.primaryTitle, tb.titletype, tb.startyear, tb.runtimeminutes, tb.genres, tr.averageRating, tr.numVotes
                FROM title_basics tb
                LEFT JOIN title_ratings tr ON tb.tconst = tr.tconst
                WHERE 1=1 ";
    
        if ($titre !== null) {
            $sql .= " AND tb.primaryTitle = :titre";
        }
        //AND similarity(tb.primaryTitle, :titre) > 0.5
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
        $sql .= " LIMIT :perPageFilm OFFSET :offset;";



       

        $requete = $this->bd->prepare($sql);

      $total = ($pageFilm - 1) * $perPageFilm;

        // Ajoutez les paramètres pour la pagination
        $requete->bindParam(':perPageFilm', $perPageFilm, PDO::PARAM_INT);
        $requete->bindParam(':offset', $total, PDO::PARAM_INT);
        //$requete->bindParam(':orderby', $orderby, PDO::PARAM_STR);
    
     
    

        if ($titre !== null) {
            //$titre = '%' . $titre . '%';
            $requete->bindParam(':titre', trim($titre), PDO::PARAM_STR);
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
            $requete->bindParam(':dureeMin', trim($dureeMin), PDO::PARAM_INT);
        }
    
        if ($dureeMax !== null) {
            $requete->bindParam(':dureeMax', trim($dureeMax), PDO::PARAM_INT);
        }
    

        if ($genres !== null) {
            $requete->bindParam(':genres', $genres, PDO::PARAM_STR);
        }
    
    
        if ($noteMin !== null) {
            $requete->bindParam(':noteMin', trim($noteMin), PDO::PARAM_INT);
        }
    
        if ($noteMax !== null) {
            $requete->bindParam(':noteMax', trim($noteMax), PDO::PARAM_INT);
        }
    
        if ($votesMin !== null) {
            $requete->bindParam(':votesMin', trim($votesMin), PDO::PARAM_INT);
        }
    
        if ($votesMax !== null) {
            $requete->bindParam(':votesMax', trim($votesMax), PDO::PARAM_INT);
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
        $sql = "SELECT UserId FROM user WHERE UserName = :username";
        $query = $this->bd->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function userExist($username) {
        $sql = "SELECT EXISTS(SELECT 1 FROM User WHERE UserName = :username) as exists";
        $query = $this->bd->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserData($username) {
        if ($this->userExist($username)) {
            $userId = $this->getUserId($username);
            $userDataSql = "SELECT * FROM user WHERE UserName = :username";
            $userDataQuery = $this->bd->prepare($userDataSql);
            $userDataQuery->bindParam(':username', $username, PDO::PARAM_STR);
            $userDataQuery->execute();

            $userData = $userDataQuery->fetchAll(PDO::FETCH_ASSOC);

            $rechercheSql = "SELECT * FROM User JOIN Recherche ON User.userId = Recherche.UserId WHERE User.userId = :userId";
            $rechercheQuery = $this->bd->prepare($rechercheSql);
            $rechercheQuery->bindParam(':userId', $userId, PDO::PARAM_INT);
            $rechercheQuery->execute();

            $rechercheData = $rechercheQuery->fetchAll(PDO::FETCH_ASSOC);

            return [
                "dataUser" => $userData,
                "dataRecherche" => $rechercheData
            ];
        } else {
            return [
                "dataUser" => [],
                "dataRecherche" => [],
            ];
        }
    }

    public function addUser($data) {
        if (!$this->userExist($data["username"])) {
            try {
                $insertSql = "INSERT INTO User (username, password) VALUES (:username, crypt(:password, gen_salt('bf')))";
                $insertQuery = $this->bd->prepare($insertSql);
                $insertQuery->bindParam(':username', $data["username"], PDO::PARAM_STR);
                $insertQuery->bindParam(':password', $data["password"], PDO::PARAM_STR);
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
            $userId = $this->getUserId($data["UserName"]);

            $sql = "INSERT INTO recherche (UserId, TypeRecherche, MotsCles, DateConnection) VALUES (:userId, :TypeRecherche, :MotsCles, CURRENT_TIMESTAMP)";
            $query = $this->bd->prepare($sql);
            $query->bindParam(':userId', $userId, PDO::PARAM_INT);
            $query->bindParam(':TypeRecherche', $data["TypeRecherche"], PDO::PARAM_STR);
            $query->bindParam(':MotsCles', $data["MotsCles"], PDO::PARAM_STR);
            $query->execute();

            return [
                "status" => "OK",
                "message" => "Add Successfully"
            ];
        }
        catch(PDOException $e){
            return [
                "status" => "KO",
                "message" => "Error adding data: " . $e->getMessage()
            ];
        }
    }

    public function loginUser($data) {
        if (!$this->userExist($data["username"])) {
            return [
                "status" => "KO",
                "message" => "This user does not exist"
            ];
        } else {
            $pwdMatchSql = "SELECT (password = crypt(:password, password)) AS pwd_match FROM User WHERE username = :username";
            $pwdMatchQuery = $this->bd->prepare($pwdMatchSql);
            $pwdMatchQuery->bindParam(':password', $data['password'], PDO::PARAM_STR);
            $pwdMatchQuery->bindParam(':username', $data['username'], PDO::PARAM_STR);
            $pwdMatchQuery->execute();
            $pwd_match = $pwdMatchQuery->fetchColumn();
            
            if ($pwd_match) {
                return $this->getUserData($data["username"]);
            } else {
                return [
                    "status" => "KO",
                    "message" => "Password doesn't match"
                ];
            }
        }
    }

    public function updatePassword($data) {
        try {
            $sql = "UPDATE User
                    SET password = :nouveauPassword
                    WHERE userId = :userId;";
            $query = $this->bd->prepare($sql);
            $query->bindParam(':nouveauPassword', $data['password'], PDO::PARAM_STR);
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
            $sql = "UPDATE User
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
        $userId = $this->getUserId($username);
        $sql = "SELECT * FROM User WHERE userId = :userId";
        $query = $this->bd->prepare($sql);
        $query->bindParam(":userid", $userId, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    
}



