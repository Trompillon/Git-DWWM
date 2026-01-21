<?php 

require '../db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    try {

        $id = intval($_GET['id']);
        $stmt = $pdo->prepare('DELETE FROM user WHERE id = :id');
        $stmt->execute(['id' => $id]);

        //Redirection vers l'accueil si tout s'est bien passé
        header('Location: ../index.php?action=added');
        exit;

    } catch (PDOException $e) {

        echo "<p style='color:red;'>Erreur lors de la suppression : " 
        . htmlspecialchars($e->getMessage()) 
        . "</p>";
        }
        exit;
        

} else {
    header('Location: ../index.php?error=missing_id');
    exit;
}