<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <?php
            if (isset($_SESSION['user_id'])) {
                // Menu pour utilisateur connecté
                ?>
                <li><a href="continue.php">Continuer l'aventure</a></li>
                <li><a href="newGame.php">Nouvelle aventure</a></li>
                <li><a href="deconnexion.php">Déconnexion</a></li>
                <?php

            } else {
                // Menu pour utilisateur non connecté
                ?>
                <li><a href="connexion.php">Se connecter</a></li>
                <?php
            }
            ?>
    </ul>
</nav>