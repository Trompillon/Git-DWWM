<?php
require_once '../db.php';
header('Content-Type: application/json; charset=utf-8');

try {
    // Vérifie si le type a été envoyé
    if (!isset($_POST['type']) || empty($_POST['type'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Type de Pokémon manquant.']);
        exit;
    }

    $type = strtolower($_POST['type']); // on met en minuscules pour la comparaison

    // Si l'utilisateur veut "tous", on récupère tout
    if ($type === 'tous') {
        $stmt = $pdo->query("SELECT * FROM pokemon_gen1 ORDER BY nom ASC");
    } else {
        // On filtre par type1 ou type2
        $stmt = $pdo->prepare("SELECT * FROM pokemon_gen1 WHERE LOWER(type1) = :type OR LOWER(type2) = :type ORDER BY nom ASC");
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->execute();
    }

    $pokemons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Renvoie le résultat en JSON
    echo json_encode($pokemons, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

} catch (Throwable $e) {
    // Gestion d'erreur côté serveur
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
}
