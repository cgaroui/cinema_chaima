<?php
ob_start();
?>

<table>
    <thead>
        <tr>
            <th>Titre du film </th>
            <th>Acteur </th>
            <th>Role </th>
            
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete_castingFilm->fetchAll() as $personnage){ ?>
            <h3></h3>
                <tr>
                    <td><?=$personnage["Titre du film"]?></td>
                    <td><?=$personnage["Acteur"]?></td>
                    <td><?=$personnage["role dans le film"]?></td>
    
                    
                </tr>
                <?php }?>
    </tbody>
</table>



<?php
$titre = "Casting d'un film ";
$titre_secondaire = "Casting d'un film ";
$contenu = ob_get_clean();
require "view/template.php";
