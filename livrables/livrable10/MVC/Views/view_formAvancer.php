<form action="?controller=recherche&action=afficher_form_avancer" method="post">
    
    <p>
        <label for="name">Nom:</label>
            <input type="text" name="nom" id="name">
    </p>
    
    <p>
        <label for="titre">Titre du film:</label>
            <input type="text" name="titre" id="titre">
    </p>
    
    <p>
        <label for="startBirthYear">Année de naissance (début):</label>
            <input type="text" name="startBirthYear" id="startBirthYear">
    </p>
    
    <p>
        <label for="endBirthYear">Année de naissance (fin):</label>
            <input type="text" name="endBirthYear" id="endBirthYear">
    </p>
    
    <p>
        <label for="startFilmYear">Année de création du film (début):</label>
            <input type="text" name="startFilmYear" id="startFilmYear">
    </p>
    
    <p>
        <label for="endFilmYear">Année de création du film (fin):</label>
            <input type="text" name="endFilmYear" id="endFilmYear">
    </p>
    
    
    <p>
    <label for="order">Trier par:</label>
        <select name="order" id="order">
            <option value="name">Nom</option>
            <option value="titre">Titre du film</option>
            <option value="birthYear">Année de naissance</option>
            <option value="startYear">Année de création du film</option>
        </select>
    </p>
    
    <p>
        <input type="submit" value="Rechercher">
    </p>

</form>