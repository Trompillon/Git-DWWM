<?php
session_start();
require_once __DIR__ . '/../db.php';

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

$fightId = $_POST['fight_id'] ?? null;
$action  = $_POST['action'] ?? null;

if (!$fightId) { header("Location: game.php"); exit; }

// 1. Récupération des données (Combat, Perso+Arme, Monstre)
$stmtFight = $pdo->prepare("SELECT * FROM fights WHERE id = ?");
$stmtFight->execute([$fightId]);
$fight = $stmtFight->fetch();

// Requête Perso avec jointure pour l'arme
$stmtChar = $pdo->prepare("
    SELECT 
        characters.*, 
        items.bonus_atk, 
        items.dice_type AS weapon_dice, 
        items.bonus_def AS armor_bonus
    FROM characters
    LEFT JOIN inventory ON characters.id = inventory.char_id
    LEFT JOIN items ON inventory.item_id = items.id
    WHERE characters.id = ?
    ORDER BY items.bonus_atk DESC 
    LIMIT 1
");
$stmtChar->execute([$fight['char_id']]);
$player = $stmtChar->fetch();

$stmtM = $pdo->prepare("SELECT * FROM monsters WHERE id = ?");
$stmtM->execute([$fight['monsters_id']]);
$monster = $stmtM->fetch();

// 2. Préparation des variables de dés et sécurité
$d10 = rand(1, 10);
$player['bonus_atk']   = $player['bonus_atk'] ?? 0;
$player['weapon_dice'] = $player['weapon_dice'] ?? 4; 
$player['armor_bonus'] = $player['armor_bonus'] ?? 0;

// Utilisation de la variable corrigée
$d_arme = rand(1, $player['weapon_dice']);

/* =========================================
   SYSTÈME DE COMBAT
========================================= */
$log = "";

$newMonsterHp = $fight['monster_current_hp']; 
$newPlayerHp  = $fight['char_current_hp'];
$scoreAttaque = $player['attack_base'] + $player['bonus_atk'] + $d10;

if ($scoreAttaque >= $monster['armor_class']) {
    // SUCCÈS : dégâts = (attack_base + d_arme) - defense_base monstre
    $degats = ($player['attack_base'] + $d_arme) - $monster['defense_base'];
    $degats = max(1, $degats);

    $newMonsterHp = max(0, $fight['monster_current_hp'] - $degats);
    $pdo->prepare("UPDATE fights SET monster_current_hp = ? WHERE id = ?")
        ->execute([$newMonsterHp, $fightId]);
    
    $log = "⚔️ Vous touchez ! Le monstre subit $degats dégâts.";
} else {
    // ÉCHEC : Riposte du Monstre
    $d_monstre = rand(1, $monster['dice_type']);
    $degatsRecus = ($monster['attack_base'] + $d_monstre) - $player['defense_base'] - $player['armor_bonus'];
    $degatsRecus = max(1, $degatsRecus);

    $newPlayerHp = max(0, $fight['char_current_hp'] - $degatsRecus);
    $pdo->prepare("UPDATE fights SET char_current_hp = ? WHERE id = ?")
        ->execute([$newPlayerHp, $fightId]);
    
    $log = "🛡️ Échec ! Le monstre riposte : -$degatsRecus PV.";
}

// --- GESTION DE LA VICTOIRE ---
if ($newMonsterHp <= 0) {
    // 1. On finit le combat
    $pdo->prepare("UPDATE fights SET monster_current_hp = 0 WHERE id = ?")
        ->execute([$fightId]);

    // 2. On va chercher l'ID de la suite dans story_fights
    $stmtWin = $pdo->prepare("
        SELECT win_story_id 
        FROM story_fights 
        WHERE story_id = (
        SELECT current_story_id FROM char_progress WHERE char_id = ?
        )
    ");
    $stmtWin->execute([$fight['char_id']]);
    $win = $stmtWin->fetch();

    $nextStep = $win['win_story_id'] ?? 1; // Par défaut on remet au début si rien n'est rempli

    // 3. On téléporte le joueur au nouveau passage
    $pdo->prepare("UPDATE char_progress SET current_story_id = ? WHERE char_id = ?")
        ->execute([$nextStep, $fight['char_id']]);

    $_SESSION['combat_log'] = "🏆 Victoire ! Le monstre est terrassé.";
    
    // 4. On renvoie sur game.php qui affichera le nouveau texte
    header("Location: game.php");
    exit;
}

// --- GESTION DE LA DÉFAITE ---
if (isset($newPlayerHp) && $newPlayerHp <= 0) {
    $_SESSION['combat_log'] = "💀 Vous avez péri au combat...";
    // On met à jour les vrais PV du perso pour que le Game Over soit définitif
    $pdo->prepare("UPDATE characters SET hp_current = 0 WHERE id = ?")
        ->execute([$fight['char_id']]);
    header("Location: game_over.php"); 
    exit;
}

// Si le combat continue
$_SESSION['combat_log'] = $log;
header("Location: fight.php?monster_id=" . $fight['monsters_id']);
exit;