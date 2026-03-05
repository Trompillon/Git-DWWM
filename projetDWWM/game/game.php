<?php
session_start();
require '../db.php';

// Active les erreurs pour voir s'il y a un souci SQL
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

define('BASE_URL', '/projetDWWM/');

/* =========================================
   1. RÉCUPÉRATION DU PERSONNAGE (SÉCURITÉ)
========================================= */
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: " . BASE_URL . "connexion/connexion.php");
    exit;
}

// On récupère le perso lié à l'user (Méthode ultra-fiable)
$stmtChar = $pdo->prepare("SELECT * FROM characters WHERE user_id = ?");
$stmtChar->execute([$userId]);
$character = $stmtChar->fetch();

if (!$character) {
    header("Location: " . BASE_URL . "game/choose_class.php");
    exit;
}

$charId = $character['id'];
$_SESSION['char_id'] = $charId; // On synchronise la session

/* =========================================
   2. TRAITEMENT DU CHOIX (POST)
========================================= */
if (isset($_POST['choice_id'])) {
    $choiceId = $_POST['choice_id'];

    $stmt = $pdo->prepare("SELECT * FROM choice WHERE id = ?");
    $stmt->execute([$choiceId]);
    $choice = $stmt->fetch();

    if ($choice) {
        // Vérification des conditions
        $canTake = true;
        if ($choice['required_class'] && $choice['required_class'] !== $character['class']) $canTake = false;
        if ($character['gold_pieces'] < $choice['required_gold']) $canTake = false;
        if ($character['mana_current'] < $choice['required_mana']) $canTake = false;

        if ($canTake) {
            // A. Mise à jour des Stats
            $newGold = max(0, $character['gold_pieces'] + $choice['gold_change']);
            $newMana = max(0, $character['mana_current'] + $choice['mana_change']);
            $newHp = max(0, $character['hp_current'] + $choice['hp_change']);

            $stmtUpdate = $pdo->prepare("UPDATE characters SET gold_pieces = ?, mana_current = ?, hp_current = ? WHERE id = ?");
            $stmtUpdate->execute([$newGold, $newMana, $newHp, $charId]);

            // B. Mise à jour de la Position
            $stmtSave = $pdo->prepare("UPDATE char_progress SET current_story_id = ?, updated_at = NOW() WHERE char_id = ?");
            $stmtSave->execute([$choice['to_story_id'], $charId]);

            // C. REDIRECTION (On recharge pour traiter l'arrivée au nouveau passage)
            header("Location: " . BASE_URL . "game/game.php");
            exit;
        }
    }
}

/* =========================================
   3. LOGIQUE D'AFFICHAGE ET OBJETS
========================================= */

// A. Récupérer la position actuelle
$stmtPos = $pdo->prepare("SELECT current_story_id FROM char_progress WHERE char_id = ?");
$stmtPos->execute([$charId]);
$progress = $stmtPos->fetch();
$currentPassageId = $progress ? $progress['current_story_id'] : 1;

// B. GESTION DES OBJETS (S'exécute à l'affichage du passage)
$stmtItems = $pdo->prepare("SELECT item_id, quantity FROM story_items WHERE story_id = ?");
$stmtItems->execute([$currentPassageId]);
$itemsInRoom = $stmtItems->fetchAll();

foreach ($itemsInRoom as $item) {
    $itemId = $item['item_id'];
    $qtyToAdd = $item['quantity'];

    // 1. On récupère le type de l'objet (pour savoir si on stacke ou pas)
    $stmtItemInfo = $pdo->prepare("SELECT item_type FROM items WHERE id = ?");
    $stmtItemInfo->execute([$itemId]);
    $itemInfo = $stmtItemInfo->fetch();
    
    if (!$itemInfo) continue;

    // 2. On regarde si l'objet est déjà dans l'inventaire
    $stmtCheck = $pdo->prepare("SELECT id, quantity FROM inventory WHERE char_id = ? AND item_id = ?");
    $stmtCheck->execute([$charId, $itemId]);
    $existing = $stmtCheck->fetch();

    if (!$existing) {
        // L'objet n'est pas là du tout -> On l'insère
        $pdo->prepare("INSERT INTO inventory (char_id, item_id, quantity, created_at) VALUES (?, ?, ?, NOW())")
            ->execute([$charId, $itemId, $qtyToAdd]);
    } else {
        // L'objet existe déjà ! 
        // SI c'est un consommable (type 3), on AUGMENTE la quantité
        if ((int)$itemInfo['item_type'] === 3) {
            $pdo->prepare("UPDATE inventory SET quantity = quantity + ? WHERE id = ?")
                ->execute([$qtyToAdd, $existing['id']]);
        }
        // Sinon (Arme/Armure), on ne fait rien car on l'a déjà.
    }
}

