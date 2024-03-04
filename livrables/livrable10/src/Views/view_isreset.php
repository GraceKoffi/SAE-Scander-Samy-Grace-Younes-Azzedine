<?php
if(isset($tab)){
    echo $tab."</br>";
    echo "<a href=?controller=home>Revenir en lieu sur</a>";
}
else{
    
    echo "c'est reset ;)</br>";
    echo "<a href=?controller=home>Revenir en lieu sur</a>";
    
}