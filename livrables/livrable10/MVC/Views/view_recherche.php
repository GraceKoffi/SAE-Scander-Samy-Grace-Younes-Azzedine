<?php require "Views/view_begin_recherche.php"; ?>

<form action="?controller=recherche&action=afficher" method="post">
    <p>
        <label>
            Rechercher par :
            <select name="type">
                <option value="nom">Acteur</option>
                <option value="titre">Titre du film</option>
            </select>
        </label>
    </p>

    <p class="position-relative">
        <label>
            Terme de recherche :
            <input type="text" name="recherche" value="">
        </label>
    </p>

    <!-- Ajout de la boîte de suggestion -->
    <div id="suggestions" class="suggestion-box"></div>

    <br>
    <input type="submit" name="Search" value="Rechercher">
</form>
<a href="?controller=home">Accueil</a>
<a href="?controller=recherche&action=form_avancer">Recherche avancée</a>

<?php require "Views/view_end_recherche.php"; ?>