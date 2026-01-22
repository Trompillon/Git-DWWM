<?php

$errors = [];

include 'regex.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <title>Regex</title>
</head>
<body>

    <form action="" method="post" id="form">
        <label for="user">Nom d'utilisateur</label>
        <input type="text" name="user" id="user" class="input"> Nom d'utilisateur entre 3 et 16 caractères
        <label for="mail">Email</label>
        <input type="email" name="mail" id="mail" class="input"> Format : prenom.nom@domaine.fr
        <label for="psw">Mot de passe</label>
        <input type="password" name="password" id="psw" class="input"> 8 caractères minimum, minuscule, majuscule, chiffre et caractère spécial obligatoire
        <button type="submit" id="submit">Submit</button>
    </form>

    <?php

    if (!empty($errors)) {
        foreach ($errors as $e) {
            echo "<p>$e</p>";
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<p>Toutes les données sont valides !</p>";
    }

?>
    
</body>
</html>