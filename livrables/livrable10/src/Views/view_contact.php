<?php require "Views/view_navbar.php"; ?>


    <h2>Contactez-nous</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $_POST["nom"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        $to = "scander.ali@gmail.com";
        $sujet = "Nouveau message de $nom";
        $headers = "De: $email";

        mail($to, $sujet, $message, $headers);

        echo "<p style='color: green;'>Votre message a été envoyé avec succès. Nous vous répondrons bientôt!</p>";
    }
    ?>

    <form action="" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message :</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <button type="submit">Envoyer</button>
    </form>
</body>
</html>




<?php require "Views/view_footer.php"; ?>