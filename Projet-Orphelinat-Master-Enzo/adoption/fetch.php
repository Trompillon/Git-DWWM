<?php
// include '/../config.php';
require_once '../db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    if (!isset($_POST['id_pokemon']) || empty($_POST['id_pokemon'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID de Pokémon manquant.']);
        exit;
    }

    $id = (int) $_POST['id_pokemon'];

    $stmt = $pdo->prepare("SELECT * FROM pokemon_gen1 WHERE id = :id_pokemon");
    $stmt->bindParam(':id_pokemon', $id, PDO::PARAM_INT);
    $stmt->execute();

    $pokemon = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pokemon) {
        echo json_encode($pokemon, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
     }
      else {
        echo json_encode(['error' => 'Pokémon non trouvé.']);
    }
} catch (Throwable $e) {
    echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
}
