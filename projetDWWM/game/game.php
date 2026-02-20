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

// Passage actuel : soit nouveau, soit envoyé par le choix
if (isset($_POST['choice_id'])) {
    $choiceId = $_POST['choice_id'];

    $stmt = $pdo->prepare("SELECT to_story_id FROM choice WHERE id = ?");
    $stmt->execute([$choiceId]);
    $target = $stmt->fetch();

    $currentPassageId = $target['to_story_id'];

    // On met à jour la session pour que le passage courant reste enregistré
    $_SESSION['current_passage_id'] = $currentPassageId;

} else {
    // Si on a déjà une session, on prend ce passage
    $currentPassageId = $_SESSION['current_passage_id'] ?? 1;
}

var_dump($_GET);
die();

// 1. Récupérer le personnage lié au user connecté
$stmtChar = $pdo->prepare("SELECT id FROM characters WHERE user_id = ?");
$stmtChar->execute([$userId]);
$char = $stmtChar->fetch();

if (!$char) {
    die("Aucun personnage trouvé.");
}

$charId = $char['id'];


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
    <script src="../script.js" defer></script>
    <link rel="shortcut icon" href="../img/icon.png">
    <title>Game</title>
</head>

<body>

    <?php include '../header.php'; ?>

    <?php if ($images): ?>
        <img src="../img/<?= htmlspecialchars($images['img_url']) ?>" alt="Images du passage">
    <?php endif; ?>

    <div id="story">
        <?= htmlspecialchars($passage['content']) ?>
    </div>

    <div id="choices">
        <?php foreach($choices as $choice): ?>
            <form method="POST">
                <input type="hidden" name="choice_id" value="<?= $choice['id'] ?>">
                <button type="submit"><?= htmlspecialchars($choice['choice']) ?></button>
            </form>
        <?php endforeach; ?>
    </div>

    
</body>
</html>