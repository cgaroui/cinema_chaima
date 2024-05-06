<?php
ob_start();
$genres = $requete_genres->fetchAll();
?>

<table>
    <thead>
        <tr>
            <th>Nom du Genre </th>
            <th>Actions</th> <!-- Nouvelle colonne pour les actions -->
        </tr>
    </thead>

    <tbody>
        <?php
        foreach($genres as $genre){?>

            <tr>
                <td><a href="index.php?action=detailGenre&id=<?= $genre["id_genre"] ?>"><?= $genre["nom_genre"] ?></a></td>
                <td>
                    <!-- Formulaire pour supprimer le genre -->
                    <form method="POST" action="index.php?action=supprimerGenre" style="display: inline;">
                        <!-- Champ caché pour l'identifiant du genre -->
                        <input type="hidden" name="id_genre" value="<?= htmlspecialchars($genre["id_genre"]) ?>" />
                        <!-- Bouton de suppression -->
                        <input type="submit" value="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce genre ?');" />
                    </form>
                </td>
                <td>
                <!-- Lien pour rediriger vers la page d'édition -->
                <a href="index.php?action=editGenre&id=<?= $genre['id_genre'] ?>">Editer</a>
                
                </td>            
            </tr>
        <?php }?>
    
    </tbody>
</table>
<?php
$titre = "Liste des Genres ";
$titre_secondaire = "Liste des Genres ";
$contenu = ob_get_clean();
require "view/template.php";


