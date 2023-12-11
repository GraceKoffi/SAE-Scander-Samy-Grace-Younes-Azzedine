
<?php if(sizeof($data) == 1) : ?>
    <table border="1">
    <?php for ($i = 0; $i < sizeof($data); $i++) : ?>
        <tr>
        <?php foreach ($data[$i] as $cle => $val) : ?>
            <th><?php echo $cle; ?></th>
            <td>
            <?php if ($val == "") : ?>
                <?php echo "Null"; ?>
            <?php else : ?>
                <?php echo $val; ?>
            <?php endif; ?>
            </td>
        <?php endforeach; ?>
        </tr>
    <?php endfor; ?>
    </table>

<?php else : ?> 
    <?php echo print_r($data); ?>
    <table border="1">
        <th>Name</th>
        <?php foreach ($data as $cle) : ?>
            <td><a href="?controller=recherche&action=afficher_acteur&nom=<?php echo $cle['personname']; ?>"><?php echo $cle['personname']; ?></a></td>
            
    <?php endforeach; ?>
    </table>
<?php endif; ?>

<a href="?controller=home">home</a>
<a href="?controller=recherche&action=fom_rechercher">Form</a>

