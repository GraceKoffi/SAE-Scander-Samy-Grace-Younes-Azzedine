<?php
class title_episode
{
    private $connection;
    private $table = "title_episode";
    public $tconst;
    public $parentTconst;
    public $seasonNumber;
    public $episodeNumber;

    public function __construct()
    {
        require "C:\wamp64\www\api\config\config.php";
        $db = config::getConnection();
        $this->connection = $db;
    }
}