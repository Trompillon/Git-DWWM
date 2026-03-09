<?php
session_start();

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

/* =========================================
   1. SÉCURITÉ & RÉCUPÉRATION DU PERSO
========================================= */
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: " . BASE_URL . "connexion/connexion.php");
    exit;
}

$stmtChar = $pdo->prepare("SELECT * FROM characters WHERE user_id = ?");
$stmtChar->execute([$userId]);
$character = $stmtChar->fetch();

if (!$character) {
    header("Location: " . BASE_URL . "game/choose_class.php");
    exit;
}

$charId = $character['id'];
$_SESSION['char_id'] = $charId;

/* =========================================
   2. LOGIQUE DU COMBAT (MONSTRE)
========================================= */
// On récupère l'ID du monstre envoyé par le formulaire précédent
$monsterId = $_POST['monster_id'] ?? $_GET['monster_id'] ?? null;

if (!$monsterId) {
    // Si on arrive sur cette page sans monstre (ex: actualisation), 
    // on redirige vers la carte ou le jeu
    header("Location: " . BASE_URL . "game/game.php");
    exit;
}

// Récupération des infos du monstre
$stmtMonster = $pdo->prepare("SELECT * FROM monsters WHERE id = :id");
$stmtMonster->execute([':id' => $monsterId]);
$monster = $stmtMonster->fetch();

/* =========================================
   3. GESTION DU COMBAT (RÉCUPÉRATION OU CRÉATION)
========================================= */

// On cherche s'il y a un combat EN COURS (plus de 0 PV)
$stmtCheck = $pdo->prepare("
    SELECT id FROM fights 
    WHERE char_id = :char_id 
    AND monsters_id = :m_id 
    AND monster_current_hp > 0 
    LIMIT 1
");
$stmtCheck->execute([
    ':char_id' => $charId,
    ':m_id'    => $monsterId
]);
$existingFight = $stmtCheck->fetch();

if ($existingFight) {
    // Si on en trouve un, on récupère son ID
    $currentFightId = $existingFight['id'];
} else {
    // SINON, on en crée un nouveau avec les PV au max
    $stmtFight = $pdo->prepare("
        INSERT INTO fights (monsters_id, monster_current_hp, char_id, char_current_hp) 
        VALUES (:monsters_id, :monster_current_hp, :char_id, :char_current_hp)
    ");
    $stmtFight->execute([
        ':monsters_id'        => $monsterId,
        ':monster_current_hp' => $monster['hp_max'],
        ':char_id'            => $charId,
        ':char_current_hp'    => $character['hp_current']
    ]);
    $currentFightId = $pdo->lastInsertId();
}

// ON GARDE BIEN CE QUI SUIT : c'est ce qui permet d'afficher la vie
$stmtActiveFight = $pdo->prepare("SELECT * FROM fights WHERE id = ?");
$stmtActiveFight->execute([$currentFightId]);
$activeFight = $stmtActiveFight->fetch();

// On synchronise les PV du perso avec ceux du combat en cours pour le HUD
$character['hp_current'] = $activeFight['char_current_hp'];

/* =========================================
   4. RÉCUPÉRATION DES DONNÉES VISUELLES
========================================= */

// On récupère d'abord l'ID du passage actuel via char_progress
$stmtPos = $pdo->prepare("SELECT current_story_id FROM char_progress WHERE char_id = ?");
$stmtPos->execute([$charId]);
$progress = $stmtPos->fetch();
$currentPassageId = $progress ? $progress['current_story_id'] : 1;

// Maintenant on récupère le contenu
$stmtPassage = $pdo->prepare("SELECT * FROM story WHERE id = ?");
$stmtPassage->execute([$currentPassageId]);
$passage = $stmtPassage->fetch();

$stmtImages = $pdo->prepare("SELECT * FROM images WHERE story_id = ?");
$stmtImages->execute([$currentPassageId]);
$images = $stmtImages->fetch();

// On rafraîchit le perso mais on RE-SYNCHRONISE avec les PV du combat
$stmtChar = $pdo->prepare("SELECT * FROM characters WHERE id = ?");
$stmtChar->execute([$charId]);
$character = $stmtChar->fetch();

// On force les PV du HUD à être ceux de la table fights
$character['hp_current'] = $activeFight['char_current_hp'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Combat !</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>img/icon.png">
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

    <?php if (isset($_SESSION['combat_log'])): ?>
        <div class="combat-log" style="background: rgba(0,0,0,0.8); color: white; padding: 15px; text-align: center; border: 2px solid #e74c3c; margin: 10px; border-radius: 8px; font-weight: bold;">
            <?= $_SESSION['combat_log']; ?>
            <?php unset($_SESSION['combat_log']); ?>
        </div>
    <?php endif; ?>

    <main class="fight-container">
    <section class="story-img-wrapper">
        <img src="../img/<?= htmlspecialchars($images['img_url']) ?>" alt="Images du passage">
    </section>

    <section class="battle-arena">
        <div class="stat-box monster">
            <h3><?= htmlspecialchars($monster['name']) ?></h3>
            
            <div class="hp-bar">
                <div class="hp-fill" style="width: <?= ($activeFight['monster_current_hp'] / $monster['hp_max']) * 100 ?>%;"></div>
                <span><?= $activeFight['monster_current_hp'] ?> / <?= $monster['hp_max'] ?> HP</span>
            </div>
        </div>

        <div class="fight-actions">
            <form action="process_attack.php" method="POST">
                <input type="hidden" name="fight_id" value="<?= $currentFightId ?>">
                
                <button type="submit" name="action" value="attack" class="btn-attack">
                    ⚔️ Attaquer
                </button>

                <?php if (strtolower($character['class']) === 'mage'): ?>
                    <button type="submit" name="action" value="spell" class="btn-spell">
                        ✨ Lancer un sort
                    </button>
                <?php endif; ?>
            </form>
        </div>
    </section>
    </main>

</body>
</html>
