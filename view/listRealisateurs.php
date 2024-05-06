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
            foreach($realisateurs as $realisateur){ ?>
                <tr>
                    <td><a href="index.php?action=detailRealisateur&id=<?= $realisateur["id_realisateur"]?>"><?=$realisateur["nom"]?></a></td>
                    <td><a href="index.php?action=detailRealisateur&id=<?= $realisateur["id_realisateur"]?>"><?=$realisateur["prenom"]?></td>
                    <td><?=$realisateur["sexe"]?></td>
                    <td><?=$realisateur["date_naissance"]?></td>
                    <td>
                    <!-- Formulaire pour supprimer realisateur -->
                    <form method="POST" action="index.php?action=supprimerRealisateur" style="display: inline;">
                        <!-- Champ caché pour l'identifiant du realisateur -->
                        <input type="hidden" name="id_realisateur" value="<?= htmlspecialchars($realisateur["id_realisateur"]) ?>" />
                        <!-- Bouton de suppression -->
                        <input type="submit" value="Supprimer" onclick="return confirm('la suppression de ce realisateur induit la supression de ses films Voulez-vous vraiment supprimer ce realisateur ?');" />
                    </form>
                    </td>
                    
                </tr>
                <?php }?>
    </tbody>
</table>

<?php
$titre = "Liste des Realisateurs ";
$titre_secondaire = "Liste des Realisateurs";
$contenu = ob_get_clean();
require "view/template.php";



