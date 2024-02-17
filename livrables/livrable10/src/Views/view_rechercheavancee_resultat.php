<?php require "Views/view_navbar.php"; ?>
<style>

</style>
<div class="row" style="margin-top: 120px;">
    <div class="col-md-8 m-5">
        <?php if (isset($titrerecherche)): ?>
        <h1>Résultats "<?= e($titrerecherche) ?>"</h1>
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
        <option value="type-asc">Type - Ascendant</option>
        <option value="type-desc">Type - Descendant</option>
        <option value="genres-asc">Genres - Ascendant</option>
        <option value="genres-desc">Genres - Descendant</option>
        <option value="rating-asc">Note - Ascendant</option>
        <option value="rating-desc">Note - Descendant</option>
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
    let movies = <?php echo json_encode($recherchetitre); ?>;

    let currentPage = 1;
let moviesPerPage = 10;

async function displayMovies() {
  const list = document.getElementById("movie-list");
  list.innerHTML = ""; // Efface la liste actuelle
  let endIndex = currentPage * moviesPerPage;
  let startIndex = endIndex - moviesPerPage;
  let paginatedMovies = movies.slice(startIndex, endIndex);

  for (const movie of paginatedMovies) {
    let posterPath = await getFilmPhoto(movie.tconst); 

    let cardContent = `
    <a href="?controller=home&action=information_movie&id=${movie.tconst}" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
        <div class="cardrecherche" style="cursor: pointer;">
          <img src="${posterPath}" alt="${movie.tconst}">
          <div class="card-bodyrecherche">
            <h2 class="card-titlerecherche">${displayValue(movie.primarytitle, 'Aucune information')}</h2>
            <p class="card-rolerecherche">Type : ${displayValue(movie.titletype, 'Aucune information')}</p>
            <p class="card-daterecherche">Date : ${displayValue(movie.startyear, 'Aucune information')}</p>
            <p class="card-genrerecherche">Genres : ${displayValue(movie.genres, 'Aucune information')}</p>
            <p class="card-noterecherche">Note : ${formatRating(movie.averagerating)}</p>       
          </div>
        </div>
      </a>
    `;

    // Ajoute directement le contenu de la carte au conteneur list
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
      default:
        return 0;
    }
  });
  currentPage = 1; // Reset to the first page
  displayMovies();
}



// Initialisation de l'affichage
displayMovies();
</script>

<?php require "Views/view_footer.php"; ?>