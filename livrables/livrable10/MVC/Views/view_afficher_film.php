<?php
if (!empty($data)) {
    $film = $data[0];
    ?>
    <p>Title Type: <?php echo $film['titletype'] ?? 'non renseigné'; ?></p>
    <p>Primary Title: <?php echo $film['primarytitle'] ?? 'non renseigné'; ?></p>
    <p>Original Title: <?php echo $film['originaltitle'] ?? 'non renseigné'; ?></p>
    <p>Is Adult: <?php if($film['isadult'] !== null) :?>
                    <?php if($film['isadult'] == '0') :?>
                            <?php echo 'Non';?>
                    <?php elseif($film['isadult'] == '1') : ?>
                            <?php echo 'Oui'; ?>
                    <?php else :?>
                            <?php echo 'Inconnu'; ?>
                    <?php endif; ?>
                <?php else :?>
                    <?php echo 'non renseigné';?>
                <?php endif; ?>
    </p>
    <p>Start Year: <?php echo $film['startyear'] ?? 'non renseigné'; ?></p>
    <p>End Year: <?php echo $film['endyear'] ?? 'non renseigné'; ?></p>
    <p>Runtime minutes: <?php echo $film['runtimeminutes'] ?? 'non renseigné'; ?></p>
    <?php 
      $genre_whithout_braces = str_replace(array('{', '}'), '', $film['genres']);
      $genre = explode(',', $genre_whithout_braces);
    ?>
    <p>Genres: 
        <?php foreach($genre as $g) :?>
            <?php if($g == '') :?>
                <?php echo "non renseigné"; ?>
            <?php else :?>
                <?php echo $g; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </p>
    <?php
} else {
    echo "Aucune donnée à afficher.";
}
?>
<a href="?controller=home">Accueil</a>
<a href="?controller=recherche&action=form_avancer">Recherche avancée</a>
