

<?php if (!empty($data)) : ?>
    <h2>Chemin le plus court :</h2>
    <ul>
        <?php foreach ($data['path'] as $item) : ?>
            <li><?php echo $item; ?></li>
        <?php endforeach; ?>
    </ul>
    <p>Longueur du chemin : <?php echo $data['length']; ?></p>
<?php else : ?>
    <p>Aucun résultat à afficher.</p>
<?php endif; ?>

<a href="?controller=home">Accueil</a>

