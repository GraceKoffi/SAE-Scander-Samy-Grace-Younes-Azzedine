<form action="?controller=recherche&action=afficher" method="post">
   
        <p>
            <label>
                nom: 
                <input type="text" name="nom" value="">
            </label>
        </p>
        
        <p>
            <label>
                titre: 
                <input type="text" name="titre" value="">
            </label>
        </p>

        <br><input type="submit" name ="Search" value="Search">

</form>
<a href="?controller=home">home</a>
<a href="?controller=recherche&action=form_avancer">form avancer</a>