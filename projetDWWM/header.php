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
                <li><a href="game/game.php">Continuer l'aventure</a></li>
                <a href="#" id="btnInventaire"><img src="img/backpack.png" alt="icone sac à dos"></a>
                <li><a href="game/game.php?action=new">Nouvelle aventure</a></li>
                <li><a href="deconnexion.php">Déconnexion</a></li>
                <?php

        ?>

                <div id="inventaireModal" style="display:none;">
                    <?php foreach($inventaire as $item): ?>
                        <p><?= $item['nom'] ?> x<?= $item['quantité'] ?></p>
                    <?php endforeach; ?>
                </div>

                <script>
                    document.getElementById('btnInventaire').addEventListener('click', function() {
                        const modal = document.getElementById('inventaireModal');
                        modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
                    });
                </script>

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