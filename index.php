<?php
//index utilise le classes (ex: FilmController... ) qui sont presentes dans le dossier Controller 
use Controller\FilmController;
use Controller\GenreController;
use Controller\RoleController;
use Controller\RealisateurController;
use Controller\PersonneController;

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

$ctrlFilm = new FilmController();
$ctrlPersonne = new PersonneController();
$ctrlGenre = new GenreController();
$ctrlRole = new RoleController();


$id = (isset($_GET["id"])) ?$_GET["id"] : null;

if(isset($_GET["action"])) {
    switch ($_GET["action"]){

        case "listFilms" : $ctrlFilm->listFilms();break;
        case "listActeurs" : $ctrlPersonne->listActeurs();break; 
        case "detailFilm" :  $ctrlFilm->detailFilm($id);break;
        case "listGenres" : $ctrlGenre->listGenres();break;
        case "detailGenre" : $ctrlGenre->detailGenre($id);break;
        case "detailRealisateur" : $ctrlPersonne->detailRealisateur($id);break; 
        case "detailActeur" : $ctrlPersonne->detailActeur($id);break;
        case "listRealisateurs" : $ctrlPersonne->listRealisateurs();break;
        case "ajoutGenre" : $ctrlGenre->ajoutGenre();break;
        case "ajoutPersonne" :$ctrlPersonne->ajoutPersonne();break;
        case "ajoutRole": $ctrlRole->ajoutRole();break;
        case "ajoutFilm":$ctrlFilm->ajoutFilm();break;
        case "supprimerGenre" :$ctrlGenre->supprimerGenre();break;
        case "supprimerFilm" : $ctrlFilm->supprimerFilm();break;
        case "supprimerActeur" : $ctrlPersonne->supprimerActeur();break;
        case "supprimerRealisateur" : $ctrlPersonne->supprimerRealisateur();break;
        case "editGenre" : $ctrlGenre->editGenre($id);break;

    }

} else {
    $ctrlFilm->listFilms();
}

