<?php
session_start();
require 'db.php'; 

header('Content-Type: application/json');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit;
}

// Vérifier les données POST
if (!isset($_POST['tmdb_id']) || !isset($_POST['commentaire'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$tmdb_id = intval($_POST['tmdb_id']); // sécurité : s'assurer que c'est un entier
$texte = trim($_POST['commentaire']);

if ($texte === '') {
    echo json_encode(['success' => false, 'message' => 'Le commentaire est vide.']);
    exit;
}

// Préparer et exécuter l'insertion
try {
    $stmt = $pdo->prepare("INSERT INTO commentaires (tmdb_id, user_id, texte) VALUES (:tmdb_id, :user_id, :texte)");
    $stmt->execute([
        ':tmdb_id' => $tmdb_id,
        ':user_id' => $user_id,
        ':texte' => $texte
    ]);

    echo json_encode(['success' => true, 'message' => 'Commentaire ajouté !']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
}

?>
