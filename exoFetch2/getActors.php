<?php

header("Content-Type: application/json");

// 1. Connexion à la base de données
require 'db.php';

// 2. Récupération de la donnée de recherche ('searchWord' vient de l'URL ou du formulaire)
$searchWord = $_GET['searchWord']; 

// 3. Préparation du paramètre de recherche floue (avec les wildcards %) optionnel mais plus lisible
// $searchParam = "%$searchWord%"; 

// 4. Préparation de la requête SQL avec la bonne logique WHERE et les 3 marqueurs (?) (parenthèses optionnelles ici)
$stmt = $pdo->prepare("SELECT * FROM actor WHERE first_name LIKE ? OR last_name LIKE ? OR actor_id LIKE ?"); 

// 5. Exécution de la requête, en fournissant le paramètre flou 3 FOIS
$stmt->execute(["%$searchWord%", "%$searchWord%", $searchWord]);

// 6. Récupération de TOUS les résultats dans un tableau PHP (plus simple que la boucle while)
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 7. Envoi du tableau PHP au format JSON pour qu'il soit utilisé par JavaScript
echo json_encode($result, JSON_UNESCAPED_UNICODE);

?>
