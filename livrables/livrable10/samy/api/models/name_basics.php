<?php
class name_basics
{
    private $connection;
    private $table = "name_basics";
    public $nconst;
    public $primaryName;
    public $birthYear;
    public $deathYear;
    public $primaryProfession;
    public $knowForTitles;
    
    public function __construct()
    {
        require "C:\wamp64\www\api\config\config.php";
        $db = config::getConnection();
        $this->connection = $db;
    }

    public function test()
    {
        $sql = "SELECT * FROM ".$this->table." LIMIT 1;";
        $query = $this->connection->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function recherchepersonne($data)
    {
        if(!isset($data['acteur'])){
            return ['erreur' => 'champs acteur manquant'];
        }
        $sql = "SELECT  nconst, 
            primaryname, 
            birthyear, 
            deathyear, 
            primaryprofession, 
            knownfortitles
        FROM 
            ".$this->table."
        WHERE LOWER(primaryname) 
            LIKE LOWER(:acteur) ;";

        $acteur = htmlspecialchars($data['acteur'], ENT_QUOTES, 'UTF-8');
        $query = $this->connection->prepare($sql);
        $query->bindParam(':acteur', $acteur, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);

    }
}