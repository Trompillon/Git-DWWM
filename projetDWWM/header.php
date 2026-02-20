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
                <li><a href="/projetDWWM/game/game.php">Continuer l'aventure</a></li>
                <a href="#" id="btnInventory"><img src="/projetDWWM/img/backpack.png" alt="icone sac à dos"></a>
                <li><a href="/projetDWWM/game/choose_class.php">Nouvelle aventure</a></li>
                <li><a href="/projetDWWM/deconnexion.php">Déconnexion</a></li>
                <?php

        ?>

                <div id="inventoryModal" style="display:none;">
                    <div id="inventoryContent">
                        <!-- contenu injecté ici -->
                    </div>
                    <button id="closeInventory">Fermer</button>
                </div>

                <script>
                    document.getElementById('btnInventory').onclick = function() {

                    fetch('/projetDWWM/game/inventory.php')
                        .then(function(response) {
                            return response.text();
                        })
                        .then(function(data) {
                            document.getElementById('inventoryContent').innerHTML = data;
                            document.getElementById('inventoryModal').style.display = 'block';
                        });
                    };

                    document.getElementById('closeInventory').onclick = function() {
                    document.getElementById('inventoryModal').style.display = 'none';
                    };
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