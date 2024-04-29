<?php
//index utilise le classes (ex: FilmController... ) qui sont presentes dans le dossier Controller 
use Controller\ActeurController;
use Controller\FilmController;
use Controller\GenreController;
use Controller\RoleController;
use Controller\RealisateurController;

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

$ctrlFilm = new FilmController();
$ctrlActeur = new ActeurController();
$ctrlGenre = new GenreController();
$ctrlRole = new RoleController();
$ctrlRealisateur = new RealisateurController();

$id = (isset($_GET["id"])) ?$_GET["id"] : null;

if(isset($_GET["action"])) {
    switch ($_GET["action"]){

        case "listFilms" : $ctrlFilm->listFilms();break;
        case "listActeurs" : $ctrlActeur->listActeurs();break; 
        case "detailFilm" :  $ctrlFilm->detailFilm($id);break;
        case "listGenres" : $ctrlGenre->listGenres();break;
        case "detailGenre" : $ctrlGenre->detailGenre($id);break;
        case "detailRealisateur" : $ctrlRealisateur->detailRealisateur($id);break; 
        case "detailActeur" : $ctrlActeur->detailActeur($id);break;
        case "listRealisateurs" : $ctrlRealisateur->listRealisateurs();break;
        case "ajoutGenre" : $ctrlGenre->ajoutGenre($id);break;
    }
} else {
    $ctrlFilm->listFilms();
}

