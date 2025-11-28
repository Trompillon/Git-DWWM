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

    <h1>Ajouter vos photos de chats !</h1>

    <form class="formAJout" action="ajout" method="POST">

        <input class="formInput" type="text" name="catName" id="catName" placeholder="nom du chat">

        <input class="formInput" type="text" name="description" id="description" placeholder="Faites nous une petite description de votre compagnon">

        <input class="formInput" type="file" name="catImage" id="catImage" accept="image/jpg, image/png, image/jpeg">

        <button type="submit" id="btn">Submit</button>

    </form>

    
</body>
</html>