<?php 

ob_start(); 
$realisateurs =$requete_listRealisateurs->fetchAll() ;
?>

<table>
    <thead>
        <tr>
            <th>NOM </th>
            <th>Prenom</th>
            <th>Sexe</th>
            <th>Date de Naissance</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($realisateurs as $acteur){ ?>
                <tr>
                    <td><a href="index.php?detailRealisateur&id=<?= $acteur["nom"]?>"><?=$acteur["nom"]?></a></td>
                    <td><a href="index.php?detailRealisateur&id=<?= $acteur["nom"]?>"><?=$acteur["prenom"]?></td>
                    <td><?=$acteur["sexe"]?></td>
                    <td><?=$acteur["date_naissance"]?></td>
                    
                </tr>
                <?php }?>
    </tbody>
</table>

<?php
$titre = "Liste des Realisateurs ";
$titre_secondaire = "Liste des Realisateurs";
$contenu = ob_get_clean();
require "view/template.php";
