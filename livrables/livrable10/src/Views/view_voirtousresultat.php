<?php require "Views/view_navbar.php"; ?>


<style>
 .cardrecherche {
  display: flex;
  border: 1px solid rgba(0,0,0,.125);
  border-radius: .25rem;
  box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
  margin-bottom: 1rem;
  overflow: hidden;
  text-decoration: none; /* Enlève le soulignement des liens */
  background-color: #fff;
}

.cardrecherche .card-linkrecherche { /* Ajout de la classe card-link pour styliser le lien */
  display: flex;
  text-decoration: none; /* Enlève le soulignement des liens */
  color: inherit; /* Garde la couleur du texte héritée du parent */
}

.cardrecherche img {
  width: 150px;
  object-fit: cover; /* Assure que l'image couvre l'espace dédié */
  border-top-left-radius: .25rem;
  border-bottom-left-radius: .25rem;
}

.card-bodyrecherche {
  padding: 0.5rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  flex-grow: 1; /* Permet à card-body de prendre l'espace restant */
}

.card-titlerecherche {
  margin-bottom: 0.25rem;
  font-size: 1.25rem;
  font-weight: bold;
}

.card-daterecherche {
  margin-bottom: 0.25rem;
  font-size: 1rem;
  color: #666;
}

.card-rolerecherche {
  margin-bottom: 0.25rem;
  font-size: 1rem;
  color: #666;
}

.card-overviewrecherche {
  font-size: 0.875rem;
  color: #333;
}

/* Styles supplémentaires pour la pagination et les boutons */
#paginationrecherche button {
  padding: 5px 10px;
  margin: 0 5px;
  border: none;
  border-radius: 5px;
  background-color: #e9e9e9;
  cursor: pointer;
}

#paginationrecherche button.active {
  background-color: #007bff;
  color: white;
  border: none;
}

#paginationrecherche button:hover {
  background-color: #d0d0d0;
}

/* Styles pour les boutons de navigation */
button {
  padding: 5px 10px;
  margin: 0 5px;
  border: none;
  border-radius: 5px;
  background-color: #007bff;
  color: white;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}

</style>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
<div class="row mt-5">
       
        <div class="container col-md-3 m-5"> 
            <h1 class="mb-5">Filtres</h1>
            <label for="sort">Trier par:</label>
            <select id="sort" onchange="sortMovies()">
            <option value="title-asc">Titre - Ascendant</option>
            <option value="title-desc">Titre - Descendant</option>
            <option value="date-asc">Date - Ascendant</option>
            <option value="date-desc">Date - Descendant</option>
            </select>
        </div>

        <div class="container col-md-7 m-5">
                <?php if (isset($recherche)): ?>
                <h1 class="mb-5">Résultats "<?= e($recherche) ?>"</h1>
                <?php endif; ?>
                <div id="movies-par-page-container">
                <label for="movies-par-page">Afficher par:</label>
                <select id="movies-par-page" onchange="changeMoviesPerPage()">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                </select>
                </div>
        
                <div id="movie-list"></div>
                
                <div id="count"></div>
               
                <div id="pagination-container" style="display: flex; justify-content: center;">
                <button onclick="prevPage()"><</button>
                <div id="paginationrecherche"></div>
                <button onclick="nextPage()">></button>
                </div>
                
        </div>
               
</div>


<script>
// Données de films Spider-Man
let movies = <?php echo json_encode($resultat); ?>;

let currentPage = 1;
let moviesPerPage = 10;

async function displayMovies() {
  const list = document.getElementById("movie-list");
  list.innerHTML = ""; // Efface la liste actuelle
  let endIndex = currentPage * moviesPerPage;
  let startIndex = endIndex - moviesPerPage;
  let paginatedMovies = movies.slice(startIndex, endIndex);

  for (const movie of paginatedMovies) {
    let card = document.createElement('div');
    card.className = 'cardrecherche';

    let posterPath, overview;
    
    // Condition pour déterminer quelle fonction appeler et ajuster le contenu en conséquence
    if (movie.type === "Titre") {
      ({ posterPath, overview } = await getFilmPhotoOverview(movie.id)); // Destructuration pour récupérer posterPath et overview
    } else if (movie.type === "Personne") {
      posterPath = await getPersonnePhoto(movie.id); // Appel de getPersonnePhoto pour les personnes
      overview = ""; // Pas d'overview pour les personnes
    }

    // Construire l'HTML pour chaque carte avec ou sans overview
    let cardContent = `
      <a href="${movie.type === "Titre" ? `?controller=home&action=information_movie&id=${movie.id}` : `?controller=home&action=information_acteur&id=${movie.id}`}" class="card-linkrecherche">
        <img src="${posterPath}" alt="${movie.id}">
        <div class="card-bodyrecherche">
          <h2 class="card-titlerecherche">${movie.recherche}</h2>
          <p class="card-daterecherche">${movie.date}</p>
          <p class="card-rolerecherche">${movie.role}</p>
          ${overview ? `<p class="card-overviewrecherche">${overview}</p>` : ""}
        </div>
      </a>
    `;
    card.innerHTML = cardContent;

    list.appendChild(card);
  }

  document.getElementById("count").innerText = `Résultats : ${movies.length}`;
  // À la fin de displayMovies(), assurez-vous de remettre la page en haut et de rafraîchir la pagination
  window.scrollTo({ top: 0 });
  renderPagination();
}


