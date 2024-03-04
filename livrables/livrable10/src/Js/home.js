
//flèches pour chaque section et mouvement lors du clique
var sections = document.querySelectorAll('.films-section');
sections.forEach(function (section) {
    var scrollWrapper = section.querySelector('.scrolling-wrapper');
    var scrollStep = 200;
    var scrollButtons = section.querySelectorAll('.scroll-btn');
    scrollButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            if (button.classList.contains('left')) {
                scrollWrapper.scrollLeft -= scrollStep;
            } else {
                scrollWrapper.scrollLeft += scrollStep;
            }
        });
    });
});


$('.carousel').carousel();

document.addEventListener('DOMContentLoaded', (event) => {
    let currentIndex = 0;
    const groups = document.querySelectorAll('.card-group');
    const maxIndex = groups.length;

    setInterval(() => {
        groups[currentIndex].style.display = 'none'; // Cache le groupe actuel
        currentIndex = (currentIndex + 1) % maxIndex; // Calcule l'index du prochain groupe
        groups[currentIndex].style.display = 'block'; // Affiche le prochain groupe
    }, 3000); // Change toutes les 3 secondes
});

document.addEventListener("DOMContentLoaded", function() {
    const apiKey = '9e1d1a23472226616cfee404c0fd33c1';

    // Trouver toutes les images avec un data-tconst
    document.querySelectorAll('img[data-tconst]').forEach(img => {
        const tconst = img.getAttribute('data-tconst');
        
        // Utiliser l'endpoint de recherche multi de TMDB pour trouver des informations basées sur tconst
        const url = `https://api.themoviedb.org/3/find/${tconst}?api_key=${apiKey}&language=en-US&external_source=imdb_id`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                let imagePath = './images/depannage.jpg'; // Chemin de l'image par défaut

                ['movie_results', 'person_results', 'tv_results', 'tv_episode_results', 'tv_season_results'].forEach(resultType => {
                    if (data[resultType].length > 0 && data[resultType][0].poster_path) {
                        imagePath = `https://image.tmdb.org/t/p/w500${data[resultType][0].poster_path}`;
                        return;
                    }
                });

                img.src = imagePath;
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des images:', error);
                img.src = './images/depannage.jpg';
            });
    });
});




