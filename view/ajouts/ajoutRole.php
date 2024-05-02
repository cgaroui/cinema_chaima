<?php

session_start();
?>

<form action="index.php?action=ajoutGenre" method="post">
    <label>Nom Role :</label>
    <input name="nom_genre" id="id_genre" type="text" />

    <button type="submit" name="submit">Valider</button>


</form>

<?php
