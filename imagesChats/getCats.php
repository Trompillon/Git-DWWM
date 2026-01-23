<?php

session_start();
require 'db.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Partager vos photos de chats</title>
</head>
<body>
    
    <?php include 'header.php'; ?>

    <div class="form-wrapper">
        <form class="formulaire" action="insert.php" enctype="multipart/form-data" method="post">
            <h1>Ajouter vos photos de chats !</h1>

            <label for="catName">Nom du chat</label>
            <input class="formInput" type="text" name="catName" id="catName" placeholder="Nom du chat" required>

            <label for="catDescription">Description</label>
            <textarea class="formInput" name="catDescription" id="catDescription" placeholder="Faites-nous une petite description" required></textarea>

            <label for="imagePath">Image</label>
            <input class="formInput" type="file" name="imagePath" id="imagePath" accept=".jpg, .png, .jpeg, .webp" required>

            <label for="catColor">Choississez une couleur !</label>
            <select name="catColor" id="catColor">
                <option value="#ff6b6b">Rouge</option>
                <option value="#4dabf7">Bleu</option>
                <option value="#69db7c">Vert</option>
                <option value="#ffd43b">Jaune</option>
                <option value="#845ef7">Violet</option>
            </select>

            <button type="submit" id="btn">Ajouter</button>
        </form>
    </div>

    
</body>
</html>