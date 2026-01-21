<?php

require '../db.php';

// 1. GESTION DE LA SOUMISSION DU FORMULAIRE (Le UPDATE)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier que toutes les données sont présentes
    if (!empty($_POST['pseudo']) && !empty($_POST['mot_de_passe']) && !empty($_POST['description'])) {
        
        // Assainir et récupérer les données
        $id = intval($_POST['id']);
        $pseudo = trim($_POST['pseudo']);
        $mdp = trim($_POST['mot_de_passe']);
        $description = trim($_POST['description']);

        try {
            // Requête préparée pour l'UPDATE
            $sql = "UPDATE user SET pseudo = :pseudo, mot_de_passe = :mot_de_passe, description = :description  WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            
            // Exécution
            $stmt->execute([
                'pseudo' => $pseudo,
                'mot_de_passe' => $mdp,
                'description' => $description,
                'id' => $id
            ]);

            //Redirection vers l'accueil si tout s'est bien passé
            header("Location: ../index.php?action=added");
            exit;

        } catch (PDOException $e) {
            $error = "Erreur lors de la modification : " . htmlspecialchars($e->getMessage());
        }
    } else {
        $error = "Tous les champs sont requis.";
    }
} 

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

