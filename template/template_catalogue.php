
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? "" ?></title>
</head>
<body>
    <main>
        <h1><?= $data["nomLibrairie"] ?? "" ?></h1>
        <!-- Test si la liste de livres est vide -->
        <?php if(empty($data["livres"])): ?>
            <p>Aucun livre à afficher</p>
        <?php endif ?>
        <!-- Boucle pour afficher les livres -->
        <?php foreach ($data["livres"] ?? [] as $livre) :?>
            <h2><?= $livre["titre"] ?></h2>
            <p><?= $livre["auteur"] ?></p>
            <p><?= $livre["genre"] ?></p>
        <?php endforeach ?>
    </main>

</body>
</html>