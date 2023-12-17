document.addEventListener("DOMContentLoaded", function() {
    // Déclarer rechercheInput en dehors de la fonction pour qu'il soit accessible globalement
    const rechercheInput1 = document.querySelector("input[name='recherche1']");
    const rechercheInput2 = document.querySelector("input[name='recherche2']");

    function getSuggestions_1() {
        const type = document.querySelector("select[name='type']").value;
        const suggestionsList = document.getElementById("suggestions1");

        // Utiliser la variable rechercheInput1 ici
        let recherche = rechercheInput1.value;

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                suggestionsList.innerHTML = '';
                const suggestions = JSON.parse(xhr.responseText);

                if (recherche !== '') {
                    suggestionsList.style.display = 'block';
                } else {
                    suggestionsList.style.display = 'none';
                }

                suggestions.forEach(suggestion => {
                    const suggestionItem = document.createElement("div");
                    suggestionItem.className = "suggestion-item";

                    suggestionItem.innerHTML = `<a href="#" data-value="${suggestion}">${suggestion}</a>`;
                
                 

                    suggestionItem.addEventListener("click", function(event) {
                        event.preventDefault();
                        rechercheInput1.value = event.target.dataset.value;
                        suggestionsList.style.display = 'none';
                    });

                    suggestionsList.appendChild(suggestionItem);
                });
            }
        };

        xhr.open("GET", `?controller=trouver&action=get_suggestions&type=${type}&recherche=${recherche}`, true);
        xhr.send();
    }

    function getSuggestions_2() {
        const type = document.querySelector("select[name='type']").value;
        const suggestionsList = document.getElementById("suggestions2");

        // Utiliser la variable rechercheInput2 ici
        let recherche = rechercheInput2.value;

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                suggestionsList.innerHTML = '';

                const suggestions = JSON.parse(xhr.responseText);
                if (recherche !== '') {
                    suggestionsList.style.display = 'block';
                } else {
                    suggestionsList.style.display = 'none';
                }

                suggestions.forEach(suggestion => {
                    const suggestionItem = document.createElement("div");
                    suggestionItem.className = "suggestion-item";
                    if (type == 'nom') {
                        suggestionItem.innerHTML = `<a href="#" data-value="${suggestion}">${suggestion}</a>`;
                    } else {
                        suggestionItem.innerHTML = `<a href="#" data-value="${suggestion}">${suggestion}</a>`;
                    }

                    suggestionItem.addEventListener("click", function(event) {
                        event.preventDefault();
                        rechercheInput2.value = event.target.dataset.value;
                        suggestionsList.style.display = 'none';
                    });

                    suggestionsList.appendChild(suggestionItem);
                });
            }
        };

        xhr.open("GET", `?controller=trouver&action=get_suggestions&type=${type}&recherche=${recherche}`, true);
        xhr.send();
    }

    document.querySelector("input[name='recherche1']").addEventListener("input", getSuggestions_1);
    document.querySelector("input[name='recherche2']").addEventListener("input", getSuggestions_2);
});
