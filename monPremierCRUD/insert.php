<?php
require 'db.php';

//Vérifie que le formulaire a bien été soumis via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// On vérifie que tous les champs attendus existent ET ne sont pas vides
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['age']) && isset($_POST['sexe'])) {
    //On sécurise les données reçues
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $age = ($_POST['age']);
    $sexe = ($_POST['sexe']);

    try {
        //Requête préparée pour éviter les injections SQL
        $sql = "INSERT INTO User (lastname, firstname, age, sex) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $age, $sexe]);

        //Redirection vers l'accueil si tout s'est bien passé
        header("Location: index.php?action=added");
        exit;

    } catch (PDOException $e) {
        // En cas d'erreur SQL, on affiche un message d'erreur lisible
        echo "<p style='color:red;'>Erreur lors de l'ajout dans la base de données";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";

        //Optionnel : on peut enregistrer l'erreur dans un fichier log
        // file_put_contents('erreurs.log, $e->getMessage(), FILE_APPEND);
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

