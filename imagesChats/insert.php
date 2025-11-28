<?php
require 'db.php';

//Vérifie que le formulaire a bien été soumis via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// On vérifie que tous les champs attendus existent ET ne sont pas vides
if (isset($_POST['catName']) && isset($_POST['description']) && isset($_POST['catImage'])) {
    //On sécurise les données reçues
    $catName = ($_POST['catName']);
    $description = ($_POST['description']);
    $catImage = ($_POST['catImage']);

            try {
            $stmt = $pdo->prepare("INSERT INTO cats (catName, description, catImage) VALUES (?, ?, ?)");
            $stmt->execute([$catName, $description, $catImage]);

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

    } else {
    // Si des champs sont manquants ou vides, on redirige avec un paramètre d'erreur
    header("Location: index.php?action=missing_fields"); // On ajoute le mot-clé "missing_fields"
    exit;
    }

} else {
// Si quelqu'un tente d'accéder au script sans POST
echo "<p style='color:red;'>Méthode non autorisée. </p>" ;
}

header("Location: index.php?action=added");
exit;



?>