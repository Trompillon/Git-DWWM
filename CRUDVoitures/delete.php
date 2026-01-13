<?php 

session_start();

require 'db.php';

if (!empty($_POST)) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Token CSRF invalide');
    }
}

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {

    try {

        $id = intval($_GET['id']);
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);

        header('Location: index.php');
        exit;

    } catch (PDOException $e) {

        echo "<p style='color:red;'>Erreur lors de la suppression : " 
        . htmlspecialchars($e->getMessage()) 
        . "</p>";
        }
        exit;
        

} else {
    header('Location: index.php?error=missing_id');
    exit;
}