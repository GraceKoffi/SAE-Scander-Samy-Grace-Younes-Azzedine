<?php
class title_principals
{
    private $connection;
    private $table = "title_principals";
    public $tconst;
    public $ordering;
    public $nconst;
    public $category;
    public $job;
    public $characters;

    public function _construc()
    {
        require "C:\wamp64\www\api\config\config.php";
        $db = config::getConnection();
        $this->connection = $db;
    }


    public function FilmEnCommun($data)
    {
        if(!isset($data['PrimaryName1']) && !isset($data['PrimaryName2']))
        {
            return ['message' => 'Aucun champ chaisie'];
        }

        $sql = "SELECT DISTINCT 
                    m.primaryTitle
                FROM 
                ".$this->table." p1
                JOIN title.principals p2 
                    ON 
                        p1.tconst = p2.tconst
                JOIN title.basics m 
                    ON 
                        p1.tconst = m.tconst
                JOIN name.basics a1 
                    ON 
                        p1.nconst = a1.nconst
                JOIN name.basics a2 
                    ON 
                        p2.nconst = a2.nconst
                WHERE 
                    a1.primaryName = :actor1
                    AND 
                        a2.primaryName = :actor2
                    AND 
                        p1.category = 'actor'
                    AND 
                        p2.category = 'actor'";
        $query = $this->connection->prepare($sql);
        $acteur1 = htmlspecialchars($data['PrimaryName1'], ENT_QUOTES, 'UTF-8');
        $acteur2 = htmlspecialchars($data['PrimaryName2'], ENT_QUOTES, 'UTF-8');
        $query->bindParam(':actor1', $acteur1, PDO::PARAM_STR);
        $query->bindParam(':actor2', $acteur2, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);;
    }


    public function ActeurEnCommun($data)
    {
        if(!isset($data['primaryTitle1']) && !isset($data['primaryTitle2']))
        {
            return ['message' => 'Aucun champ chaisie'];
        }

        $sql = "SELECT DISTINCT 
            a.primaryName
        FROM 
            ".$this->table." p1
        JOIN 
            title.principals p2 
                ON 
                    p1.nconst = p2.nconst
        JOIN 
            title.basics m1 
                ON 
                    p1.tconst = m1.tconst
        JOIN 
            title.basics m2 
                ON 
                    p2.tconst = m2.tconst
        JOIN 
            name.basics a 
                ON 
                    p1.nconst = a.nconst
        
        WHERE 
            m1.primaryTitle = :movie1
            AND 
            m2.primaryTitle = :movie2
            AND 
            p1.category = 'actor'
            AND 
            p2.category = 'actor'";
        $query = $this->connection->prepare($sql);
        $Film1 = htmlspecialchars($data['primaryTitle1'], ENT_QUOTES, 'UTF-8');
        $Film2 = htmlspecialchars($data['primaryTitle2'], ENT_QUOTES, 'UTF-8');
        $query->bindParam(':movie1', $Film1, PDO::PARAM_STR);
        $query->bindParam(':movie2', $Film2, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);;
}

}