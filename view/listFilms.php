<?php 

ob_start(); 

?>
<link rel="stylesheet" href="css/listFilms.css">

<p >il y a <?= $requete->rowCount() ?> films</p>       <!--  la fonction rowCount() calcule le nmbre de ligne (ici car on affiche 1 film par ligne ) -->

<table class="listFilms">
    <thead>
        <tr>
            <th>Affiche</th>
            <th>Titre </th>
            <th>ANNEE SORTIE</th>
            <th>Actions</th> <!-- Nouvelle colonne pour les actions -->
        </tr>
    </thead>
    <tbody>
        <?php
        //affichage plusieur lignes (avec fetchAll) en indiquant pour chaque ligne le titre et l'année de sortie du film concerné 
            foreach($requete->fetchAll() as $film){ ?>
                <tr>
                    <td>
                        <?php
                        // Utiliser le titre du film comme nom de fichier pour l'image d'affiche
                        $chemin_affiche = "img/" . $film["titre"] . ".jpg";
                        ?>
                        <img src="<?= htmlspecialchars($chemin_affiche) ?>" alt="Affiche du film <?= htmlspecialchars($film["titre"]) ?>" />
                    </td>
                    <td><a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>"><?=$film["titre"]?></a></td>
                    <td><?=$film["annee_sortie"]?></td>
                    <td>
                    <!-- Formulaire pour supprimer le film -->
                    <form method="POST" action="index.php?action=supprimerFilm" style="display: inline;">
                        <!-- Champ caché pour l'identifiant du film -->
                        <input type="hidden" name="id_film" value="<?= htmlspecialchars($film["id_film"]) ?>" />
                        <!-- Bouton de suppression -->
                        <input type="submit" value="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce film ?');" />
                    </form>
                </td>
                </tr>
                <?php }?>
    </tbody>
</table>

<?php
$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require "view/template.php";
