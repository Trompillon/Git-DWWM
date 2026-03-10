<?php
session_start();

require_once __DIR__ . '/../db.php';

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

if (!isset($_SESSION['user_id']) || !isset($_POST['item_id'])) {
    echo json_encode(['success' => false, 'message' => 'Action non autorisée']);
    exit;
}

$userId = $_SESSION['user_id'];
$itemId = intval($_POST['item_id']);

// 1. Récupérer le perso et l'item
$stmt = $pdo->prepare("
    SELECT 
        characters.id, 
        characters.hp_current, 
        characters.hp_max, 
        characters.mana_current, 
        characters.mana_max, 
        items.heal_hp, 
        items.heal_mana, 
        inventory.quantity 
    FROM characters
    JOIN inventory ON characters.id = inventory.char_id
    JOIN items ON inventory.item_id = items.id
    WHERE characters.user_id = ? AND items.id = ?
");

$stmt->execute([$userId, $itemId]);
$data = $stmt->fetch();

if (!$data || $data['quantity'] <= 0) {
    echo json_encode(['success' => false, 'message' => 'Objet introuvable']);
    exit;
}

// 2. Calculer les nouveaux totaux (sans dépasser le max)
$newHp = min($data['hp_max'], $data['hp_current'] + $data['heal_hp']);
$newMana = min($data['mana_max'], $data['mana_current'] + $data['heal_mana']);

// 3. Update BDD : On soigne le perso ET on réduit l'inventaire
$pdo->beginTransaction();
try {
    // Update perso
    // Dans use_item.php
    $updateChar = $pdo->prepare("UPDATE characters SET hp_current = ?, mana_current = ? WHERE id = ?");
    $updateChar->execute([$newHp, $newMana, $data['id']]);

    // Update inventaire
    if ($data['quantity'] > 1) {
        $updateInv = $pdo->prepare("UPDATE inventory SET quantity = quantity - 1 WHERE char_id = ? AND item_id = ?");
        $updateInv->execute([$data['id'], $itemId]);
    } else {
        $deleteInv = $pdo->prepare("DELETE FROM inventory WHERE char_id = ? AND item_id = ?");
        $deleteInv->execute([$data['id'], $itemId]);
    }

    $pdo->commit();
    echo json_encode([
        'success' => true, 
        'newHp' => $newHp, 
        'newMana' => $newMana, 
        'remaining' => $data['quantity'] - 1
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Erreur BDD']);
}