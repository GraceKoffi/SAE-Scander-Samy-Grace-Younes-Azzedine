<form action="?controller=rapprochement&action=afficher_raprochement" method="post">
    <p>
        <label>
            Type :
            <select name="type">
                <option value="acteur">Acteur</option>
                <option value="film">Film</option>
            </select>
        </label>
    </p>
    <p>
        <label>
            Point de départ :
            <input type="text" name="start" value="" placeholder="Nom de l'acteur ou titre du film">
        </label>
    </p>
    <p>
        <label>
            Point d'arrivée :
            <input type="text" name="end" value="" placeholder="Nom de l'acteur ou titre du film">
        </label>
    </p>
    <br>
    <input type="submit" name="Search" value="Rechercher">
</form>
<a href="?controller=home">Accueil</a>