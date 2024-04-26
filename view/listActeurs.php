<?php 

ob_start(); 
$acteurs = $requete_acteurs->fetchAll();
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
            foreach($acteurs as $acteur){ ?>
                <tr>

                    <td><a href="index.php?detailActeur&id=<?= $acteur["nom"]?>"><?=$acteur["nom"]?></a></td>
                    <td><a href="index.php?detailActeur&id=<?= $acteur["nom"]?>"><?=$acteur["prenom"]?></td>
                    <td><?=$acteur["sexe"]?></td>
                    <td><?=$acteur["date_naissance"]?></td>
                    
                </tr>
                <?php }?>
    </tbody>
</table>

<?php
$titre = "Liste des acteurs ";
$titre_secondaire = "Liste des Acteurs";
$contenu = ob_get_clean();
require "view/template.php";
