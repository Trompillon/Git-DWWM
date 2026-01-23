<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<nav>
    <ul>
        <li class="logo">
        <img src="img/logo-catpix.png" alt="Catpix Logo" class="logo-img">
        <span class="logo-text">CatPix, le site des chats sympas</span>
        </li>
        <li><a href="index.php">Accueil</a></li>
        <?php
            if (isset($_SESSION['user_id'])) {
                // Menu pour utilisateur connecté
                ?>
                <li><a href="getCats.php">Ajouter un chat</a></li>
                <li><a href="deconnexion.php">Déconnexion</a></li>
                <li class="user">Bonjour, <?= htmlspecialchars($_SESSION['user_login']) ?></li>
                <?php

            } else {
                // Menu pour utilisateur non connecté
                ?>
                <li><a href="connexion.php">Se connecter</a></li>
                <li><a href="inscription.php">S’inscrire</a></li>
                <?php
            }
            ?>
    </ul>
</nav>