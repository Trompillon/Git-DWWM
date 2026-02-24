<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar">
    <ul class="nav-left">
        <li><a href="index.php">Accueil</a></li>

        <?php if (isset($_SESSION['user_id'])) : ?>
            <li><a href="/projetDWWM/game/game.php">Continuer l'aventure</a></li>
            <li><a href="/projetDWWM/game/choose_class.php">Nouvelle aventure</a></li>
            <li><a href="/projetDWWM/deconnexion.php">Déconnexion</a></li>
        <?php else : ?>

            <li><a href="connexion.php">Se connecter</a></li>
        <?php endif; ?>

    </ul>

    <?php if (isset($_SESSION['user_id'])) : ?>

    <div class="nav-right">
        <a href="#" id="btnInventory" class="inventory-btn">
            <img src="/projetDWWM/img/backpack.png" alt="Icône sac à dos">
        </a>
    </div>

    <?php endif; ?>

</nav>

<!-- Modal inventaire -->
<div id="inventoryModal" class="inventory-modal" style="display:none;">
    <div id="inventoryContent" class="inventory-content">
        <!-- contenu injecté ici -->
    </div>
    <button id="closeInventory">Fermer</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const btnInventory = document.getElementById('btnInventory');
    const modal = document.getElementById('inventoryModal');
    const closeBtn = document.getElementById('closeInventory');
    const content = document.getElementById('inventoryContent');

    if (btnInventory) {
        btnInventory.addEventListener('click', function(e) {
            e.preventDefault();
            fetch('/projetDWWM/game/inventory.php')
                .then(res => res.text())
                .then(data => {
                    content.innerHTML = data;
                    modal.style.display = 'block';
                });
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
});
</script>