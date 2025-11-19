<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

// Vérifier si un tmdb_id est fourni
if (!isset($_GET['tmdb_id'])) {
    echo json_encode([]);
    exit;
}

$tmdb_id = intval($_GET['tmdb_id']);

try {
    // Récupérer les commentaires + pseudo des utilisateurs
    $sql = "SELECT c.texte, c.created_at, u.login
            FROM commentaires c
            JOIN users u ON c.user_id = u.id
            WHERE c.tmdb_id = :tmdb_id
            ORDER BY c.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':tmdb_id' => $tmdb_id]);

    $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($commentaires);

} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => 'Erreur : ' . $e->getMessage()
    ]);
}
