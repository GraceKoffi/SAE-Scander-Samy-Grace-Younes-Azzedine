<?php
echo "<pre>";
print_r($data);
echo "</pre>";

if (!empty($data)) {
    $film = $data[0];
    ?>
    <p>Title Type: <?php echo $film['titletype'] ?? 'non renseigné'; ?></p>
    <p>Primary Title: <?php echo $film['primarytitle'] ?? 'non renseigné'; ?></p>
    <p>Original Title: <?php echo $film['originaltitle'] ?? 'non renseigné'; ?></p>
    <p>Is Adult: <?php echo $film['isadult'] ?? 'non renseigné'; ?></p>
    <p>Start Year: <?php echo $film['startyear'] ?? 'non renseigné'; ?></p>
    <p>End Year: <?php echo $film['endyear'] ?? 'non renseigné'; ?></p>
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
