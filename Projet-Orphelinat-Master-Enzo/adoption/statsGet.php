<?php
require_once __DIR__ . '/../config.php';
require_once base_path('db.php');

header('Content-Type: application/json; charset=utf-8');

try {
    $stmt = $pdo->prepare("SELECT * FROM pokemons");
    $stmt->execute();

    $pokemons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($pokemons) {
        echo json_encode($pokemons, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Pokémon non trouvé.']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
}