<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

// 1. On récupère l'ID du monstre envoyé par ton formulaire
$monsterId = $_POST['monster_id'];

// 2. On va chercher les infos de ce monstre pour savoir combien il a de PV au max
$stmtMonster = $pdo->prepare("SELECT * FROM monsters WHERE id = :id");
$stmtMonster->execute([':id' => $monsterId]);
$monster = $stmtMonster->fetch();

// 3. ON CRÉE LE COMBAT dans ta table 'fights'
// (On insère les PV max du monstre dans 'monster_current_hp')
$stmtFight = $pdo->prepare("
    INSERT INTO fights (monsters_id, monster_current_hp, char_id) 
    VALUES (:monsters_id, :monster_hp, :char_id)
");
$stmtFight->execute([
    ':m_id' => $monsterId,
    ':m_hp' => $monster['hp_max'], // Le monstre commence full vie
    ':c_id' => 1 // ON FORCE l'ID 1 pour l'instant pour que tu vois le résultat
]);

// 4. On récupère l'ID du combat qu'on vient de créer
$currentFightId = $db->lastInsertId();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Combat !</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../components/header.php'; ?>

    <main class="fight-container">
        </main>
</body>
</html>