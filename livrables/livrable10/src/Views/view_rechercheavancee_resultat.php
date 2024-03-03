<?php require "Views/view_navbar.php"; ?>
<style>

.bouton-favori{
    border-radius: 10px 5%;
    background-color: yellow;
    padding: 5px 10px;
 }
</style>
<div class="row" style="margin-top: 120px;">
    <div class="col-md-8 m-5">
        <?php if (isset($titre)): ?>
        <h1>Résultats "<?= e($titre) ?>"</h1>
        <?php endif; ?>
        <p>
          <a href="?controller=recherche">
          <button id='favoriButton' class='bouton-favori'> &#8592; Realiser une nouvelle recherche</button>
          </a>
          </p>
    </div>
</div>

<div class="row">
    <div class="col-md-2 m-5">
        <div id="movies-par-page-container">
            <label for="movies-par-page" style ="border-left:2px solid #FFCC00; padding-left: 6px;">Afficher par :</label>
            <select id="movies-par-page" onchange="changeMoviesPerPage()" class="form-control">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>
    <div class="col-md-6"></div>

    <div class="col-md-2 m-5">
        <label for="sort" style ="border-left:2px solid #FFCC00; padding-left: 6px;">Trier par :</label>
        <select id="sort" onchange="sortMovies()" class="form-control">
        <option value="">Sélectionner ...</option>
        <?php if ($typereponse=='titre') : ?>
        <option value="title-asc">Titre - Ascendant</option>
        <option value="title-desc">Titre - Descendant</option>
        <option value="date-asc">Date - Ascendant</option>
        <option value="date-desc">Date - Descendant</option>
        <option value="genres-asc">Genres - Ascendant</option>
        <option value="genres-desc">Genres - Descendant</option>
        <option value="rating-asc">Note - Ascendant</option>
        <option value="rating-desc">Note - Descendant</option>
        <?php else : ?>
        <option value="name-asc">Nom - Ascendant</option>
        <option value="name-desc">Nom - Descendant</option>
        <option value="birth-asc">Date de naissance - Ascendant</option>
        <option value="birth-desc">Date de naissance - Descendant</option>
        <option value="death-asc">Date de décès - Ascendant</option>
        <option value="death-desc">Date de décès - Descendant</option>
        <option value="profession-asc">Métier - Ascendant</option>
        <option value="profession-desc">Métier - Descendant</option>
        <?php endif ; ?>

        </select>

    </div>

</div>





  
                
        
            <div class = "col-md-9 mx-auto" id="movie-list"></div>
            
            <div class ="m-5" style ="border-left:2px solid #FFCC00; padding-left: 6px;" id="count"></div>
            <div id="pagination-container" style="display: flex; justify-content: center;">
            <button onclick="prevPage()"><</button>
            <div id="paginationrecherche"></div>
            <button onclick="nextPage()">></button>
            </div>
                
        
               
 <script src="Js/function.js"></script>
<script>
    let type = "<?php echo $typereponse; ?>"; // La valeur de type est passée depuis PHP.
    let movies = [];
    movies = <?php echo json_encode($recherche); ?>;
    let currentPage = 1;
    let moviesPerPage = 10

;

async function displayMovies() {
    const list = document.getElementById("movie-list");
    list.innerHTML = ""; // Efface la liste actuelle
    let endIndex = currentPage * moviesPerPage;
    let startIndex = endIndex - moviesPerPage;
    let paginatedMovies = movies.slice(startIndex, endIndex);
    for (const item of paginatedMovies) {
        let posterPath = type === "titre" ? await getFilmPhoto(item.tconst) : await getPersonnePhoto(item.nconst);
        let hrefValue = type === "titre" ? `?controller=home&action=information_movie&id=${item.tconst}` : `?controller=home&action=information_acteur&id=${item.nconst}`;
        let cardContent = `<a href="${hrefValue}" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
            <div class="cardrecherche" style="cursor: pointer;">
                <img src="${posterPath}" alt="${type === "titre" ? item.tconst : item.nconst}">
                <div class="card-bodyrecherche">`;

        if (type === "titre") {
            cardContent += `
                <h2 class="card-1recherche">${displayValue(item.primarytitle, 'Aucune information')}</h2>
                <p class="card-2recherche">Type : ${displayValue(item.titletype, 'Aucune information')}</p>
                <p class="card-3recherche">Date : ${displayValue(item.startyear, 'Aucune information')}</p>
                <p class="card-4recherche">Genres : ${displayValue(item.genres, 'Aucune information')}</p>
                <p class="card-5recherche">Note : ${formatRating(item.averagerating)}</p>`;
        } else { // cas où type == "personne"
            cardContent += `
                <h2 class="card-1recherche">${displayValue(item.primaryname, 'Aucune information')}</h2>
                <p class="card-2recherche">Date de naissance : ${displayValue(item.birthyear, 'Aucune information')}</p>
                <p class="card-3recherche">Date de décès: ${displayValue(item.deathyear, 'Aucune information')}</p>
                <p class="card-4recherche">Métier : ${displayValue(item.primaryprofession, 'Aucune information')}</p>`;
        }

        cardContent += `
                </div>
            </div>
        </a>`;

        list.innerHTML += cardContent;
    }

    document.getElementById("count").innerText = `Résultat : ${movies.length}`;
    window.scrollTo({ top: 0 });
    renderPagination();
}





