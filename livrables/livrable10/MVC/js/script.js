document.addEventListener("DOMContentLoaded", function() {
    function getSuggestions() {
        const type = document.querySelector("select[name='type']").value;
        const recherche = document.querySelector("input[name='recherche']").value;

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
                    if(type == 'nom'){
                        suggestionItem.innerHTML = `<a href="?controller=recherche&action=afficher_acteur&nom=${suggestion}">${suggestion}</a>`;
                    }
                    else{
                        suggestionItem.innerHTML = `<a href="?controller=recherche&action=afficher_film&nom=${suggestion}">${suggestion}</a>`;
                    }
                   
                    suggestionsList.appendChild(suggestionItem);
                });
            }
        };

        xhr.open("GET", `?controller=recherche&action=get_suggestions&type=${type}&recherche=${recherche}`, true);
        xhr.send();
    }

    document.querySelector("input[name='recherche']").addEventListener("input", getSuggestions);
});
