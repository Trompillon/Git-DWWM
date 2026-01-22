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

    <form action="insert.php" enctype="multipart/form-data" method="post">

        <input class="formInput" type="text" name="catName" id="catName" placeholder="nom du chat">

        <input class="formInput" type="text" name="catDescription" id="catDescription" placeholder="Faites nous une petite description de votre compagnon">

        <input class="formInput" type="file" name="img">

        <button type="submit" id="btn">Submit</button>

    </form>
    
</body>
</html>