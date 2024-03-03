<?php require "Views/view_navbar.php"; ?>
<style>


</style>
<p style="margin-top:100px">Avec "Liens" sur Findercine, plongez au cœur des réseaux du divertissement pour révéler les connexions inattendues entre vos personnalités et titres préférés. Que vous cherchiez à découvrir les projets communs entre deux personnes du monde du spectacle, ou à identifier les collaborations entre différents titres, "Liens" est l'outil parfait.</p>


<div class="formulaire mx-auto col-md-9">
        <div class="d-flex align-items-center">
        <img src="./Images/networkjaune.png" alt="Filtre" style="margin-right: -37px;">
        <h3 class="m-5">Chemin le plus court</h3>
        </div>
        <form action="?controller=trouver&action=trouver" method="post" class="m-5">

                                <label class="labelfiltre" for="typeselection" class="form-label">Trouver les liens par rapport au :</label>
                                <div class="mb-5">
                                    <select class="form-select" id="typeselection" name="typeselection" style="border-radius: 10px 10px 10px 10px; width: 146px;height: 40px;text-align: center;">
                                        <option value="titre">Titre</option>
                                        <option value="personne">Personne</option>
                                    </select>
                                </div>


                                <div id="filter-box-titre" style="display: none;">
                                                <div class="row">
                                                            <div class ="col-md-5 mx-auto">
                                                                    <label class="labelfiltre form-label"  for="titre1">Titre n°1 : </label>
                                                                    <div class=" d-flex align-items-start">
                                                                    <select class="custom-select" name="categorytitre1" id="categorytitre1" style="max-width: 120px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                                                <option value="all">Tout</option>
                                                                                <option value="movie">Movie</option>
                                                                                <option value="tvSeries">TV Series</option>
                                                                                <option value="tvEpisode">TV Episode</option>
                                                                                <option value="video">Video</option>
                                                                                <option value="tvSpecial">TV Special</option>
                                                                                <option value="tvPilot">TV Pilot</option>
                                                                                <option value="short">Short</option>
                                                                                <option value="videoGame">Video Game</option>
                                                                                <option value="tvMiniSeries">TV Mini-Series</option>
                                                                                <option value="tvMovie">TV Movie</option>
                                                                                <option value="tvShort">TV Short</option>
                                                                            </select>
                                                                            <input type="text" class="mb-1 form-control filter-input" style = "border-top-left-radius: 0; border-bottom-left-radius: 0;" id="titre1" name="titre1" placeholder="Titre n°1">
                                                                            

                                                                    </div>
                                                                    <div id="titre1-error" style="display: none; color: red;">Veuillez sélectionner un titre. </div>
                                                                     
                                                            </div> 
                                                            <div class="col-md-2"></div>
                                                            <div class ="col-md-5 mx-auto">
                                                                    <label class="labelfiltre form-label"  for="titre2">Titre n°2 : </label>
                                                                    <div class="d-flex align-items-start">
                                                                            <select class="custom-select" name="categorytitre2" id="categorytitre2" style="max-width: 120px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                                                <option value="all">Tout</option>
                                                                                <option value="movie">Movie</option>
                                                                                <option value="tvSeries">TV Series</option>
                                                                                <option value="tvEpisode">TV Episode</option>
                                                                                <option value="video">Video</option>
                                                                                <option value="tvSpecial">TV Special</option>
                                                                                <option value="tvPilot">TV Pilot</option>
                                                                                <option value="short">Short</option>
                                                                                <option value="videoGame">Video Game</option>
                                                                                <option value="tvMiniSeries">TV Mini-Series</option>
                                                                                <option value="tvMovie">TV Movie</option>
                                                                                <option value="tvShort">TV Short</option>
                                                                            </select>
                                                                            <input type="text" class="mb-1 form-control filter-input" style = "border-top-left-radius: 0; border-bottom-left-radius: 0;" id="titre2" name="titre2" placeholder="Titre n°2">

                                                                    </div>
                                                                    <div id="titre2-error" style="display: none; color: red;">Veuillez sélectionner un titre. </div>

                                                            </div> 
                                                </div>  
                                </div><!-- filtre titre -->
                                <div id="filter-box-personne" style="display: none;">

                                                <div class="row">
                                                            <div class ="col-md-5 mx-auto">
                                                                    <label class="labelfiltre form-label"  for="personne">Personne n°1 : </label>
                                                                    <div class="d-flex align-items-start">
                                                                            <input type="text" class="mb-1 form-control filter-input" id="personne1" name="personne1" placeholder="Personne n°1">
                                                                    </div>
                                                                    <div id="personne1-error" style="display: none; color: red;">Veuillez sélectionner une personne. </div>

                                                            </div> 
                                                            <div class="col-md-2"></div>
                                                            <div class ="col-md-5 mx-auto">
                                                                    <label class="labelfiltre form-label"  for="personne2">Personne n°2 : </label>
                                                                    <div class="d-flex align-items-start">
                                                                            <input type="text" class="mb-1 form-control filter-input" id="personne2" name="personne2" placeholder="Personne n°2">
                                                                    </div>
                                                                    <div id="personne2-error" style="display: none; color: red;">Veuillez sélectionner une personne. </div>

                                                            </div> 
                                                </div> 

                                </div><!-- filtre personne -->

                <button type="submit" id="buttontrouver" class="btn btn-warning mt-3 mx-auto" style =" color: white;display: block;" >Trouver</button>
                                            
        </form>
    </div>

      
        







<script>

$(document).ready(function() {
    handleFormValidation();
    toggleFiltersOnSelection();

});
function toggleFiltersOnSelection() {
    $('#typeselection').change(function() {
        var typeSelection = $(this).val();
        if (typeSelection === 'titre') {
            $('#filter-box-titre').show();
            $('#filter-box-personne').hide();
        } else {
            $('#filter-box-personne').show();
            $('#filter-box-titre').hide();
        }
        resetFormFields();
    }).trigger('change');
}

function resetFormFields() {
    $('#titre1').val('');
    $('#titre2').val('');
    $('#personne1').val('');
    $('#personne2').val('');
  
   
    $('.error').hide();
}



function handleFormValidation() {
    $('form').submit(function(e) {
        var isValid = true;
        var typeSelection = $('#typeselection').val();
        $('.error').hide(); // Cache tous les messages d'erreur
        
        if (typeSelection === 'titre') {
            var titre1 = $('#titre1').val().trim();
            var titre2 = $('#titre2').val().trim();
            if (!titre1) {
                $('#titre1-error').show();
                isValid = false;
            }
            if (!titre2) {
                $('#titre2-error').show();
                isValid = false;
            }
        } else if (typeSelection === 'personne') {
            var personne1 = $('#personne1').val().trim();
            var personne2 = $('#personne2').val().trim();
            if (!personne1) {
                $('#personne1-error').show();
                isValid = false;
            }
            if (!personne2) {
                $('#personne2-error').show();
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault(); // Empêche la soumission du formulaire si invalide
        }
    });

    // Cache les messages d'erreur lors de la correction des champs
    $('#titre1, #titre2, #personne1, #personne2').on('input', function() {
        var errorId = '#' + $(this).attr('id') + '-error';
        $(errorId).hide();
    });
}


</script>






<?php require "Views/view_footer.php"; ?>