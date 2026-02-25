<?php
session_start();
require '../db.php';

// ini_set('display_errors', 1);
// error_reporting(E_ALL);


if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexion.php");
    exit;
}

// Définir $userId pour les requêtes
$userId = $_SESSION['user_id'];

    /* CHOIX */

if (isset($_POST['choice_id'])) {
    $choiceId = $_POST['choice_id'];

    // Récupérer le choix avec toutes les conditions
    $stmt = $pdo->prepare("
        SELECT to_story_id, gold_change, required_gold,
               required_class, required_mana, mana_change, hp_change
        FROM choice
        WHERE id = ?
    ");
    $stmt->execute([$choiceId]);
    $choice = $stmt->fetch();

    if (!$choice) {
        $error_msg = "Choix invalide.";
    }

    // Récupérer le personnage
    $stmtChar = $pdo->prepare("SELECT * FROM characters WHERE user_id = ?");
    $stmtChar->execute([$_SESSION['user_id']]);
    $character = $stmtChar->fetch();

    // var_dump($character);

    $canTake = true;

    if (!$canTake) {
    if ($choice['required_gold'] > 0 && $character['gold_pieces'] < $choice['required_gold']) {
        $error_msg_choice = "Pas assez d'or pour ce choix.";
    } elseif ($choice['required_mana'] > 0 && $character['mana_current'] < $choice['required_mana']) {
        $error_msg_choice = "Pas assez de mana pour ce choix.";
    } elseif ($choice['required_class'] && $choice['required_class'] !== $character['class']) {
        $error_msg_choice = "Votre classe ne permet pas ce choix.";
    }
}

    // Vérifier classe
    if ($choice['required_class'] && $choice['required_class'] !== $character['class']) {
        $canTake = false;
        $error_msg = "Votre classe ne permet pas ce choix.";
    }

    // Vérifier or/mana
    if ($character['gold_pieces'] < $choice['required_gold']) {
        $canTake = false;
        $error_msg = "Pas assez d'or pour ce choix.";
    }
    if ($character['mana_current'] < $choice['required_mana']) {
        $canTake = false;
        $error_msg = "Pas assez de mana pour ce choix.";
    }

    // Appliquer conséquences seulement si autorisé
    if ($canTake) {
        $newGold = max(0, $character['gold_pieces'] + $choice['gold_change']);
        $newMana = max(0, $character['mana_current'] + $choice['mana_change']);
        $newHp = max(0, $character['hp_current'] + $choice['hp_change']);

        $stmtUpdate = $pdo->prepare("UPDATE characters SET gold_pieces = ?, mana_current = ?, hp_current = ? WHERE id = ?");
        $stmtUpdate->execute([$newGold, $newMana, $newHp, $character['id']]);

        // Mettre à jour le passage
        $_SESSION['current_passage_id'] = $choice['to_story_id'];

        // Redirection vers la page de jeu
        header("Location: game.php");
        exit;
    }

} else {
    $currentPassageId = $_SESSION['current_passage_id'] ?? 1;
}

// var_dump($_GET);
// die();

// 1. Récupérer le personnage lié au user connecté
$stmtChar = $pdo->prepare("SELECT * FROM characters WHERE user_id = ?");
$stmtChar->execute([$userId]);
$character = $stmtChar->fetch();

// Si aucun personnage, rediriger vers choose_class.php
if (!$character) {
    header("Location: choose_class.php");
    exit;
}

$charId = $character['id'];


// 2. Récupérer les objets liés au passage actuel
$stmtItems = $pdo->prepare("SELECT item_id, quantity FROM story_items WHERE story_id = ?");
$stmtItems->execute([$currentPassageId]);
$itemsToAdd = $stmtItems->fetchAll();


// 3. Ajouter / mettre à jour l'inventaire
foreach ($itemsToAdd as $item) {

    $itemId   = $item['item_id'];
    $quantity = $item['quantity'];

    // Vérifier si l'objet existe déjà
    $stmtCheck = $pdo->prepare("SELECT id FROM inventory WHERE char_id = ? AND item_id = ?");
    $stmtCheck->execute([$charId, $itemId]);
    $existing = $stmtCheck->fetch();

    if ($existing) {

        // Si oui → on augmente la quantité
        $stmtUpdate = $pdo->prepare("
            UPDATE inventory
            SET quantity = quantity + ?
            WHERE char_id = ? AND item_id = ?
        ");
        $stmtUpdate->execute([$quantity, $charId, $itemId]);

    } else {

        // Sinon → on l'ajoute
        $stmtInsert = $pdo->prepare("
            INSERT INTO inventory (char_id, item_id, quantity)
            VALUES (?, ?, ?)
        ");
        $stmtInsert->execute([$charId, $itemId, $quantity]);
    }
}

$stmtPassage = $pdo->prepare("SELECT * FROM story WHERE id = ?");
$stmtPassage->execute([$currentPassageId]);
$passage = $stmtPassage->fetch();

$stmtChoices = $pdo->prepare("SELECT * FROM choice WHERE from_story_id = ?");
$stmtChoices->execute([$currentPassageId]);
$choices = $stmtChoices->fetchAll();

$stmtImages = $pdo->prepare("SELECT * FROM images WHERE story_id = ?");
$stmtImages->execute([$currentPassageId]);
$images = $stmtImages->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../img/icon.png">
    <title>Game</title>
</head>

<body>

    <?php include '../header.php'; ?>

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

            <div class="gold">
                💰 <?= $character['gold_pieces'] ?>
            </div>

        </div>

    <?php endif; ?>

    <?php if (!empty($error_msg)): ?>
        <div class="error-message"><?= htmlspecialchars($error_msg) ?></div>
    <?php endif; ?>

    <div id="story">
    <?php if ($images): ?>
        <div class="story-img-wrapper">
            <img src="../img/<?= htmlspecialchars($images['img_url']) ?>" alt="Images du passage">
        </div>
    <?php endif; ?>

    <?php
        $text = $passage['content'];

        // Transformer les tags PNJ en span
        $text = preg_replace('/\[PNJF\](.*?)\[\/PNJF\]/s', '<span class="npc-friendly">$1</span>', $text);
        $text = preg_replace('/\[PNJE\](.*?)\[\/PNJE\]/s', '<span class="npc-enemy">$1</span>', $text);

        // Échapper les autres caractères HTML
        $text = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE);

        // Mais remettre les spans non échappés
        $text = str_replace(['&lt;span class=&quot;npc-friendly&quot;&gt;', '&lt;span class=&quot;npc-enemy&quot;&gt;', '&lt;/span&gt;'], 
                            ['<span class="npc-friendly">','<span class="npc-enemy">','</span>'], 
                            $text);

        echo $text;
    ?>

    </div>

    <div id="choices">
        <?php foreach ($choices as $choice): ?>

        <?php
        // Filtrer uniquement par classe
        if ($choice['required_class'] && $choice['required_class'] !== $character['class']) {
            continue;
        }

        // Initialiser
        $canTake = true;
        $error_msg_choice = "";

        // Vérifier conditions
        if ($choice['required_gold'] > 0 && $character['gold_pieces'] < $choice['required_gold']) {
            $canTake = false;
            $error_msg_choice = "Pas assez d'or pour ce choix.";
        } elseif ($choice['required_mana'] > 0 && $character['mana_current'] < $choice['required_mana']) {
            $canTake = false;
            $error_msg_choice = "Pas assez de mana pour ce choix.";
        } elseif ($choice['required_class'] && $choice['required_class'] !== $character['class']) {
            $canTake = false;
            $error_msg_choice = "Votre classe ne permet pas ce choix.";
        }
        ?>

        <form method="POST">
            <input type="hidden" name="choice_id" value="<?= $choice['id'] ?>">
            <button type="submit" class="choice <?= $choice['required_class'] ? strtolower($choice['required_class']) : '' ?>" <?= !$canTake ? 'disabled' : '' ?>>
            <?= htmlspecialchars($choice['choice']) ?>
            </button>
        </form>

        <?php if (!$canTake && !empty($error_msg_choice)): ?>
            <div class="error-message"><?= htmlspecialchars($error_msg_choice) ?></div>
        <?php endif; ?>

        <?php endforeach; ?>
    </div>

    <?php include '../footer.php'; ?>
    
</body>
</html>