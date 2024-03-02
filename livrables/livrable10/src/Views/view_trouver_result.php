<?php require "Views/view_navbar.php"; ?>
<style>

</style>
<div class="row" style="margin-top: 120px;">
    <div class="col-md-8 m-5">
        <?php if (isset($titre1) && isset($titre2)): ?>
        <h1>Résultats entre "<?= e($titre1) ?>" et "<?= e($titre2) ?>"</h1>
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
        <option value="name-asc">Nom - Ascendant</option>
        <option value="name-desc">Nom - Descendant</option>
        <option value="birth-asc">Date de naissance - Ascendant</option>
        <option value="birth-desc">Date de naissance - Descendant</option>
        <option value="profession-asc">Métier - Ascendant</option>
        <option value="profession-desc">Métier - Descendant</option>
    

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
        let posterPath = await getPersonnePhoto(item.nconst);
        let hrefValue = `?controller=home&action=information_acteur&id=${item.nconst}`;
        let cardContent = `<a href="${hrefValue}" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
            <div class="cardrecherche" style="cursor: pointer;">
                <img src="${posterPath}" alt="${item.nconst}">
                <div class="card-bodyrecherche">`;

        
            cardContent += `
                <h2 class="card-1recherche">${displayValue(item.primaryname, 'Aucune information')}</h2>
                <p class="card-2recherche">Type : ${displayValue(item.birthyear, 'Aucune information')}</p>
                <p class="card-3recherche">Date : ${displayValue(item.primaryprofession, 'Aucune information')}</p>
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