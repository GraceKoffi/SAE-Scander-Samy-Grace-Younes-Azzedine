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

    public function get_NameSuggestions($recherche) {
        $query = "SELECT primaryName FROM name_basics WHERE primaryName LIKE :recherche LIMIT 5";
        return $this->getSuggestions($query, $recherche);
    }

    public function get_TitleSuggestions($recherche) {
        $query = "SELECT primaryTitle FROM title_basics WHERE primaryTitle LIKE :recherche LIMIT 5";
        return $this->getSuggestions($query, $recherche);
    }

    private function getSuggestions($query, $recherche) {
        $stmt = $this->bd->prepare($query);
        $stmt->bindValue(':recherche', "%$recherche%", PDO::PARAM_STR);
        $stmt->execute();

        $suggestions = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $suggestions;
    }
    
    public function form_recherche_acteur($acteur){

        $request = $this->bd->prepare("
        SELECT *
        FROM name_basics 
        WHERE primaryName = :nom
    
        ");
       
        $request->bindValue(':nom', e($acteur));
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


    public function form_recherche_film($id){
        $request = $this->bd->prepare("
            SELECT *
            FROM title_basics   
            WHERE tconst = :id
        ");
        
        $request->bindValue(':id', e($id));

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
    


    public function get_info_acteur($acteur_like){
        $request = $this->bd->prepare("
            SELECT primaryName FROM name_basics WHERE primaryName LIKE :acteur
        ");

        $acteur = '%'.$acteur_like.'%';

        $request->bindValue(':acteur', e($acteur));

        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);

    }

    public function get_info_film($film_like){
        $request = $this->bd->prepare("
            SELECT primaryTitle FROM title_basics WHERE primaryTitle LIKE :film
        ");        
        
        $film = '%'.$film_like.'%';
        
        $request->bindValue(':film', $film);
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    
    }
    





}