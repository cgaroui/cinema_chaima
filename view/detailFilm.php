<?php
ob_start();
$castings= $requete_castingFilm->fetchAll();
$detail_film = $requete_detFilm->fetch();


?>
<img src="img/<?= htmlspecialchars($detail_film["titre"]) ?>" alt="Affiche du film " />
 

<p>
    <?php echo "Titre du film : ".$detail_film["titre"]."<br>".
     "Année de sortie : ".$detail_film["annee_sortie"]."<br>".
     "duree : ".$detail_film["duree"]."<br>".
     "note : ".$detail_film["note"]."<br>"."Réalisateur : "?>
     <a href="index.php?action=detailRealisateur&id=<?=$detail_film["id_realisateur"]?>"><?=$detail_film["realisateur"]?></a></p>
   
 </p>




<table>
    <thead>
        <tr>
            <th>Acteur </th>
            <th>Role </th>
            
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($castings as $casting){ ?>
                <tr>
                    <td><a href="index.php?action=detailActeur&id=<?=$casting["id_acteur"]?>"><?=$casting["Acteur"]?></a></td>
                    <td><?=$casting["role dans le film"]?></td>
                </tr>
                <?php }?>
    </tbody>
</table>



<?php
$titre = "Detail d'un film ";
$titre_secondaire = "Detail du film ".$detail_film["titre"];
$contenu = ob_get_clean();
require "view/template.php";



