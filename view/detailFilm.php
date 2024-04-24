<?php
ob_start();
?>

<table>
    <thead>
        <tr>
            <th>Titre du film </th>
            <th>Année de sortie </th>
            <th>durée </th>
            <th>Note</th>
            <th>realisateur</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete_detFilm->fetchAll() as $detFilm){ ?>
            <h3></h3>
                <tr>
                    <td><?=$detFilm["titre"]?></td>
                    <td><?=$detFilm["annee_sortie"]?></td>
                    <td><?=$detFilm["duree"]?></td>
                    <td><?=$detFilm["note"]?></td>
                    <td><?=$detFilm["realisateur"]?></td>
                    
                </tr>
                <?php }?>
    </tbody>
</table>



<?php
$titre = "Detail d'un film ";
$titre_secondaire = "Detail d'un film ";
$contenu = ob_get_clean();
require "view/template.php";
