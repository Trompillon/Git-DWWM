<?php
session_start();
require '../db.php';

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// $userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header("Location: ../connexion.php");
    exit;
}

// --- Récupérer le passage d'introduction ---
$stmtPassage = $pdo->prepare("SELECT * FROM story WHERE id = 1");
$stmtPassage->execute();
$passage = $stmtPassage->fetch();

if (!$passage) {
    die("Passage d'introduction introuvable !");
}

// --- Récupérer l'image associée au passage ---
$stmtImage = $pdo->prepare("SELECT * FROM images WHERE story_id = ?");
$stmtImage->execute([$passage['id']]);
$image = $stmtImage->fetch();

// --- Vérifier si un perso existe déjà et le supprimer pour reset ---
$stmtCheck = $pdo->prepare("SELECT * FROM characters WHERE user_id = ?");
$stmtCheck->execute([$userId]);
$character = $stmtCheck->fetch();

if ($character) {
    $stmtDel = $pdo->prepare("DELETE FROM characters WHERE user_id = ?");
    $stmtDel->execute([$userId]);
}

// --- Traitement du formulaire de choix de classe ---
if (isset($_POST['class'])) {
    $class = $_POST['class'];

    // Définir les stats de base selon la classe
    switch($class) {
        case 'Guerrier':
            $hp_max = 50;
            $mana_max = 0;
            $attack_base = 3;
            $defense_base = 2;
            break;
        case 'Mage':
            $hp_max = 30;
            $mana_max = 50;
            $attack_base = 2;
            $defense_base = 1;
            break;
        // autres classes si besoin
    }

    $hp_current = $hp_max;
    $mana_current = $mana_max;
    $gold_pieces = 50;
    $name = $class; // ou demander un nom dans un input

    // Création du perso en BDD
    $stmtInsert = $pdo->prepare("
        INSERT INTO characters
        (user_id, name, class, hp_max, hp_current, mana_max, mana_current, attack_base, defense_base, gold_pieces, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())
    ");
    $stmtInsert->execute([$userId, $name, $class, $hp_max, $hp_current, $mana_max, $mana_current, $attack_base, $defense_base, $gold_pieces]);

    $_SESSION['current_passage_id'] = 2; // passage “introduction après le choix de classe”
        header("Location: game.php");
        exit;

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix de Classe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div id="story">
    <p><?= htmlspecialchars($passage['content']) ?></p>

    <?php if ($image): ?>
        <img src="../img/<?= htmlspecialchars($image['img_url']) ?>" alt="Image du passage">
    <?php endif; ?>
</div>

<div id="choices">
    <form method="POST">
        <button type="submit" name="class" value="Guerrier">Je suis un(e) puissant(e) Guerrier(e) !</button>
        <button type="submit" name="class" value="Mage">Je suis un(e) Mage doté(e) de pouvoirs magiques...</button>
    </form>
</div>

</body>
</html>
