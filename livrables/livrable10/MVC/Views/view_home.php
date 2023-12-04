<ul>
    <?php for($i=0; $i<3; $i++) : ?>
    <a href="?controller=<?php echo $tab['controller'][$i]; ?>&action=<?php echo $tab['action'][$i]; ?>"><?php echo $tab['value'][$i]; ?></a>
    <?php endfor; ?>
</ul>
