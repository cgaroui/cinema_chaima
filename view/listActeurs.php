<?php 

ob_start(); 

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
            foreach($requete_acteurs->fetchAll() as $acteur){ ?>
                <tr>
                    <td><?=$acteur["nom"]?></td>
                    <td><?=$acteur["prenom"]?></td>
                    <td><?=$acteur["sexe"]?></td>
                    <td><?=$acteur["date_naissance"]?></td>
                    
                </tr>
                <?php }?>
    </tbody>
</table>

<?php
$titre = "Liste des acteurs ";
$titre_secondaire = "Liste des ";
$contenu = ob_get_clean();
require "view/template.php";