function sortMovies() {
  let sortOrder = document.getElementById("sort").value;
  movies.sort((a, b) => {
    let valueA, valueB;

    // Helper function to handle 'Aucune information'
    const getSortableValue = (value, isNumber) => {
      if (value == null || value === '') {
        return isNumber ? -Infinity : 'ZZZZZZZZ'; // Treat missing numbers as very low, strings as very high
      }
      return isNumber ? parseFloat(value) : value.toUpperCase();
    };

    switch (sortOrder) {
      case 'title-asc':
        valueA = getSortableValue(a.primarytitle, false);
        valueB = getSortableValue(b.primarytitle, false);
        return valueA.localeCompare(valueB);
      case 'title-desc':
        valueA = getSortableValue(a.primarytitle, false);
        valueB = getSortableValue(b.primarytitle, false);
        return valueB.localeCompare(valueA);
      case 'date-asc':
        valueA = getSortableValue(a.startyear, true);
        valueB = getSortableValue(b.startyear, true);
        return valueA - valueB;
      case 'date-desc':
        valueA = getSortableValue(a.startyear, true);
        valueB = getSortableValue(b.startyear, true);
        return valueB - valueA;
      case 'type-asc':
        valueA = getSortableValue(a.titletype, false);
        valueB = getSortableValue(b.titletype, false);
        return valueA.localeCompare(valueB);
      case 'type-desc':
        valueA = getSortableValue(a.titletype, false);
        valueB = getSortableValue(b.titletype, false);
        return valueB.localeCompare(valueA);
      case 'genres-asc':
        valueA = getSortableValue(a.genres, false);
        valueB = getSortableValue(b.genres, false);
        return valueA.localeCompare(valueB);
      case 'genres-desc':
        valueA = getSortableValue(a.genres, false);
        valueB = getSortableValue(b.genres, false);
        return valueB.localeCompare(valueA);
      case 'rating-asc':
        valueA = getSortableValue(a.averagerating, true);
        valueB = getSortableValue(b.averagerating, true);
        return valueA - valueB;
      case 'rating-desc':
        valueA = getSortableValue(a.averagerating, true);
        valueB = getSortableValue(b.averagerating, true);
        return valueB - valueA;
      case 'name-asc':
        valueA = getSortableValue(a.primaryname, false);
        valueB = getSortableValue(b.primaryname, false);
        return valueA.localeCompare(valueB);
      case 'name-desc':
        valueA = getSortableValue(a.primaryname, false);
        valueB = getSortableValue(b.primaryname, false);
        return valueB.localeCompare(valueA);
      case 'birth-asc':
        valueA = getSortableValue(a.birthyear, true);
        valueB = getSortableValue(b.birthyear, true);
        return valueA - valueB;
      case 'birth-desc':
        valueA = getSortableValue(a.birthyear, true);
        valueB = getSortableValue(b.birthyear, true);
        return valueB - valueA;
      case 'death-asc':
        valueA = getSortableValue(a.deathyear, true);
        valueB = getSortableValue(b.deathyear, true);
        return valueA - valueB;
      case 'death-desc':
        valueA = getSortableValue(a.deathyear, true);
        valueB = getSortableValue(b.deathyear, true);
        return valueB - valueA;
      case 'profession-asc':
        valueA = getSortableValue(a.primaryprofession, false);
        valueB = getSortableValue(b.primaryprofession, false);
        return valueA.localeCompare(valueB);
      case 'profession-desc':
        valueA = getSortableValue(a.primaryprofession, false);
        valueB = getSortableValue(b.primaryprofession, false);
        return valueB.localeCompare(valueA);
      default:
      return 0;
    }
  });
  currentPage = 1; // Reset to the first page
  displayMovies();
}

   // Vérifie si le tableau movies est vide ou null et appelle displayNoResultsMessage si c'est le cas
   if (!movies || movies.length === 0) {
  displayNoResultsMessage();
} else {
  // Continue avec l'affichage des résultats si des données sont présentes
  displayMovies();
}
</script>

<?php require "Views/view_footer.php"; ?>