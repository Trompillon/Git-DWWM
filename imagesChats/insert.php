<?php
header('content-Type: text/plain; charset=utf-8');
echo "CONTENT_TYPE   = " . ($_SERVER['CONTENT_TYPE'] ?? 'null') . PHP_EOL;
session_start();
require 'db.php';

//Vérifie que le formulaire a bien été soumis via POST
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // var_dump ($_POST);
    var_dump ($_FILES);
    echo 'size'. ini_get("post_max_size") . PHP_EOL;

// // On vérifie que tous les champs attendus existent ET ne sont pas vides
//     if (isset($_POST['catName']) && isset($_POST['catDescription']) && isset($_FILES['imagePath'])) {
//         //On sécurise les données reçues
//         if ($_FILES['imagePath']['error'] !== 0) {
//             die("Erreur lors de l'upload du fichier.");
//         }
//         $catName = ($_POST['catName']);
//         $catDescription = ($_POST['description']);
//         $maxSize = 2 * 1024 * 1024; // 2 Mo en octets
//         if ($_FILES['imagePath']['size'] > $maxSize) {
//             die("Le fichier est trop volumineux.");
//         }
//         $fileTmpPath = $_FILES['imagePath']['tmp_name'];
//         $fileName = $_FILES['imagePath']['name'];
//         $fileName = time() . '_' . basename($_FILES['imagePath']['name']);
//         $destination = 'uploadCats/' . $fileName;
//         move_uploaded_file($fileTmpPath, $destination);
//         $imagePath = $destination;

//         exit;

//             try {
//                 $stmt = $pdo->prepare("INSERT INTO cats (catName, catDescription, imagePath, user_id) VALUES (?, ?, ?, ?)");
//                 $stmt->execute([$catName, $catDescription, $imagePath, $_SESSION['user_id']]);

//             } catch (PDOException $e) {
//                 echo "Erreur : " . $e->getMessage();
//             }

//     } else {
//     // Si des champs sont manquants ou vides, on redirige avec un paramètre d'erreur
//     header("Location: getCats.php?action=missing_fields"); // On ajoute le mot-clé "missing_fields"
//     exit;
//     }

// header("Location: index.php?action=added");
// exit;

// }

// // } else {
// // // Si quelqu'un tente d'accéder au script sans POST
// // echo "<p style='color:red;'>Méthode non autorisée. </p>" ;
// // }

// ?>