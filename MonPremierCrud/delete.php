<?php 
require 'db.php';

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {


$id = intval($_GET['id']);
$stmt = $pdo->prepare('DELETE FROM User WHERE id = :id');
$stmt->execute(['id' => $id]);

header('Location: index.php');
exit;

} else {
    header('Location: index.php?error=missing_id');
    exit;
}

//  1. Connexion à la base de données
//  require 'db.php';

//  2. Vérification de la présence et de la validité de l'ID
//  if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    
//  3. Assainissement/Nettoyage de l'ID (Sécurité)
//  $id = intval($_GET['id']); 

//  4. Préparation de la requête de suppression (Sécurité)
//  $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');

//  5. Exécution de la requête
//  $stmt->execute(['id' => $id]);

//  6. Redirection après succès
//  header('Location: index.php'); // Redirige vers la page d'accueil ou la liste
//  exit;

//  } else {
//  Si l'ID est manquant ou invalide, rediriger
//  header('Location: index.php?error=missing_id');
//  exit;
//  }

?>