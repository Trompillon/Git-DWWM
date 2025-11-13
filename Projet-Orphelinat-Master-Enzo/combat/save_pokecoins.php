<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config.php';
require_once base_path('db.php');

if(!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Non authentifié']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data['pokecoins'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Pokécoins manquants']);
    exit;
}

try {
    $pokecoins = intval($data['pokecoins']);
    $userId = $_SESSION['user_id'];
    
    $stmt = $pdo->prepare("UPDATE users SET pokecoin = ? WHERE id = ?");
    $result = $stmt->execute([$pokecoins, $userId]);
    
    if($result) {
        echo json_encode([
            'success' => true, 
            'pokecoins' => $pokecoins
        ]);
    } else {
        throw new Exception('Échec de la mise à jour');
    }
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'error' => $e->getMessage()
    ]);
}


?>