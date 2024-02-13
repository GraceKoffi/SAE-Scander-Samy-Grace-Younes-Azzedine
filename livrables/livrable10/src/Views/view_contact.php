<?php require "Views/view_navbar.php"; ?>
    <h2>Contactez-nous</h2>

    <form action="?controller=contact&action=send" method="post">
        <?php
            if(isset($tab)){
                $email = $tab[0];
                $name = $tab[1];
            }
        ?>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $name[0] ?? ''; ?>" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo $email[0] ?? ''; ?>" required>

        <label for="message">Message :</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <button type="submit">Envoyer</button>
    </form>
</body>
</html>




<?php require "Views/view_footer.php"; ?>