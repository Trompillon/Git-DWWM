<?php
session_start();
require '../db.php';

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// définir la base URL
define('BASE_URL', '/projetDWWM/');

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header("Location: " . BASE_URL . "connexion/connexion.php");
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
    
    // --- AJOUT DES SORTS DE DÉPART ---
    $charId = $pdo->lastInsertId();

    if ($class === 'Mage') {
        $defaultSpells = [1, 2]; // Charme et Trait de feu
        $stmtSpell = $pdo->prepare("INSERT INTO character_spells (char_id, spell_id) VALUES (?, ?)");
        foreach ($defaultSpells as $spellId) {
            $stmtSpell->execute([$charId, $spellId]);
        }
    }
    
    // Définir le passage d'intro selon la classe
    if ($class === 'Guerrier') {
        $_SESSION['current_passage_id'] = 2;
    } elseif ($class === 'Mage') {
        $_SESSION['current_passage_id'] = 3;
    }

    // $_SESSION['class'] = $class; // stocker la classe pour plus tard si besoin

    header("Location: " . BASE_URL . "game/game.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix de Classe</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>img/icon.png">
</head>
<body>

    <?php include __DIR__ . '/../components/header.php'; ?>

    <div id="story">
        <?php if (!empty($image)): ?>
            <div class="story-img-wrapper">
                <img src="<?= BASE_URL ?>img/<?= htmlspecialchars($image['img_url']) ?>" alt="Image du passage">
            </div>
        <?php endif; ?>

        <p><?= htmlspecialchars($passage['content']) ?></p>
    </div>

    <div id="choices">
        <form method="POST">
            <button type="submit" name="class" value="Guerrier">Je suis un(e) puissant(e) Guerrier(e) !</button>
            <button type="submit" name="class" value="Mage">Je suis un(e) Mage doté(e) de pouvoirs magiques...</button>
        </form>
    </div>

    <?php include __DIR__ . '/../components/footer.php'; ?>

</body>
</html>
