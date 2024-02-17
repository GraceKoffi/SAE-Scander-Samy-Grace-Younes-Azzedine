function displayValue(value, defaultValue) {
    return (value === null || value === undefined || value === '') ? defaultValue : value;
  }
  
  function formatRating(rating) {
    return (rating === null || rating === undefined || rating === '') ? "Aucune information" : `${rating}/10.0`;
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
  async function getFilmPhoto(id) {
    const apiKey = "9e1d1a23472226616cfee404c0fd33c1";
    const url = `https://api.themoviedb.org/3/movie/${id}?api_key=${apiKey}&language=fr`;

    try {
        const response = await fetch(url);
        const data = await response.json();

        // Retourne le chemin de l'image de dépannage si aucun poster n'est trouvé
        return data.poster_path ? `https://image.tmdb.org/t/p/w400${data.poster_path}` : "./Images/depannage.jpg";
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
        return "./Images/depannage.jpg"; // Retourne le chemin vers une image de dépannage en cas d'erreur
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
  