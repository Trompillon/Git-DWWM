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

    <h1>Vos photos de chats !</h1>

    <main>

    <div class="gallery">
        <?php
        // Récupération des chats depuis la BDD
        $stmt = $pdo->query("SELECT cats.*, users.login FROM cats JOIN users ON cats.user_id = users.id ORDER BY cats.created_at DESC");

        while ($cat = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $color = !empty($cat['catColor']) ? $cat['catColor'] : '#333';

        echo '<div class="cat-card">';
        echo '<img src="uploadCats/' . htmlspecialchars($cat['imagePath']) . '" alt="Chat">';
        echo '<p class="cat-name" style="color: ' . htmlspecialchars($color) . ';">🐾 ' . htmlspecialchars($cat['catName']) . ' 🐾</p>';
        echo '<p class="cat-description">' . htmlspecialchars($cat['catDescription']) . '</p>';
        echo '<p class="cat-user">Posté par : ' . htmlspecialchars($cat['login']) . '</p>';
        echo '</div>';
        }
        ?>
    </div>

    </main>


</body>
</html>