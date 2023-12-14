document.addEventListener("DOMContentLoaded", function() {
    // Déclarer la variable rechercheInput2 en dehors de la fonction pour qu'elle soit accessible globalement
    const rechercheInput2 = document.querySelector("input[name='recherche']");

    function getSuggestions() {
        const type = document.querySelector("select[name='type']").value;
        const recherche = rechercheInput2.value;

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const suggestionsList = document.getElementById("suggestions");
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

        xhr.open("GET", `?controller=recherche&action=get_suggestions&type=${type}&recherche=${recherche}`, true);
        xhr.send();
    }

    document.querySelector("input[name='recherche']").addEventListener("input", getSuggestions);
});
