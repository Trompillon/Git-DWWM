<?php

session_start();
require 'db.php';

//Vérifie que le formulaire a bien été soumis via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // var_dump ($_POST);
    // var_dump ($_FILES);

// On vérifie que tous les champs attendus existent ET ne sont pas vides
    if (isset($_POST['catName']) && isset($_POST['catDescription']) && isset($_FILES['imagePath']) && isset($_POST['catColor'])) {
        //On sécurise les données reçues
        if ($_FILES['imagePath']['error'] !== 0) {
            die("Erreur lors de l'upload du fichier.");
        }
        $catColor = ($_POST['catColor']);
        $catName = ($_POST['catName']);
        $catDescription = ($_POST['catDescription']);
        $maxSize = 2 * 1024 * 1024; // 2 Mo en octets
        if ($_FILES['imagePath']['size'] > $maxSize) {
            die("Le fichier est trop volumineux.");
        }
        $fileTmpPath = $_FILES['imagePath']['tmp_name'];
        $fileName = $_FILES['imagePath']['name'];
        // $fileName = time() . '_' . basename($_FILES['imagePath']['name']);
        $fileExt = strtolower(pathinfo($fileName)['extension']);
        $fileName = uniqid('imgChats_').'.'.$fileExt;
        $destination = 'uploadCats/' . $fileName;
        var_dump (is_dir($destination));
        move_uploaded_file($fileTmpPath, $destination);
        // if (!move_uploaded_file($fileTmpPath, $destination)) {
        // die("Erreur : impossible de déplacer le fichier.");
        // }

        $imagePath = $fileName;

            try {
                $stmt = $pdo->prepare("INSERT INTO cats (catName, catDescription, catColor, imagePath, user_id) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$catName, $catDescription, $catColor, $imagePath, $_SESSION['user_id']]);

            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }

    } else {
    // Si des champs sont manquants ou vides, on redirige avec un paramètre d'erreur
    header("Location: getCats.php?action=missing_fields"); // On ajoute le mot-clé "missing_fields"
    exit;
    }

header("Location: index.php?action=added");
exit;


} else {
// Si quelqu'un tente d'accéder au script sans POST
echo "<p style='color:red;'>Méthode non autorisée. </p>" ;
}

?>