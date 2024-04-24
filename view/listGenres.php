<?php
ob_start();
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
        foreach($requete_genres->fetchAll() as $genre){?>
            <tr>
                <td><?=$genre["nom_genre"]?></td>
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