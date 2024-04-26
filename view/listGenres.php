<?php
ob_start();
$genres = $requete_genres->fetchAll();
?>

<table>
    <thead>
        <tr>
            <th>Nom du Genre </th>
            <th>nombre de films </th>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach($genres as $genre){?>

            <tr>
                <td><a href="index.php?action=detailGenre&id=<?= $genre["id_genre"] ?>"><?= $genre["nom_genre"] ?></a></td>
                <td><?=$genre["nombre de films"]?></td>
            </tr>
            <?php }?>
    
    </tbody>
</table>
<?php
$titre = "Liste des Genres ";
$titre_secondaire = "Liste des Genres ";
$contenu = ob_get_clean();
require "view/template.php";


