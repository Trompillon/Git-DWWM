<?php

session_start();

require 'db.php';

if (!empty($_POST)) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Token CSRF invalide');
    }
}

//Vérifie que le formulaire a bien été soumis via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // On vérifie que tous les champs attendus existent ET ne sont pas vides
    if (!empty($_POST['owner_lastname']) && !empty($_POST['owner_firstname']) && !empty($_POST['car_brand']) && !empty($_POST['car_model']) && !empty($_POST['car_registration']) && !empty($_POST['car_year']) && !empty($_POST['car_color'])) {
        //On sécurise les données reçues
        $lastname = trim($_POST['owner_lastname']);
        $firstname = trim($_POST['owner_firstname']);
        $brand = trim($_POST['car_brand']);
        $model = trim($_POST['car_model']);
        $registration = trim($_POST['car_registration']);
        $year = ($_POST['car_year']);
        $color = trim($_POST['car_color']);

        try {
            //Requête préparée pour éviter les injections SQL
            $sql = "INSERT INTO users (carownerlastname, carownerfirstname, carbrand, carmodel, carregistration, caryear, carcolor) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$lastname, $firstname, $brand, $model, $registration, $year, $color]);

            //Redirection vers l'accueil si tout s'est bien passé
            header("Location: index.php?action=added");
            exit;

        } catch (PDOException $e) {
            // En cas d'erreur SQL, on affiche un message d'erreur lisible
            echo "<p style='color:red;'>Erreur lors de l'ajout dans la base de données";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
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

?>