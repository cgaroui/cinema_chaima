<?php
ob_start();
$castings= $requete_castingFilm->fetchAll();
$detail_film = $requete_detFilm->fetch();
?>



<p>
    <?php echo "Titre du film : ".$detail_film["titre"]."<br>".
     "Année de sortie : ".$detail_film["annee_sortie"]."<br>".
     "duree : ".$detail_film["duree"]."<br>".
     "note : ".$detail_film["note"]."<br>".
     "realisateur : ".$detail_film["realisateur"]?>

</p>

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
            foreach($castings as $casting){ ?>
                <tr>
                    <td><?=$casting["Titre du film"]?></td>
                    <td><?=$casting["Acteur"]?></td>
                    <td><?=$casting["role dans le film"]?></td>
    
                    
                </tr>
                <?php }?>
    </tbody>
</table>



<?php
$titre = "Detail d'un film ";
$titre_secondaire = "Detail du film ".$casting["Titre du film"];
$contenu = ob_get_clean();
require "view/template.php";
