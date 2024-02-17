<?php
function e($message)
{
    return htmlspecialchars($message, ENT_QUOTES);
}

function generatePaginationLink($page, $currentParams) {
    // Récupérer tous les paramètres de la requête actuelle
    $queryParams = $_POST;

    // Supprimer le paramètre 'page' s'il existe
    unset($queryParams['page']);

    // Fusionner les paramètres actuels avec ceux de la pagination
    $params = array_merge($queryParams, ['page' => $page]);

    // Générer le lien de pagination avec les paramètres de filtre
    $queryString = http_build_query($params);
    return "?controller=recherche&action=rechercher&$queryString";
}

function getFilmPhotoOverview($id) {
    $api_key = "9e1d1a23472226616cfee404c0fd33c1";
    $url = "https://api.themoviedb.org/3/movie/{$id}?api_key={$api_key}&language=fr";

    // Initialisation des valeurs par défaut
    $poster_path = "./Images/depannage.jpg"; // Photo de dépannage
    $overview = "Pas d'overview disponible"; // Message par défaut

    // Initialisation de la session cURL
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

    // Exécution de la requête cURL
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    // Traitement de la réponse
    if (!$err) {
        $data = json_decode($response, true);
        // Vérifier si le poster est disponible
        if (!empty($data['poster_path'])) {
            $poster_path = "https://image.tmdb.org/t/p/w400" . $data['poster_path'];
        }
        // Vérifier si l'overview est disponible
        if (!empty($data['overview'])) {
            $overview = $data['overview'];
        }
    } else {
        // Gestion de l'erreur cURL
        // Vous pouvez logger l'erreur ou afficher un message
        error_log('Erreur cURL : ' . $err);
    }

    return array(
        'poster_path' => $poster_path,
        'overview' => $overview
    );
}



function creationcard($movie) {
    $filmDetails = getFilmPhotoOverview($movie['id']);
    $poster_path = $filmDetails['poster_path'];
    $overview = $filmDetails['overview'];
    return <<<HTML
    <div class="card">
        <h2>{$movie['recherche']}</h2>
        <p>{$movie['date']}</p>
        <p>{$movie['role']}</p>
        <img src="{$poster_path}" alt="{$movie['recherche']}">
        <p>{$overview}</p>
    </div>
HTML;
}