// C. Récupérer les données finales pour la page
$stmtPassage = $pdo->prepare("SELECT * FROM story WHERE id = ?");
$stmtPassage->execute([$currentPassageId]);
$passage = $stmtPassage->fetch();

$stmtChoices = $pdo->prepare("SELECT * FROM choice WHERE from_story_id = ?");
$stmtChoices->execute([$currentPassageId]);
$choices = $stmtChoices->fetchAll();

$stmtImages = $pdo->prepare("SELECT * FROM images WHERE story_id = ?");
$stmtImages->execute([$currentPassageId]);
$images = $stmtImages->fetch();

// On rafraîchit $character pour avoir les stats à jour dans le HUD
$stmtChar = $pdo->prepare("SELECT * FROM characters WHERE id = ?");
$stmtChar->execute([$charId]);
$character = $stmtChar->fetch();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>img/icon.png">
    <title>Game</title>
</head>
<body>

    <?php include __DIR__ . '/../components/header.php'; ?>

    <?php if ($character): ?>
        <div id="hud">
            <div class="bar health">
                <div class="fill" style="width: <?= ($character['hp_current'] / $character['hp_max']) * 100 ?>%;"></div>
                <span><?= $character['hp_current'] ?> / <?= $character['hp_max'] ?> PV</span>
            </div>

            <?php if ($character['class'] === 'Mage'): ?>
                <div class="bar mana">
                    <div class="fill" style="width: <?= ($character['mana_current'] / $character['mana_max']) * 100 ?>%;"></div>
                    <span><?= $character['mana_current'] ?> / <?= $character['mana_max'] ?> PM</span>
                </div>
            <?php endif; ?>

            <div class="gold">💰 <?= $character['gold_pieces'] ?></div>
        </div>
    <?php endif; ?>

    <div id="story">
        <?php if ($images): ?>
            <div class="story-img-wrapper">
                <img src="../img/<?= htmlspecialchars($images['img_url']) ?>" alt="Images du passage">
            </div>
        <?php endif; ?>

        <?php
            $text = $passage['content'];
            // Tags PNJ
            $text = preg_replace('/\[PNJF\](.*?)\[\/PNJF\]/s', '<span class="npc-friendly">$1</span>', $text);
            $text = preg_replace('/\[PNJE\](.*?)\[\/PNJE\]/s', '<span class="npc-enemy">$1</span>', $text);
            $text = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE);
            $text = str_replace(['&lt;span class=&quot;npc-friendly&quot;&gt;', '&lt;span class=&quot;npc-enemy&quot;&gt;', '&lt;/span&gt;'], 
                                ['<span class="npc-friendly">','<span class="npc-enemy">','</span>'], $text);
            echo nl2br($text);
        ?>
    </div>

    <div id="choices">
        <?php foreach ($choices as $choice): ?>
            <?php if ($choice['required_class'] && $choice['required_class'] !== $character['class']) continue; ?>

            <form method="POST">
                <input type="hidden" name="choice_id" value="<?= $choice['id'] ?>">
                <button type="submit" class="choice <?= $choice['required_class'] ? strtolower($choice['required_class']) : '' ?>">
                    <?= htmlspecialchars($choice['choice']) ?>
                </button>
            </form>
        <?php endforeach; ?>
    </div>

    <?php include __DIR__ . '/../components/footer.php'; ?>
    
</body>
</html>