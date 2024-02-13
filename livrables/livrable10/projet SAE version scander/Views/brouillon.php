
                <table id="example" class="table table-striped nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011-04-25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011-07-25</td>
                <td>$170,750</td>
            </tr>
            <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009-01-12</td>
                <td>$86,000</td>
            </tr>
            <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2012-03-29</td>
                <td>$433,060</td>
            </tr>
            <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                <td>2011-01-25</td>
                <td>$112,000</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>


<!-- Balise link pour DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.2.0/css/searchPanes.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.2.0/js/dataTables.searchPanes.min.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.2.0/js/searchPanes.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>










<?php
                $totalPages = ceil($totalResultats / $perPage);
$range = 5;
$start = max($page - $range, 1);
$end = min($page + $range, $totalPages);
?>
<ul class="pagination" style="center">
    <?php
    // Génération des liens de pagination
    for ($i = $start; $i <= $end; $i++) :
    ?>
        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
            <a class="page-link" href="?controller=recherche&action=pagination&page=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
    <?php endfor; ?>

    <?php if ($end < $totalPages) : ?>
        <li class="page-item">
            <a class="page-link" href="#">...</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="?controller=recherche&action=pagination&page=<?php echo $totalPages; ?>"><?php echo $totalPages; ?></a>
        </li>
    <?php endif; ?>
</ul>




tt2039417 probleme affichage / aussi tt0194207
<img src="https://image.tmdb.org/t/p/w200<?= $portrait ?>" alt="<?= e($v['primarytitle']) ?>">







<?php
$api_key = "9e1d1a23472226616cfee404c0fd33c1";
$url = "https://api.themoviedb.org/3/movie/now_playing?api_key=" . $api_key;

// Utilisation de cURL pour récupérer les films actuellement en salle

   // $ch = curl_init($url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $response = curl_exec($ch);
// curl_close($ch);
$movie_data = file_get_contents($url);

$movies = json_decode($movie_data, true)['results'];

$tab_poster = [];

// Parcourir la liste des films
foreach ($movies as $movie) {
    $backdrop_path = $movie['backdrop_path'];
    $imageposter=$movie['poster_path']; 
    $titrecaroussel=$movie['title'];
    $tabimage[]=$imageposter;
    $tab_poster[] = $backdrop_path;
    $titrecarou[]=$titrecaroussel;
}
?>

<h1 class="mt-5"> Film Populaire </h1>
<div class="row mt-5">


<div class="col-md-7 mt-5">
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="3500">
<div class="carousel-inner">
    <?php for ($i = 0; $i < count($tabimage); $i++) : ?>
        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
            <img class="d-block w-100" src="https://image.tmdb.org/t/p/w1280<?= $tab_poster[$i] ?>" alt="Slide <?= $i + 1 ?>">
            <div class="carousel-caption d-none d-md-block">
                <!-- Image superposée -->
                <img src="https://image.tmdb.org/t/p/w500<?= $tabimage[$i] ?>" class="img-fluid" style="width: 150px; height: auto; position: absolute; bottom: 20px; left: 20px;">
                <!-- Texte -->
                <h5 style="position: absolute; bottom: 20px; left: 180px; color: white; font-size:40px;"><?= $titrecarou[$i] ?></h5>
            </div>
        </div>
    <?php endfor; ?>
</div>

    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
    </div>
    </div>

<?php

$genres = [
    'Action' => 28,
    'Thriller' => 53,
    'Jeunesse' => 16,
    'Horreur' => 27,
    'Comédie' => 35,
    'Crime' => 80,
    'Science-Fiction' => 878
];

foreach ($genres as $genre_name => $genre_id) {
    $movies = get_movies($genre_id, $api_key);

    echo '<div class="container mt-4 films-section">';
    echo '<h5>' . $genre_name . '</h5>';
    echo '<div class="scrolling-container">';
    echo '<div class="scrolling-wrapper">';

    foreach ($movies as $movie) {
        $tmdb_id = $movie['id'];
        $imdb_id = get_imdb_id($tmdb_id, $api_key);  // Fonction pour obtenir l'ID IMDB
        $poster_path = $movie['poster_path'];

        echo '<a href="?controller=home&action=information_movie&id=' . $imdb_id . '"  class="card composent-card" style="width: 200px;">';
        echo '<img src="https://image.tmdb.org/t/p/w500' . $poster_path . '" alt="Poster" class="card-img-top">';
        echo '<div class="card-body">';
        echo '<img src="./images/star.png" alt="Star" class="star">';
        echo '<span class="note">' . $movie['vote_average'] . '</span>';
        echo '<h6 class="card-subtitle mb-2 text-muted">  sodksodks skdskdsl</h6>';
       
    
        echo '<h5 class="card-title">' . $movie['title'] . '</h5>';
        echo '</div>';
        echo '</a>';
    }

    echo '</div>';
    echo '<button class="scroll-btn left"><</button>';
    echo '<button class="scroll-btn right">></button>';
    echo '</div>';
    echo '</div>';

    
}



function get_movies($genre_id, $api_key) {//recup une liste au hasard en 1 50 de film avec le genre concernet 
 
    $allMovies = [];
    $minPage = 1;
    $maxPage = 50;
    $page = rand($minPage, $maxPage);

    $url = "https://api.themoviedb.org/3/discover/movie?api_key={$api_key}&include_adult=false&with_genres={$genre_id}&page={$page}";

    // $ch = curl_init($url);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $response = curl_exec($ch);
    // curl_close($ch);
    $response = file_get_contents($url);
    $movies = json_decode($response, true)['results'];
    return $allMovies = array_merge($allMovies, $movies);
}


function get_imdb_id($tmdb_id, $api_key) {//recup idImdb avec id tmdb
    $url = "https://api.themoviedb.org/3/movie/{$tmdb_id}?api_key={$api_key}";

    // $ch = curl_init($url);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $response = curl_exec($ch);
    // curl_close($ch);
    $response = file_get_contents($url);
    $movie = json_decode($response, true);
    return $movie['imdb_id'];
}

?>