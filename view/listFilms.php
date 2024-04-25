<?php 

ob_start(); 

?>

<p >il y a <?= $requete->rowCount() ?> films</p>       <!--  la fonction rowCount() calcule le nmbre de ligne (ici car on affiche 1 film par ligne ) -->

<table>
    <thead>
        <tr>
            <th>Titre </th>
            <th>ANNEE SORTIE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //affichage plusieur lignes (avec fetchAll) en indiquant pour chaque ligne le titre et l'année de sortie du film concerné 
            foreach($requete->fetchAll() as $film){ ?>
                <tr>
                    <td><a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>"><?=$film["titre"]?></a></td>
                    <td><?=$film["annee_sortie"]?></td>
                </tr>
                <?php }?>
    </tbody>
</table>

<?php
$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require "view/template.php";
