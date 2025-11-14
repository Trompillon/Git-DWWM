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
                <li><a href="films.php">Films</a></li>
                <li><a href="favoris.php">Mes favoris</a></li>
                <li class="deco"><a href="deconnexion.php">Déconnexion</a></li>
                <li>Bonjour, <?= htmlspecialchars($_SESSION['user_login']) ?></li>
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
