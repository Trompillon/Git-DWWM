<?php
require_once __DIR__ . '/../config.php';
require_once base_path('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['id']) && !empty($_POST['surnom']) && !empty($_POST['taille']) && !empty($_POST['poids']) && !empty($_POST['type1']) && !empty($_POST['niveau'])) {
        try {
            $sql = "SELECT nom FROM pokemon_gen1 WHERE id = " . $_POST['id'] . "";
            $pokedata = $pdo->query($sql);
            $pokename = $pokedata->fetch(PDO::FETCH_ASSOC); 
            // Si type2 est vide, on le met à null
            $_POST['type2'] = (!isset($_POST['type2']) || $_POST['type2'] === '') ? null : $_POST['type2'];
            
            $sql = "INSERT INTO pokemons (nom, surnom, taille, poids, type1, type2, niveau) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $pokename['nom'],
                $_POST['surnom'],
                $_POST['taille'],
                $_POST['poids'],
                $_POST['type1'],
                $_POST['type2'],
                $_POST['niveau']
            ]);
            
            header('Location: ' . base_url('adoption/adoption.php'));
            exit;
        } catch (PDOException $e) {
            echo "<script>alert('Erreur lors de l\'envoi du pokemon à l\'adoption : " . addslashes($e->getMessage()) . "');</script>";
        }
    } else {
        echo "Veuillez remplir tous les champs obligatoires.";
        exit; 
    }
} else {
    echo "Méthode de requête invalide.";
    exit;
}
?>