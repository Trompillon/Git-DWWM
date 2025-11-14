<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die('Vous devez être connecté pour ajouter un favori.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $tmdb_id = $_POST['tmdb_id'];
    $titre = $_POST['titre'];
    $image = $_POST['image'];
    $description = $_POST['description'];

    // Vérifier si le film est déjà ajouté pour cet utilisateur
    $stmt = $pdo->prepare("SELECT id FROM favoris WHERE user_id = :user_id AND tmdb_id = :tmdb_id");
    $stmt->execute(['user_id' => $user_id, 'tmdb_id' => $tmdb_id]);
    if ($stmt->fetch()) {
        echo "Film déjà dans vos favoris !";
        exit;
    }

    // Ajouter le favori
    $insert = $pdo->prepare("INSERT INTO favoris (user_id, tmdb_id, titre, image, description) VALUES (:user_id, :tmdb_id, :titre, :image, :description)");
    $insert->execute([
        'user_id' => $user_id,
        'tmdb_id' => $tmdb_id,
        'titre' => $titre,
        'image' => $image,
        'description' => $description
    ]);

    echo "Film ajouté à vos favoris !";
}

?>