<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die('Vous devez être connecté pour supprimer un favori.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    
    // Supprimer seulement si le favori appartient à l'utilisateur
    $stmt = $pdo->prepare("DELETE FROM favoris WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $id, 'user_id' => $_SESSION['user_id']]);

    header('Location: favoris.php');
    exit;
}
