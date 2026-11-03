<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? "") ?></title>
</head>
<body>
    <h2>Bienvenue dans la mini-librairie</h2>
    <p><?= htmlspecialchars($data["nomLibrairie"] ?? ""); ?></p>
    <?php foreach($data["livres"] ?? [] as $livre): ?>
            <p><?= htmlspecialchars($livre["auteur"] ??"ahhhhhh"); ?></p>
    <?php endforeach?>

    <a href="/catalogue?genre=Fantasy">Fantasy</a>
    <a href="/catalogue?genre=Aventure">Aventure</a>
    <a href="/catalogue?genre=Polar">Polar</a>
</body>
</html>