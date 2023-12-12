
<?php if(sizeof($data) == 1) : ?>
    <?php
    if (!empty($data) && isset($data[0])) {
    $actorInfo = $data[0];

    // Affichage du paragraphe
    echo '<p>';
    echo 'Nom de l\'acteur : ' . $actorInfo['primaryname'] . '<br>';
    $jobs_whithout_braces = str_replace(array('{', '}'), '', $actorInfo['primaryprofession']);
    $jobs = explode(',', $jobs_whithout_braces);
    echo 'Job : ';
    foreach($jobs as $job){
        echo $job.' ';
    }
    echo '<br>';
    echo 'Films connus : ';
    
    // Extraire les IDs de films connus
    $knownfortitlesWithoutBraces = str_replace(array('{', '}'), '', $actorInfo['knownfortitles']);

    // Diviser les valeurs en un tableau
    $knownTitlesArray = explode(',', $knownfortitlesWithoutBraces);
    
    foreach ($knownTitlesArray as $titleId) {
        echo '<a href="?controller=recherche&action=afficher_film&id=' . $titleId . '">' . $titleId . '</a>&nbsp;';
    }

    echo '</p>';
    } else {
        echo 'Aucune information disponible.';
    }
    ?>
<?php else : ?> 
    
        <p>Name</p>
        <ol>
        <?php foreach ($data as $cle) : ?>
            <li><a href="?controller=recherche&action=afficher_acteur&nom=<?php echo $cle['primaryname']; ?>"><?php echo $cle['primaryname']; ?></a></li>
    <?php endforeach; ?>
    </ol>
<?php endif; ?>

<a href="?controller=home">home</a>
<a href="?controller=recherche&action=fom_rechercher">Form</a>

