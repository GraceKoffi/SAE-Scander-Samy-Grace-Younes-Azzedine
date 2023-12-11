<?php for($i=0; $i<sizeof($data); $i++) : ?>
    <?php foreach($data[$i] as $cle => $val) : ?>
        <ul>
            <p><?php echo $cle; ?></p>
            <li>
                <?php if($val == "") :?>
                    <?php echo "Null";?>
                <?php else :?>
                    <?php echo $val; ?>
                <?php endif;?>
            </li>
        </ul>

    <?php endforeach; ?>
<?php endfor; ?>


<a href="?controller=home">home</a>
<a href="?controller=recherche&action=fom_rechercher">Form</a>

