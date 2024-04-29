
<?php
session_start();
?>

<form action="index.php?action=ajoutPersonne" method="post">
    <label>Nom</label>
    <input name="nom" id="nom" type="text" />

    <label>Prénom</label>
    <input name="prenom" id="prenom" type="text" />

    <label>Sexe</label>
    <input name="sexe" id="sexe" type="text" />

    <label>Date de naissance</label>
    <input name="date_naissance" id="date_naissance" type="date" />
    

    <label>profession</label>
 
    <input type="checkbox" name="profession[]" value="acteur" id="id_acteur" />
    <label for="id_acteur">Acteur</label>

    <input type="checkbox" name="profession[]" value="realisateur" id="id_realisateur" />
    <label for="id_realisateur">Réalisateur</label>

    <button type="submit" name="submit">Valider</button>
</form>
