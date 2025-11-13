<?php
require_once __DIR__ . '/../config.php';
require_once base_path('components/header.php');
require_once base_path('db.php');

if(!isset($_SESSION['user_id'])) {
    header('location: ' . base_url('connexion/connexion.php'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $randID = rand(1, 151);

    $sql = "SELECT * FROM pokemon_gen1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$randID]);
    $pokemon = $stmt->fetch(PDO::FETCH_ASSOC);

    $randTaille = rand(1, 20) / 10; 
    $randPoids = rand(10, 100);
    $randNiveau = rand(1, 100);
    
    $isShiny = (rand(1, 100) === 1) ? 1 : 0;

    try {
        $sqlInsert = "INSERT INTO owned_pokemon (pokedex_id, nom, taille, poids, type1, type2, niveau, ownedby, is_shiny) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([
            $pokemon['id'],
            $pokemon['nom'],
            $randTaille,
            $randPoids,
            $pokemon['type1'],
            $pokemon['type2'] ?? null,
            $randNiveau,
            $_SESSION['user_id'],
            $isShiny
        ]);
    } catch (PDOException $e) {
        echo "<script>alert('Erreur lors de l\'insertion du pokemon aléatoire : " . $e->getMessage() . "');</script>";
    }
}
?>

<div class="bush-pattern d-flex align-items-center justify-content-center min-vh-100">
  <div class="card text-center p-5 bg-dark bg-opacity-75 border-0">
    <h1 class="text-white mb-5">Zone de Capture</h1>
    <form action="" method="POST">
      <button type="submit" class="btn btn-lg p-0 border-0" style="max-width: 200px;">
        <img src="<?= base_url('Ressources/bush2.png') ?>" alt="bush" class="img-fluid">
      </button>
    </form>
  </div>
</div>

<?php require_once base_path('components/footer.php'); ?>