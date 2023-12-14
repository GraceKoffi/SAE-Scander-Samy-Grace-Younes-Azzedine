<?php require "Views/view_begin_trouver.php"; ?>

<form action="?controller=trouver&action=afficher" method="post">
    <p>
        <label>
            Rechercher par :
            <select name="type">
                <option value="acteur">Acteur</option>
                <option value="film">Titre du film</option>
            </select>
        </label>
    </p>

    <p class="position-relative">
        <label>
            Terme de recherche 1 :
            <input type="text" name="recherche1" value="">
        </label>
    </p>

    <!-- Ajout de la boîte de suggestion pour le premier terme de recherche -->
    <div id="suggestions1" class="suggestion-box"></div>

    <p class="position-relative">
        <label>
            Terme de recherche 2 :
            <input type="text" name="recherche2" value="">
        </label>
    </p>

    <!-- Ajout de la boîte de suggestion pour le deuxième terme de recherche -->
    <div id="suggestions2" class="suggestion-box"></div>

    <br>
    <input type="submit" name="Search" value="Rechercher">
</form>
<a href="?controller=home">Accueil</a>
<?php require "Views/view_end_trouver.php"; ?>