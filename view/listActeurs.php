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

                    <td><a href="index.php?action=detailActeur&id=<?= $acteur["id_acteur"]?>"><?=$acteur["nom"]?></a></td>
                    <td><a href="index.php?action=detailActeur&id=<?= $acteur["id_acteur"]?>"><?=$acteur["prenom"]?></td>
                    <td><?=$acteur["sexe"]?></td>
                    <td><?=$acteur["date_naissance"]?></td>
                    <td>
                    <!-- Formulaire pour supprimer l'acteur' -->
                    <form method="POST" action="index.php?action=supprimerActeur" style="display: inline;">
                        <!-- Champ caché pour l'identifiant de l'acteur -->
                        <input type="hidden" name="id_acteur" value="<?= htmlspecialchars($acteur["id_acteur"]) ?>" />
                        <!-- Bouton de suppression -->
                        <input type="submit" value="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cet acteur ?');" />
                    </form>
                </td>
                    
                </tr>
                <?php }?>
    </tbody>
</table>

<?php
$titre = "Liste des acteurs ";
$titre_secondaire = "Liste des Acteurs";
$contenu = ob_get_clean();
require "view/template.php";
