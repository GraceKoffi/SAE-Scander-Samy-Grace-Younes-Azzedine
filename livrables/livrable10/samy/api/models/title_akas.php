<?php
class title_akas
{
    private $connection;
    private $table = "title_akas";
    public $titleId;
    public $ordering;
    public $title;
    public $region;
    public $language;
    public $types = [];
    public $attributes = [];
    public $isOriginalTitle;

    public function __construct()
    {
        require "C:\wamp64\www\api\config\config.php";
        $db = config::getConnection();
        $this->connection = $db;
        
    }
}