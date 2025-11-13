<?php
require_once __DIR__ . '/../config.php';
require_once base_path('db.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        $sql = "DELETE FROM pokemons WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        header('Location: ' . base_url('adoption/adoption.php'));
        exit;

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erreur lors de la suppression dans la base de données.</p>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    }

} else {
    echo "<p style='color:red;'>ID invalide.</p>";
}