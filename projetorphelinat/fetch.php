<?php

include 'db.php';

// 2. Définir l'en-tête pour indiquer au JS que la réponse sera du JSON
header('Content-Type: application/json');

// 3. Vérifier si l'ID a été envoyé (LA CLÉ DOIT ÊTRE 'id_pokemon', comme dans le JS)
if (empty($_POST['id_pokemon'])) {
    
    // Si l'ID est manquant, on renvoie une erreur HTTP 400 (mauvaise requête)
    http_response_code(400); 
    echo json_encode(['error' => 'ID de Pokémon manquant.']);
    
    // On arrête le script ici pour ne pas essayer d'interroger la BDD
    exit;
}

// 4. Récupération et Sécurisation de l'ID (on s'assure que c'est bien un nombre entier)
$id = (int) $_POST['id_pokemon'];

// 5. Préparation de la requête sécurisée
// 'adoptezlestous' doit être le nom de VOTRE table
$stmt = $pdo->prepare("SELECT * FROM pokemon_gen1 WHERE id = :id_recu"); 

// 6. Liaison des paramètres (sécurité supplémentaire contre l'injection SQL)
$stmt->bindParam(':id_recu', $id, PDO::PARAM_INT);

// 7. Exécution de la requête
$stmt->execute();

// 8. Récupération des données (une seule ligne, format tableau associatif)
$pokemon = $stmt->fetch(PDO::FETCH_ASSOC);

// 9. Renvoyer la réponse
if ($pokemon) {
    // Si la BDD a trouvé un résultat, on encode l'objet PHP $pokemon en JSON
    echo json_encode($pokemon); 
} else {
    // Si la BDD n'a rien trouvé, on envoie un message d'erreur au format JSON
    echo json_encode(['message' => 'Pokémon non trouvé.']); 
}

?>

