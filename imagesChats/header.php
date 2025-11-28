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
                <li><a href="getCats.php">Films</a></li>

                <?php

            } else {
                // Menu pour utilisateur non connecté
                ?>
                <li><a href="connection.php">Se connecter</a></li>
                <li><a href="inscription.php">S’inscrire</a></li>
                <?php
            }
            ?>
    </ul>
</nav>