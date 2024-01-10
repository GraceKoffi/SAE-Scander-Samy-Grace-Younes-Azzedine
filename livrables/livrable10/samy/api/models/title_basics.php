<?php 
class title_basics
{
    private $connection;
    private $table = "title_basics";
    public $tconst;
    public $titleType;
    public $primaryTitle;
    public $originalTitle;
    public $isAdult;
    public $startYear;
    public $endYear;
    public $runTimeMinute;
    public $genres = [];

    
    public function __construct()
    {
        require "C:\wamp64\www\api\config\config.php";
        $db = config::getConnection();
        $this->connection = $db;
        
    }

    public function home_affiche_film_action()
    {
        $sql = "WITH RankedActionMovies AS (
            SELECT
                tb.tconst,
                tb.primaryTitle,
                tb.startYear,
                tr.averageRating,
                tr.numVotes,
                tb.genres,
                tc.directors,
                nb.primaryName AS directorName,
                RANK() OVER (ORDER BY tr.numVotes DESC) AS voteRank
            FROM
                ".$this->table." tb
                JOIN 
                    title_ratings tr 
                        ON 
                            tb.tconst = tr.tconst
                JOIN 
                    title_crew tc 
                        ON 
                            tb.tconst = tc.tconst
                JOIN 
                    name_basics nb 
                        ON 
                            tc.directors = nb.nconst
            WHERE
                tb.titleType = 'movie' 
                AND 
                tb.startYear > 2020
                AND 
                'Action' = ANY (string_to_array(tb.genres, ','))
            )
            SELECT
                tconst,
                primaryTitle,
                startYear,
                directorName AS director,
                averageRating,
                numVotes
            FROM
                RankedActionMovies
            WHERE
                voteRank <= 10000
            ORDER BY
                RANDOM()
            LIMIT 20;
            ";
    
