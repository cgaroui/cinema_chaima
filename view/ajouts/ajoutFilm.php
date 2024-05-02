

<?php
session_start();
?>

<form action="index.php?action=ajoutFilm" method="post" > 
    <label for="titre">Titre du film</label>
    <input type="text" name="titre" id="titre"  /> 

    <label for="annee_sortie">Année de sortie</label>
    <input type="number" name="annee_sortie" id="annee_sortie" /> 

    <label for="duree">Durée </label>
    <input type="number" name="duree" id="duree" /> 

    <label for="note">Note</label>
    <input type="number" name="note" id="note" min="0" max="5"  /> 

    <label for="affiche">Affiche du film</label>
    <input type="file" name="affiche" id="affiche" accept="image/*" /> 

    <label for="id_realisateur">Identifiant du réalisateur</label>
    <input type="number" name="id_realisateur" id="id_realisateur" /> 

    <button type="submit" name="submit">Valider</button>
</form>
