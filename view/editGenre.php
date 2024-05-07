<?php


session_start();
?>

<form action="index.php?action=editGenre" method="post">
    <!-- Champ caché pour passer l'ID du genre -->
    <input type="hidden" name="id_genre" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>" />

    <label>Nouveau nom du genre :</label>
    <input name="nom_genre" id="nom_genre" type="text" required  /> <!-- required pour Champ obligatoire -->

    <button type="submit" name="submit">Valider</button>
</form>




