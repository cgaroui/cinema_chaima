<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$titre?></title>

</head>
<body>
    <nav>
        <div id="wrapper" class="uk-container uk-container-expand">
            <main>
                <div id="contenu">
                    <h1 class="uk-heading-divider">PDO CINEMA</h1>
                    <h2 class="uk-heading-bullet"><?= $titre_secondaire ?></h2>
                    <?= $contenu ?>

                </div>
            </main>

        </div>
    </nav>
   
</body>
</html>