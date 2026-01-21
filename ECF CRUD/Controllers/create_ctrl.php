<?php

session_start();

require '../db.php';

//Vérifie que le formulaire a bien été soumis via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // On vérifie que tous les champs attendus existent ET ne sont pas vides
    if (!empty($_POST['pseudo']) && !empty($_POST['mot_de_passe']) && !empty($_POST['description'])) {
        //On sécurise les données reçues
        $pseudo = trim($_POST['pseudo']);
        $mdp = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
        $description = trim($_POST['description']);

        try {
            //Requête préparée pour éviter les injections SQL
            $sql = "INSERT INTO user (pseudo, mot_de_passe, description) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$pseudo, $mdp, $description]);

            //Redirection vers l'accueil si tout s'est bien passé
            header("Location: ../index.php?action=added");
            exit;

        } catch (PDOException $e) {
            // En cas d'erreur SQL, on affiche un message d'erreur lisible
            echo "<p style='color:red;'>Erreur lors de l'ajout dans la base de données";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
        }

        } else {
        // Si des champs sont manquants ou vides, on redirige avec un paramètre d'erreur
        header("Location: ../create.php?action=missing_fields"); // On ajoute le mot-clé "missing_fields"
        exit;
        }

} else {
// Si quelqu'un tente d'accéder au script sans POST
echo "<p style='color:red;'>Méthode non autorisée. </p>" ;
}

?>