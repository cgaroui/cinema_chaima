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
           

        </tr>

    </thead>
</table>
<tbody>
        <?php
           
            foreach($requete_detGenre->fetchAll() as $film){ ?>
            <h3></h3>

                <tr>
                    
                    <td><?=$film["titre"]?></td>
                    <td><?=$film["annee_sortie"]?></td>
                    <td><?=$film["duree"]?></td>
                    <td><?=$film["note"]?></td>
                   
                    
                </tr>
                <?php }?>
    </tbody>
</table>

<?php
$titre = "Detail d'un Genre";
$titre_secondaire ="Genre ".$film["nom_genre"] ;
$contenu = ob_get_clean();
require "view/template.php";

