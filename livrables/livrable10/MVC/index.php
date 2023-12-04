<?php
require "credentials.php";
try {

     $db = new PDO($DSN, $USER, $PWD);
     echo "ok";


}
catch(PDOException $e){

   echo $e->getMessage();

}
