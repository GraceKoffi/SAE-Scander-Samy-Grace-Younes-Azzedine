<?php
class config
{
    private static $db;

    private function __construct()
    {
        include "C:\wamp64\www\api\credentials.php";

        try 
        {
            self::$db = new PDO($db, $user, $pwd);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->query("SET NAMES 'utf8'");
        }
        catch(PDOException $exception)
        {
            echo "<pre>Erreur de connexion : ".$exception->getMessage();
        }
    }

    public static function getConnection()
    {
        if (self::$db === null) 
        {
            new self();
        }
        return self::$db;
    }
}
