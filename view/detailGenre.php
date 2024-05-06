<?php
ob_start();

// Récupérer tous les films du genre
$genre_films =$requete_detGenre->fetchAll();

// Obtenir le nom du genre
// Obtenir le nom du genre
$nom_genre = isset($requete_nom) ? $requete_nom->fetch() : null;
// var_dump($nom_genre); die;
 
?>

<table>
    <thead>
        <tr>
            <th>Titre du film </th>
            <th>Année de sortie </th>
            <th>durée </th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        <?php
       // Vérifiez si le genre a des films associés
       if (!empty($genre_films)) {
        foreach($genre_films as $genre_film){ ?>
        
            <tr>
                <td><a href="index.php?action=detailFilm&id=<?=$genre_film["id_film"]?>"><?=$genre_film["titre"]?></a></td>
                <td><?=$genre_film["annee_sortie"]?></td>
                <td><?=$genre_film["duree"]?></td>
                <td><?=$genre_film["note"]?></td>
            </tr>
        <?php }
    } else { // Si aucun film n'est associé à ce genre
        echo "<tr><td colspan='4'>Aucun film associé à ce genre.</td></tr>";
    } ?>
    </tbody>
</table>

<?php
$titre = "Detail d'un Genre";
$titre_secondaire ="Genre ".$nom_genre["nom_genre"];
$contenu = ob_get_clean();
require "view/template.php";

