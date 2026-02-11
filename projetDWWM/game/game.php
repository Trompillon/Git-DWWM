<?php
session_start();
require '../db.php';

// ini_set('display_errors', 1);
// error_reporting(E_ALL);


if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexion.php");
    exit;
}

// Passage actuel : soit nouveau, soit envoyé par le choix
if (isset($_POST['choice_id'])) {
    $choiceId = $_POST['choice_id'];

    // On récupère le passage cible de ce choix
    $stmt = $pdo->prepare("SELECT to_story_id FROM choice WHERE id = ?");
    $stmt->execute([$choiceId]);
    $target = $stmt->fetch();

    $currentPassageId = $target['to_story_id'];
} else {
    // Début de l'histoire
    $currentPassageId = 1;
}

$stmtPassage = $pdo->prepare("SELECT * FROM story WHERE id = ?");
$stmtPassage->execute([$currentPassageId]);
$passage = $stmtPassage->fetch();

$stmtChoices = $pdo->prepare("SELECT * FROM choice WHERE from_story_id = ?");
$stmtChoices->execute([$currentPassageId]);
$choices = $stmtChoices->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Game</title>
</head>

<body>

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