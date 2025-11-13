<?php
require_once __DIR__ . '/../config.php';
require_once base_path('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) 
        && is_numeric($_POST['id']) 
        && isset($_POST['nom'])
        && isset($_POST['surnom'])
        && isset($_POST['type'])
        && isset($_POST['niveau'])) {
        try {
            $sql = "UPDATE pokemons SET nom = ?, surnom = ?, type1 = ?, niveau = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['nom'], $_POST['surnom'], $_POST['type'], $_POST['niveau'], $_POST['id']]);
            
            header('Location: ' . base_url('adoption/adoption.php'));
            exit;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    } else {
        echo "Données manquantes ou invalides.";
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM pokemons WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $pokemon = $stmt->fetch(PDO::FETCH_ASSOC); 
}

require_once base_path('components/header.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Modifier un utilisateur</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Modifier l'utilisateur</h1>
        
        <form action="<?= base_url('adoption/update.php') ?>" method="POST" class="mt-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($pokemon['id']); ?>">
            
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" name="nom" id="nom" 
                       value="<?php echo htmlspecialchars($pokemon['nom']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="surnom" class="form-label">Surnom</label>
                <input type="text" class="form-control" name="surnom" id="surnom" 
                       value="<?php echo htmlspecialchars($pokemon['surnom']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="niveau" class="form-label">Niveau</label>
                <input type="number" class="form-control" name="niveau" id="niveau" 
                       value="<?php echo htmlspecialchars($pokemon['niveau']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="" disabled selected>Selectionner un type</option>
                    <option value="feu" <?php if($pokemon['type1'] === 'Feu') echo 'selected'; ?>>Feu</option>
                    <option value="eau" <?php if($pokemon['type1'] === 'Eau') echo 'selected'; ?>>Eau</option>
                    <option value="plante" <?php if($pokemon['type1'] === 'Plante') echo 'selected'; ?>>Plante</option>
                    <option value="electrik" <?php if($pokemon['type1'] === 'Electrik') echo 'selected'; ?>>Electrik</option>
                    <option value="combat" <?php if($pokemon['type1'] === 'Combat') echo 'selected'; ?>>Combat</option>
                    <option value="psy" <?php if($pokemon['type1'] === 'Psy') echo 'selected'; ?>>Psy</option>
                    <option value="tenebres" <?php if($pokemon['type1'] === 'Ténèbres') echo 'selected'; ?>>Ténèbres</option>
                </select> 
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="<?= base_url('adoption/adoption.php') ?>" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>