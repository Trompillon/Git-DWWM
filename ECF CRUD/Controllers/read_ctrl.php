<?php

require '../db.php';

// 2 SELECT : obtenir les informations actuelles de l’utilisateur

// S'assurer que l'ID est dans l'URL et est valide
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../index.php?error=invalid_id");
    exit;
}

$id_user_to_edit = intval($_GET['id']);

try {
    // Requête SELECT pour récupérer les données actuelles de l'utilisateur
    $sql_select = "SELECT * FROM user WHERE id = :id";
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute(['id' => $id_user_to_edit]);
    $user = $stmt_select->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur n'existe pas
    if (!$user) {
        header("Location: ../index.php?error=user_not_found");
        exit;
    }

} catch (PDOException $e) {
    die("Erreur de récupération des données : " . htmlspecialchars($e->getMessage()));
}

?>