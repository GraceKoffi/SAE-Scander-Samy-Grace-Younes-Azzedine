<?php
class title_crew
{
    private $connection;
    private $table = "title_crew";
    public $tconst;
    public $directors = [];
    public $writers = [];

    public function __construct()
    {
        require "C:\wamp64\www\api\config\config.php";
        $db = config::getConnection();
        $this->connection = $db;
    }
}   