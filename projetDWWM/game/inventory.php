<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    exit("Accès refusé");
}

require_once __DIR__ . '/../db.php';

$userId = $_SESSION['user_id'];

// Récupérer le personnage du user
$stmtChar = $pdo->prepare("SELECT id FROM characters WHERE user_id = ?");
$stmtChar->execute([$userId]);
$char = $stmtChar->fetch();

if (!$char) {
    exit("Aucun personnage trouvé.");
}

$charId = $char['id'];

// var_dump($charId);
// die();

$sql = "
    SELECT items.name, items.description, inventory.quantity
    FROM inventory
    JOIN items ON inventory.item_id = items.id
    WHERE inventory.char_id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$charId]);
$items = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT gold_pieces FROM characters WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$character = $stmt->fetch();

// var_dump($items); exit;

?>

<h3 class="inventory-title">Inventaire</h3>

<?php if (!empty($items)): ?>
    <?php foreach ($items as $item): ?>
        <div class="inventory-item">
            <div class="inventory-item-header">
                <span class="item-name"><?= htmlspecialchars($item['name']) ?></span>
                <span class="item-quantity">x<?= intval($item['quantity']) ?></span>
            </div>
            <div class="inventory-item-description">
                <?= htmlspecialchars($item['description']) ?>
            </div>
        </div>
    <?php endforeach; ?>
    <p class="inventory-gold">Or : <?= intval($character['gold_pieces']) ?> 🪙</p>
<?php else: ?>
    <p>Votre inventaire est vide.</p>
<?php endif; ?>