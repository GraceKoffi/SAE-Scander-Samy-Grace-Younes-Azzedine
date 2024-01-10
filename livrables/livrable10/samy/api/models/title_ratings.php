<?php
class title_ratings
{
    private $connection;
    private $table = "title_ratings";
    public $averageRating;
    public $numVotes;

    public function __construct()
    {
        require "C:\wamp64\www\api\config\config.php";
        $db = config::getConnection();
        $this->connection = $db;
    }
}