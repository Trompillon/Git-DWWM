<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    exit("Accès refusé");
}

require '../db.php';

// var_dump($charId);
// die();

$userId = $_SESSION['user_id'];

// Récupérer le personnage du user
$stmtChar = $pdo->prepare("SELECT id FROM characters WHERE user_id = ?");
$stmtChar->execute([$userId]);
$char = $stmtChar->fetch();

if (!$char) {
    exit("Aucun personnage trouvé.");
}

$charId = $char['id'];

$sql = "
    SELECT items.name, items.description, inventory.quantity
    FROM inventory
    JOIN items ON inventory.item_id = items.id
    WHERE inventory.char_id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$charId]);
$items = $stmt->fetchAll();

// var_dump($items); exit;

if (empty($items)) {
    echo "<p>Votre inventaire est vide.</p>";
    exit;
}

echo "<h3>Inventaire</h3>";

foreach ($items as $item) {
    echo "<p><strong>" . htmlspecialchars($item['name']) . "</strong> x" . 
         intval($item['quantity']) . "<br>";
    echo "<small>" . htmlspecialchars($item['description']) . "</small></p>";
}