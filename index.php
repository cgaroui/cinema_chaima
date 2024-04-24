<?php
//index utilise le classes (ex: FilmController... ) qui sont presentes dans le dossier controller 
use controller\ActeurController;
use controller\FilmController;

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

$ctrlFilm = new FilmController();
$ctrlActeur = new ActeurController();


$id = (isset($_GET["id"])) ?$_GET["id"] : null;

if(isset($_GET["action"])) {
    switch ($_GET["action"]){

        case "listFilms" : $ctrlFilm->listFilms();break;
        case "listActeurs" : $ctrlActeur->listActeurs();break; 
        case "detailFilm" :  $ctrlFilm->detailFilm($id);break;
    }
}

