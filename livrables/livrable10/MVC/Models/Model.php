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


    public function form_recherche_film($film){
        $request = $this->bd->prepare("
            SELECT *
            FROM title_basics   
            WHERE primaryTitle = :film  
        ");
        

        $request->bindValue(':film', e($film));

        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


    public function form_recherche_film_id($id){
        $request = $this->bd->prepare("
            SELECT *
            FROM title_basics   
            WHERE tconst = :id  
        ");
        

        $request->bindValue(':id', e($id));

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

    public function get_nconst($name){
        $request = $this->bd->prepare("
            SELECT nconst
            FROM name_basics
            WHERE primaryName = :acteur;
        
        ");

        $request->bindValue(':acteur', e($name));

        $request->execute();

        $result = $request->fetch(PDO::FETCH_ASSOC);
        if ($result !== false) {
            return $result;
        } else {
            // Gérer le cas où aucun résultat n'est trouvé
            return null;
        }

    }

    public function recherche_film($acteur_1, $acteur_2){
        $request = $this->bd->prepare("
            SELECT DISTINCT tb.tconst, tb.primaryTitle, tb.startYear
            FROM title_basics tb
            JOIN title_principals tp1 ON tb.tconst = tp1.tconst
            JOIN title_principals tp2 ON tb.tconst = tp2.tconst
            WHERE tp1.nconst = :nconst1 AND tp2.nconst = :nconst2;
        ");

        $nconst_1 = $this->get_nconst($acteur_1);
        $nconst_2 = $this->get_nconst($acteur_2);

        $request->bindValue(':nconst1', $nconst_1['nconst']);
        $request->bindValue(':nconst2', $nconst_2['nconst']);

        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    
    
    }
    
    public function get_tconst($film) {
        $request = $this->bd->prepare("
            SELECT tconst
            FROM title_basics
            WHERE primaryTitle = :film;
        ");
    
        $request->bindValue(':film', e($film));
        $request->execute();
    
        // Vérifier si la requête a renvoyé un résultat valide
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if ($result !== false) {
            return $result;
        } else {
            // Gérer le cas où aucun résultat n'est trouvé
            return null;
        }
    }



    public function rechercher_acteur($film_1, $film_2){
        $request = $this->bd->prepare("
        SELECT nb.primaryName AS acteur_en_commun, tp1.tconst AS film1, tp2.tconst AS film2
        FROM title_principals tp1
        JOIN title_principals tp2 ON tp1.nconst = tp2.nconst
        JOIN name_basics nb ON tp1.nconst = nb.nconst
        WHERE tp1.tconst = :tconst1 AND tp2.tconst = :tconst2;
        
        ");

        $tconst_1 = $this->get_tconst($film_1);
        $tconst_2 = $this->get_tconst($film_2);

        $request->bindValue(':tconst1', $tconst_1['tconst']);
        $request->bindValue('::tconst2', $tconst_2['tconst']);

        return $request->fetchAll(PDO::FETCH_ASSOC);


    }


    private function getRelations($node, $type) {
        $relations = [];
        $table = '';
    
        // Choix de la table en fonction du type (acteur ou film)
        if ($type == 'acteur') {
            $table = 'name_basics';
        } elseif ($type == 'film') {
            $table = 'title_basics';
        }
    
        // Requête pour obtenir les relations du nœud
        $stmt = $this->bd->prepare("
            SELECT tp.tconst AS source, nb.nconst AS target
            FROM title_principals AS tp
            JOIN name_basics AS nb ON tp.nconst = nb.nconst
            WHERE $table.nconst = :node
        ");
        $stmt->bindValue(':node', $node);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($results as $result) {
            $relations[] = ['source' => $result['source'], 'target' => $result['target']];
        }
    
        return $relations;
    }
    
    private function buildPath($start, $end, $previous) {
        $path = [];
        $current = $end;
    
        while ($current != $start) {
            array_unshift($path, $current);
            $current = $previous[$current];
        }
    
        array_unshift($path, $start);
    
        return ['path' => $path, 'length' => count($path)];
    }
    
    public function findShortestPath($start, $end, $type) {
        // Initialisation de la file pour la recherche BFS
        $queue = new SplQueue();
        $visited = [];
        $previous = [];
    
        // Ajouter le point de départ à la file
        $queue->enqueue($start);
        $visited[$start] = true;
    
        while (!$queue->isEmpty()) {
            $current = $queue->dequeue();
    
            // Requête pour obtenir les relations du nœud actuel
            $relations = $this->getRelations($current, $type);
    
            foreach ($relations as $relation) {
                $neighbor = $relation['target'];
    
                if (!isset($visited[$neighbor])) {
                    $visited[$neighbor] = true;
                    $previous[$neighbor] = $current;
    
                    // Si on atteint la cible, construire le chemin et retourner le résultat
                    if ($neighbor == $end) {
                        return $this->buildPath($start, $end, $previous);
                    }
    
                    $queue->enqueue($neighbor);
                }
            }
        }
    
        // Aucun chemin trouvé
        return null;
    }
    
    

}