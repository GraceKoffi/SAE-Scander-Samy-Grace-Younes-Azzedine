document.addEventListener("DOMContentLoaded", function() {
    const rechercheInput = document.getElementById("rechercheInput");
    const suggestionsList = document.getElementById("suggestions");

    rechercheInput.addEventListener("input", getSuggestions);

    function getSuggestions() {
        const type = document.querySelector("select[name='type']").value;
        const recherche = rechercheInput.value;

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
                        rechercheInput.value = event.target.dataset.value;
                        suggestionsList.style.display = 'none';
                    });

                    suggestionsList.appendChild(suggestionItem);
                });
            }
        };

        xhr.open("GET", `?controller=recherche&action=get_suggestions&type=${type}&recherche=${recherche}`, true);
        xhr.send();
    }
});