<?php require "Views/view_navbar.php"; ?>
<style>

</style>
<div class="row" style="margin-top: 120px;">
    <div class="col-md-8 m-5">
        <?php if (isset($personne1) && isset($personne2)): ?>
        <h1>Résultats entre "<?= e($personne1) ?>" et "<?= e($personne2) ?>"</h1>
        <?php endif; ?>
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
        <option value="title-asc">Titre - Ascendant</option>
        <option value="title-desc">Titre - Descendant</option>
        <option value="date-asc">Date - Ascendant</option>
        <option value="date-desc">Date - Descendant</option>
        <option value="genres-asc">Genres - Ascendant</option>
        <option value="genres-desc">Genres - Descendant</option>
    

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
    let movies = [];
    movies = <?php echo json_encode($result); ?>;
    let currentPage = 1;
    let moviesPerPage = 10;

;

async function displayMovies() {
    const list = document.getElementById("movie-list");
    list.innerHTML = ""; // Efface la liste actuelle
    let endIndex = currentPage * moviesPerPage;
    let startIndex = endIndex - moviesPerPage;
    let paginatedMovies = movies.slice(startIndex, endIndex);
    for (const item of paginatedMovies) {
        let posterPath = await getFilmPhoto(item.tconst);
        let hrefValue = `?controller=home&action=information_movie&id=${item.tconst}`;
        let cardContent = `<a href="${hrefValue}" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
            <div class="cardrecherche" style="cursor: pointer;">
                <img src="${posterPath}" alt="${item.tconst}">
                <div class="card-bodyrecherche">`;

        
            cardContent += `
                <h2 class="card-1recherche">${displayValue(item.primarytitle, 'Aucune information')}</h2>
                <p class="card-2recherche">Type : ${displayValue(item.titletype, 'Aucune information')}</p>
                <p class="card-3recherche">Date : ${displayValue(item.startyear, 'Aucune information')}</p>
                <p class="card-4recherche">Genres : ${displayValue(item.genres, 'Aucune information')}</p>

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