function renderPagination() {
  const paginationContainer = document.getElementById('paginationrecherche');
  paginationContainer.innerHTML = ''; // Efface la pagination actuelle

  let pageCount = Math.ceil(movies.length / moviesPerPage);

  // Toujours afficher le premier bouton de page
  appendPageButton(1);

  // Gérer les cas où il y a plus de 5 pages
  if (pageCount > 5) {
    let startPage, endPage;
    if (currentPage <= 3) {
      // Afficher les premières pages
      startPage = 2;
      endPage = 4;
    } else if (currentPage >= pageCount - 2) {
      // Afficher les dernières pages
      startPage = pageCount - 3;
      endPage = pageCount - 1;
    } else {
      // Afficher les pages autour de la page courante
      startPage = currentPage - 1;
      endPage = currentPage + 1;
    }

    // Gérer l'affichage des boutons "..."
    if (startPage > 2) {
      paginationContainer.appendChild(createEllipsisButton());
    }
    for (let i = startPage; i <= endPage; i++) {
      appendPageButton(i);
    }
    if (endPage < pageCount - 1) {
      paginationContainer.appendChild(createEllipsisButton());
    }
  } else {
    // Afficher tous les boutons si 5 pages ou moins
    for (let i = 2; i < pageCount; i++) {
      appendPageButton(i);
    }
  }

  // Toujours afficher le dernier bouton de page si plus d'une page
  if (pageCount > 1) {
    appendPageButton(pageCount);
  }
}

function appendPageButton(pageNumber) {
  const paginationContainer = document.getElementById('paginationrecherche');
  let pageItem = document.createElement('button');
  pageItem.innerText = pageNumber;
  pageItem.onclick = function() {
    currentPage = pageNumber;
    displayMovies();
    renderPagination(); // Re-render la pagination pour mettre à jour les boutons
  };

  // Ajoute la classe 'active' si c'est la page courante
  if (currentPage === pageNumber) {
    pageItem.classList.add('active');
  }

  paginationContainer.appendChild(pageItem);
}

function createEllipsisButton() {
  let ellipsisButton = document.createElement('button');
  ellipsisButton.innerText = '...';
  ellipsisButton.disabled = true;
  return ellipsisButton;
}


function changeMoviesPerPage() {
  moviesPerPage = document.getElementById("movies-par-page").value;
  currentPage = 1; // Reset to the first page
  displayMovies();
  renderPagination();
}




function prevPage() {
  if (currentPage > 1) {
    currentPage--;
    displayMovies();
  }
}

function nextPage() {
  if (currentPage * moviesPerPage < movies.length) {
    currentPage++;
    displayMovies();
  }
}

function sortMovies() {
  let sortOrder = document.getElementById("sort").value;
  if (sortOrder.includes('title')) {
    // Trier par titre
    movies.sort((a, b) => {
      let titleA = a.recherche.toUpperCase(); // Ignore la casse
      let titleB = b.recherche.toUpperCase(); // Ignore la casse
      if (sortOrder === 'title-asc') {
        return titleA.localeCompare(titleB);
      } else {
        return titleB.localeCompare(titleA);
      }
    });
  } else {
    // Trier par date
    movies.sort((a, b) => {
      let dateA = a.date;
      let dateB = b.date;
      if (sortOrder === 'date-asc') {
        return dateA - dateB;
      } else {
        return dateB - dateA;
      }
    });
  }
  currentPage = 1; // Reset to the first page
  displayMovies();
}

async function getFilmPhotoOverview(id) {
    const apiKey = "9e1d1a23472226616cfee404c0fd33c1";
    const url = `https://api.themoviedb.org/3/movie/${id}?api_key=${apiKey}&language=fr`;

    try {
        const response = await fetch(url);
        const data = await response.json();

        let posterPath = "./Images/depannage.jpg"; // Photo de dépannage par défaut
        let overview = "Pas d'overview disponible"; // Message par défaut

        // Vérifier si le poster est disponible
        if (data.poster_path) {
            posterPath = `https://image.tmdb.org/t/p/w400${data.poster_path}`;
        }

        // Vérifier si l'overview est disponible
        if (data.overview) {
            overview = data.overview;
        }

        return {
            posterPath: posterPath,
            overview: overview
        };
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
        return {
            posterPath: "./Images/depannage.jpg",
            overview: "Erreur lors de la récupération des données"
        };
    }
}
async function getPersonnePhoto(id) {
    const apiKey = "9e1d1a23472226616cfee404c0fd33c1";
    const url = `https://api.themoviedb.org/3/find/${id}?api_key=${apiKey}&language=fr&external_source=imdb_id`;

    try {
        const response = await fetch(url);
        const data = await response.json();

        let posterPath = "./Images/depannage.jpg"; // Photo de dépannage par défaut

        if (data.person_results && data.person_results.length > 0 && data.person_results[0].profile_path) {
            posterPath = `https://image.tmdb.org/t/p/w400${data.person_results[0].profile_path}`;
        }

        return posterPath;
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
        return "./Images/depannage.jpg";
            
        
    }
}
// Initialisation de l'affichage
displayMovies();
</script>

<?php require "Views/view_footer.php"; ?>