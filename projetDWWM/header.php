<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar">
    <ul class="nav-left">
        <li><a href="/projetDWWM/index.php">Accueil</a></li>

        <?php if (isset($_SESSION['user_id'])) : ?>
            <li><a href="/projetDWWM/game/game.php">Continuer l'aventure</a></li>
            <li><a href="/projetDWWM/game/choose_class.php">Nouvelle aventure</a></li>
            <li><a href="/projetDWWM/deconnexion.php">Déconnexion</a></li>
        <?php else : ?>

            <li><a href="connexion.php">Se connecter</a></li>
            <li><a href="inscription.php">S'inscrire</a></li>
        <?php endif; ?>

    </ul>

    <?php if (isset($_SESSION['user_id'])) : ?>

    <div class="nav-right">
        <?php if ($character['class'] === 'Mage'): ?>
            <a href="#"id="btnGrimoire" class="grimoire-btn <?= strtolower($character['class']) ?>">
                <img src="/projetDWWM/img/grimoire.png" alt="Icône de Grimoire">
            </a>
        <?php endif; ?>
        <a href="#" id="btnInventory" class="inventory-btn">
            <img src="/projetDWWM/img/backpack.png" alt="Icône sac à dos">
        </a>
    </div>

    <?php endif; ?>

</nav>

<!-- Modal inventaire -->
<div id="inventoryModal" class="inventory-modal">
    <div class="inventory-content">
        <div id="inventoryContent">
            <!-- contenu injecté ici -->
        </div>
        <button id="closeInventory">Fermer</button>
    </div>
</div>

<!-- Modal grimoire -->
<div id="grimoireModal" class="inventory-modal grimoire-modal">
    <div class="inventory-content">
        <div id="grimoireContent">
            <!-- contenu du grimoire injecté ici -->
        </div>
        <button id="closeGrimoire">Fermer</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- INVENTAIRE ---
    const btnInventory = document.getElementById('btnInventory');
    const inventoryModal = document.getElementById('inventoryModal');
    const closeInventory = document.getElementById('closeInventory');
    const inventoryContent = document.getElementById('inventoryContent');

    if (btnInventory) {
        btnInventory.addEventListener('click', function(e) {
            e.preventDefault();
            fetch('/projetDWWM/game/inventory.php')
                .then(res => res.text())
                .then(data => {
                    inventoryContent.innerHTML = data;
                    inventoryModal.style.display = 'flex';
                });
        });
    }

    if (closeInventory) {
        closeInventory.addEventListener('click', function() {
            inventoryModal.style.display = 'none';
        });
    }

    inventoryModal.addEventListener('click', function(e) {
        if (e.target === inventoryModal) inventoryModal.style.display = 'none';
    });

    // --- GRIMOIRE ---
    const btnGrimoire = document.getElementById('btnGrimoire');
    const grimoireModal = document.getElementById('grimoireModal');
    const closeGrimoire = document.getElementById('closeGrimoire');
    const grimoireContent = document.getElementById('grimoireContent');

    if (btnGrimoire) {
        btnGrimoire.addEventListener('click', function(e) {
            e.preventDefault();
            fetch('/projetDWWM/game/grimoire.php') // créer ce fichier côté serveur
                .then(res => res.text())
                .then(data => {
                    grimoireContent.innerHTML = data;
                    grimoireModal.style.display = 'flex';
                });
        });
    }

    if (closeGrimoire) {
        closeGrimoire.addEventListener('click', function() {
            grimoireModal.style.display = 'none';
        });
    }

    grimoireModal.addEventListener('click', function(e) {
        if (e.target === grimoireModal) grimoireModal.style.display = 'none';
    });
});
</script>