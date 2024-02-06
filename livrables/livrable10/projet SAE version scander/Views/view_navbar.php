<!DOCTYPE html>
<html lang="fr">
<head>
    <title>FinderCine</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    
    
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top navbar-transparent">
    <a class="navbar-brand" href="?controller=home&action=home"><img src="#" alt="Logo"></a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <?php
            $navItems = [
                ['Accueil', '?controller=home&action=home', 'home1.png'],
                ['Recherche','?controller=recherche&action=home', 'search1.png'],
                ['Trouver', '?controller=trouver&action=fom_trouver', 'liens.png'],
                ['Rapprochement', '?controller=rapprochement&action=fom_rapprochement', 'data1.png'],
                ['Login', '?controller=connect', 'data1.png']
            ];

            foreach ($navItems as $item) {
                echo '<li class="nav-item">';
                echo '<a class="nav-link" href="' . $item[1] . '">';
                echo '<img src="./images/' . $item[2] . '" alt="Favicon ' . $item[0] . '"> ' . $item[0];
                echo '</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>
<script><?=require "Js/navbar.js"; ?></script>