        $query = $this->connection->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);;
    }

    public function home_affiche_film_animation()
    {
        $sql = "WITH RankedAnimationMovies AS (
            SELECT
                    tb.tconst,
                    tb.primaryTitle,
                    tb.startYear,
                    tr.averageRating,
                    tr.numVotes,
                    tb.genres,
                    tc.directors,
                    nb.primaryName AS directorName,
                RANK() OVER (ORDER BY tr.numVotes DESC) AS voteRank
            FROM
                ".$this->table." tb
            JOIN 
                title_ratings tr 
                ON 
                    tb.tconst = tr.tconst
            JOIN 
                title_crew tc 
                ON 
                    tb.tconst = tc.tconst
            JOIN 
                name_basics nb 
                ON 
                    tc.directors = nb.nconst
            WHERE
                tb.titleType = 'movie' 
                AND 
                tb.startYear > 2020
                AND 
                'Animation' = ANY (string_to_array(tb.genres, ','))
            )
            SELECT
                tconst,
                primaryTitle,
                startYear,
                directorName AS director,
                averageRating,
                numVotes
            FROM
                RankedAnimationMovies
            WHERE
                voteRank <= 10000
            ORDER BY
                RANDOM()
            LIMIT 20;
            ";
        
        $query = $this->connection->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);;  
    }

    public function home_affiche_film_dsorti()
    {
        $sql = "SELECT 
                    tb.tconst, 
                    tb.primaryTitle,
                    tb.startYear, tr.averageRating, 
                    tr.numVotes
                FROM ".$this->table." tb
                
                JOIN 
                    title_ratings tr ON tb.tconst = tr.tconst
                WHERE 
                    tb.titleType = 'movie' AND tb.startYear = 2023
                ORDER BY 
                    tr.numVotes DESC
                LIMIT 20;
                ";
        $query = $this->connection->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);;
    }
    

    public function getInformationsMovie($data)
    {
        if (!isset($data['id'])){
            return ['erreur' => 'ID manquant dans les données'];
        }
        $id = htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8');
        $sql = "SELECT
                    tb.primaryTitle,
                    tb.startYear,
                    COALESCE(tb.runtimeMinutes, -1) AS runtimeMinutes,
                    tb.genres,
                    COALESCE(nb_directors.primaryName, 'Inconnu') AS realisateur,
                    COALESCE(string_agg(DISTINCT nb.primaryName, ', '), 'Inconnu') AS acteurs
                FROM
                    ".$this->table." tb
                JOIN 
                title_crew tc 
                    ON 
                        tb.tconst = tc.tconst
                LEFT JOIN 
                    title_principals tp 
                        ON 
                            tb.tconst = tp.tconst
                LEFT JOIN 
                    name_basics nb 
                        ON 
                            tp.nconst = nb.nconst
                LEFT JOIN 
                    name_basics nb_directors 
                        ON 
                            tc.directors = nb_directors.nconst
                WHERE
                    tb.tconst = :id
                GROUP BY
                    tb.tconst, tb.primaryTitle, tb.startYear, tb.runtimeMinutes, tb.genres, nb_directors.primaryName;";
        
        
        
        $query = $this->connection->prepare($sql); 
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);;
    }   

    public function rechercheFilm($data)
    {
        $sql = "SELECT tb.tconst, tb.primaryTitle, tb.titletype, tb.startyear, tb.runtimeminutes, tb.genres, tr.averageRating, tr.numVotes
                FROM ".$this->table." tb
                LEFT JOIN title_ratings tr ON tb.tconst = tr.tconst
                WHERE 1=1 ";
    
    
        $condition = [];

        if(isset($data['titre']))
        {
            $condition[] = "tb.primaryTitle ILIKE :titre";
        }
        
        if(isset($data['types']))
        {
            $condition[] = "tb.titletype = :types";
        }

        if(isset($data['dateSortieMin']))
        {
            $condition[] = "tb.startyear >= :dateSortieMin";
        }

        if(isset($data['dateSortieMax']))
        {
            $condition[] = "tb.startyear <= :dateSortieMax";
        }

        if(isset($data['dureeMin']))
        {
            $condition[] = "tb.runtimeminutes >= :dureeMin";
        }

        if(isset($data['dureeMax']))
        {
            $condition[] = "tb.runtimeminutes <= :dureeMax";
        }

        if(isset($data['adulte']))
        {
            $condition[] = "tb.isAdult = :adulte";
        }

        if(isset($data['genres']))
        {
            $condition[] = "tb.genres ILIKE :genres";
        }

        if(isset($data['noteMin']))
        {
            $condition[] = "tr.averageRating>= :noteMin";
        }

        if(isset($data['noteMax']))
        {
            $condition[] = "tr.averageRating <= :noteMax";
        }
        
        if(isset($data['votesMin']))
        {
            $condition[] = "tr.numVotes >= :votesMin";
        }

        if(isset($data['votesMax']))
        {
            $condition[] = "tr.numVotes <= :votesMax";
        }

        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }
        else{
            return ['erreur' => 'aucun champs'];
        }

        $sql .= " ORDER BY tr.averageRating DESC, tr.numVotes DESC";

        $query = $this->connection->prepare($sql);
    

        foreach ($data as $key => $value) {
            // Assurez-vous de valider et échapper correctement les données pour éviter les problèmes de sécurité
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            $query->bindParam(':' . $key, $value, PDO::PARAM_STR);
        }
    
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);;
    }

    public function searchPerson($data) {
        $sql = "SELECT nb.nconst, nb.primaryName, nb.birthYear, nb.deathYear, nb.primaryProfession
                FROM name.basics nb
                WHERE 1=1 ";
    
        $conditions = [];
    
        if(isset($data['name'])) {
            $conditions[] = "nb.primaryName ILIKE :name";
        }
    
        if(isset($data['birthYearMin'])) {
            $conditions[] = "nb.birthYear >= :birthYearMin";
        }
    
        if(isset($data['birthYearMax'])) {
            $conditions[] = "nb.birthYear <= :birthYearMax";
        }
    
        if(isset($data['deathYearMin'])) {
            $conditions[] = "nb.deathYear >= :deathYearMin";
        }
    
        if(isset($data['deathYearMax'])) {
            $conditions[] = "nb.deathYear <= :deathYearMax";
        }
    
        // Ajoutez d'autres conditions 
    
        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }
        else {
            return ['erreur' => 'Aucun critère de recherche fourni.'];
        }
    
        $query = $this->connection->prepare($sql);
    
        foreach ($data as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            $query->bindParam(':' . $key, $value, PDO::PARAM_STR);
        }
    
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }



}