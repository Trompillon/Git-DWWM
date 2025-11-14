<?php
session_start();
require 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopFilms - Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <?php include 'navbar.php'; ?>

    <main>
        <h1>Bienvenue sur TopFilms</h1>
        <p>Découvrez et gérez vos films préférés !</p>
        
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<p><a href="films.php">Voir votre liste de films</a></p>';
        } else {
            echo '<p>Pour gérer vos films, <a href="connexion.php">connectez-vous</a> ou <a href="inscription.php">inscrivez-vous</a>.</p>';
        }
        ?>

    </main>
</body>
</html>

