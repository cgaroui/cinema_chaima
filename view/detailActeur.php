<?php
ob_start();
$Acteur = $requete_detailActeur->fetch();
$films = $requete_acteurFilms->fetchAll();
 ?>

<p>
    <?php echo "Acteur : ".$Acteur["Acteur"]."<br>".
     "Date de naissance : ".$Acteur["date_naissance"]."<br>".
     "Sexe : ".$Acteur["sexe"]."<br>".
     "Age : ".$Acteur["age"]." ans"?>

</p>



<table>
    <thead>     
        <tr>          
            <th>Titre du film </th>
            <th>Année de sortie </th>  
            <th>Role incarné </th>  

        </tr>
    </thead>
    <tbody>
        <?php
             foreach($films as $film){ ?>
                <tr>
                    <td><a href="index.php?action=detailFilm&id=<?=$film["id_film"]?>"><?=$film["titre"]?></a></td>
                    <td><?=$film["annee_sortie"]?></td>
                    <td><?=$film["Role"]?></td>
                </tr>
                <?php }?>
    </tbody>
</table>

<?php
$titre = "Detail d'un acteur";
$titre_secondaire ="Films de ".$Acteur["Acteur"] ;
$contenu = ob_get_clean();
require "view/template.php";
