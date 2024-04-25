<?php
ob_start();
$realisateur = $requete_realisateur->fetch();
$films = $requete_realisateurFilms->fetchAll();
 ?>
<p>
    <?= "Realisateur : ".$realisateur["Realisateur"]."<br>"?>
    <?= "Date de naissance : ".$realisateur["date_naissance"]."<br>"?>
    <?= "Age : ".$realisateur["Age"]." ans"?>

</p>



<table>
    <thead>     
        <tr>          
            <th>Titre du film </th>
            <th>Année de sortie </th>  
        </tr>
    </thead>
    <tbody>
        <?php
             foreach($films as $film){ ?>
                <tr>
                    <td><?=$film["titre"]?></td>
                    <td><?=$film["annee_sortie"]?></td>
                </tr>
                <?php }?>
    </tbody>
</table>

<?php
$titre = "Detail d'un Realisateur";
$titre_secondaire ="Films de ".$realisateur["Realisateur"] ;
$contenu = ob_get_clean();
require "view/template.php";
