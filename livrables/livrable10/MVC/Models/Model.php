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

    public function from_recherche($name, $title){
    
            $request = $this->bd->prepare("
                SELECT 
                nb.primaryName AS PersonName,
                nb.birthYear AS BirthYear,
                nb.deathYear AS DeathYear,
                tb.primaryTitle AS FilmTitle,
                tb.startYear AS FilmStartYear,
                tb.endYear AS FilmEndYear
                
                FROM 
                name_basics nb
                LEFT JOIN 
                title_principals tp ON nb.nconst = tp.nconst
                LEFT JOIN 
                title_basics tb ON tp.tconst = tb.tconst
                
                WHERE 
                nb.primaryName ILIKE :name OR tb.primaryTitle ILIKE :titre
                
                ORDER BY 
                nb.primaryName ASC, tb.primaryTitle ASC"
            );

            $request->bindValue(':name', '%'.$name.'%');
            $request->bindValue(':titre', '%'.$title.'%');

            $request->execute();

            return $request->fetchAll(PDO::FETCH_ASSOC);
    

    }


    public function form_recherche_avancer($name, $titre, $startBirthYear, $endBirthYear, $startFilmYear, $endFilmYear, $order) {

        $request = $this->bd->prepare("
            SELECT 
            nb.primaryName AS PersonName,
            nb.birthYear AS BirthYear,
            nb.deathYear AS DeathYear,
            tb.primaryTitle AS FilmTitle,
            tb.startYear AS FilmStartYear,
            tb.endYear AS FilmEndYear
    
            FROM 
            name_basics nb
            LEFT JOIN 
            title_principals tp ON nb.nconst = tp.nconst
            LEFT JOIN 
            title_basics tb ON tp.tconst = tb.tconst
    
            WHERE 
            (nb.primaryName ILIKE :name OR nb.primaryName ILIKE :name)
            AND (tb.primaryTitle ILIKE :titre)
            AND (nb.birthYear BETWEEN :startBirthYear::integer AND :endBirthYear::integer OR :startBirthYear IS NULL)
            AND (tb.startYear BETWEEN :startFilmYear::integer AND :endFilmYear::integer OR :startFilmYear IS NULL)
    
            ORDER BY 
            CASE
                WHEN :order = 'name' THEN nb.primaryName
                WHEN :order = 'titre' THEN tb.primaryTitle
                WHEN :order = 'birthYear' THEN nb.birthYear::text
                WHEN :order = 'startYear' THEN tb.startYear::text
                ELSE nb.primaryName
            END ASC;
        ");
    
        $request->bindValue(':name', '%' . $name . '%');
        $request->bindValue(':titre', '%' . $titre . '%');
        $request->bindValue(':startBirthYear', $startBirthYear !== '' ? $startBirthYear : null, PDO::PARAM_INT);
        $request->bindValue(':endBirthYear', $endBirthYear !== '' ? $endBirthYear : null, PDO::PARAM_INT);
        $request->bindValue(':startFilmYear', $startFilmYear !== '' ? $startFilmYear : null, PDO::PARAM_INT);
        $request->bindValue(':endFilmYear', $endFilmYear !== '' ? $endFilmYear : null, PDO::PARAM_INT);
        $request->bindValue(':order', $order);
    
        $request->execute();
    
        return $request->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function get_info($acteur){
        $request = $this->bd->prepare("
        SELECT *
        FROM name_basics AS nb
        LEFT JOIN title_principals AS tp ON nb.nconst = tp.nconst
        LEFT JOIN title_basics AS tb ON tp.tconst = tb.tconst
        LEFT JOIN title_ratings AS tr ON tb.tconst = tr.tconst
        WHERE nb.primaryname   = :acteur;
        ");

        $request->bindValue(':acteur', $acteur);

        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);


    }


    





}