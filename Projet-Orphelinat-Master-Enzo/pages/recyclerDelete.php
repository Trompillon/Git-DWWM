<?php
require_once __DIR__ . '/../config.php';
require_once base_path('db.php');

if(!isset($_SESSION['user_id'])) {
    header('location: ' . base_url('connexion/connexion.php'));
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('location: ' . base_url('pages/recycler.php'));
    exit;
}

$id = (int) $_GET['id'];

try {
    $sqlCheck = "SELECT * FROM owned_pokemon WHERE id = :id AND ownedby = :user_id";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([
        'id' => $id,
        'user_id' => $_SESSION['user_id']
    ]);
    $pokemon = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if (!$pokemon) {
        echo "<script>alert('Ce pokémon ne vous appartient pas ou n\'existe pas.'); window.location.href='" . base_url('pages/recycler.php') . "';</script>";
        exit;
    }
    $sqlDelete = "DELETE FROM owned_pokemon WHERE id = :id";
    $stmtDelete = $pdo->prepare($sqlDelete);
    $stmtDelete->execute(['id' => $id]);

    header('location: ' . base_url('pages/recycler.php?success=1'));
    exit;

} catch (PDOException $e) {
    echo "<script>alert('Erreur lors du recyclage : " . addslashes($e->getMessage()) . "'); window.location.href='" . base_url('pages/recycler.php') . "';</script>";
    exit;
}
?>