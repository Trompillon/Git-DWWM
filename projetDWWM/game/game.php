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

if (isset($_POST['choice_id'])) {
    $choiceId = $_POST['choice_id'];

    // Récupérer le choix avec toutes les conditions
    $stmt = $pdo->prepare("
        SELECT to_story_id, gold_change, required_gold,
               required_class, required_mana, mana_change
        FROM choice
        WHERE id = ?
    ");
    $stmt->execute([$choiceId]);
    $choice = $stmt->fetch();

    if (!$choice) exit("Choix invalide.");

    // Récupérer le personnage
    $stmtChar = $pdo->prepare("SELECT * FROM characters WHERE user_id = ?");
    $stmtChar->execute([$_SESSION['user_id']]);
    $character = $stmtChar->fetch();

    // var_dump($character);

    // Vérifier classe
    if ($choice['required_class'] && $choice['required_class'] !== $character['class']) {
        exit("Votre classe ne permet pas ce choix.");
    }

    // Vérifier or/mana avant application
    if ($character['gold_pieces'] < $choice['required_gold']) {
        exit("Pas assez d'or pour ce choix.");
    }
    if ($character['mana_current'] < $choice['required_mana']) {
        exit("Pas assez de mana pour ce choix.");
    }

    // Appliquer conséquences
    $newGold = max(0, $character['gold_pieces'] + $choice['gold_change']);
    $newMana = max(0, $character['mana_current'] + $choice['mana_change']);

    $stmtUpdate = $pdo->prepare("UPDATE characters SET gold_pieces = ?, mana_current = ? WHERE id = ?");
    $stmtUpdate->execute([$newGold, $newMana, $character['id']]);

    // Mettre à jour le passage
    $_SESSION['current_passage_id'] = $choice['to_story_id'];

    header("Location: game.php");
    exit;

} else {
    $currentPassageId = $_SESSION['current_passage_id'] ?? 1;
}

// var_dump($_GET);
// die();

// 1. Récupérer le personnage lié au user connecté
$stmtChar = $pdo->prepare("SELECT * FROM characters WHERE user_id = ?");
$stmtChar->execute([$userId]);
$character = $stmtChar->fetch();

if (!$character) {
    die("Aucun personnage trouvé.");
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

    <div id="story">
    <?php if ($images): ?>
        <div class="story-img-wrapper">
            <img src="../img/<?= htmlspecialchars($images['img_url']) ?>" alt="Images du passage">
        </div>
    <?php endif; ?>

    <?= htmlspecialchars($passage['content']) ?>
</div>

    <div id="choices">
        <?php foreach ($choices as $choice): ?>

            <?php
            // Filtrer uniquement par classe
            if ($choice['required_class'] && $choice['required_class'] !== $character['class']) {
                continue;
            }

            $canTake = true;
            if ($choice['required_gold'] > 0 && $character['gold_pieces'] < $choice['required_gold']) {
                $canTake = false;
            }
            if ($choice['required_mana'] > 0 && $character['mana_current'] < $choice['required_mana']) {
                $canTake = false;
            }
            ?>

            <form method="POST">
                <input type="hidden" name="choice_id" value="<?= $choice['id'] ?>">
                <button type="submit"><?= htmlspecialchars($choice['choice']) ?></button>
                <?php if (!$canTake): ?>
                    <small>Vous n'avez pas assez de ressources pour ce choix.</small>
                <?php endif; ?>
            </form>

        <?php endforeach; ?>
    </div>

    <?php include '../footer.php'; ?>
    
</body>
</html>