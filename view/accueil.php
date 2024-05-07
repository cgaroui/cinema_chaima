<?php
ob_start();

$nvFilms = $requete_nouveaute->fetchAll();
?>

<link rel="stylesheet" href="css/accueil.css">

<p>Nouveauté</p>

<table>
    <thead>
        <tr>
            <th>Titre </th>
            <th>ANNEE SORTIE</th>
            <th>affiche</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach($nvFilms as $nvFilm){ ?>
    <tr>
        <td><?=$nvFilm["titre"]?></td>
        <td><?=$nvFilm["annee_sortie"]?></td>
        <td><?=$nvFilm["affiche"]?></td>
    </tr>

<?php }?>
</tbody>
</table>





<?php
$titre = "Cinemax";
$titre_secondaire = "Cinemax";
$contenu = ob_get_clean();
require "view/template.php";
