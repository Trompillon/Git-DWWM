<?php
require 'db.php'; // Votre connexion PDO

// 1. GESTION DE LA SOUMISSION DU FORMULAIRE (Le UPDATE)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier que toutes les données sont présentes
    if (isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['age']) && isset($_POST['sexe'])) {
        
        // Assainir et récupérer les données
        $id = intval($_POST['id']);
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $age = intval($_POST['age']);
        $sexe = trim($_POST['sexe']);

        try {
            // Requête préparée pour l'UPDATE
            $sql = "UPDATE User SET lastname = :nom, firstname = :prenom, age = :age, sex = :sexe WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            
            // Exécution
            $stmt->execute([
                'nom'    => $nom,
                'prenom' => $prenom,
                'age'    => $age,
                'sexe'   => $sexe,
                'id'     => $id
            ]);

            // Redirection après succès
            header("Location: index.php?update=success");
            exit;

        } catch (PDOException $e) {
            $error = "Erreur lors de la modification : " . htmlspecialchars($e->getMessage());
        }
    } else {
        $error = "Tous les champs sont requis.";
    }
} 

// 2. PRÉ-REMPLISSAGE DU FORMULAIRE (Le SELECT)

// S'assurer que l'ID est dans l'URL et est valide
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?error=invalid_id");
    exit;
}

$id_user_to_edit = intval($_GET['id']);

try {
    // Requête SELECT pour récupérer les données actuelles de l'utilisateur
    $sql_select = "SELECT * FROM User WHERE id = :id";
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute(['id' => $id_user_to_edit]);
    $user = $stmt_select->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur n'existe pas
    if (!$user) {
        header("Location: index.php?error=user_not_found");
        exit;
    }

} catch (PDOException $e) {
    die("Erreur de récupération des données : " . htmlspecialchars($e->getMessage()));
}

// 3. AFFICHAGE DU FORMULAIRE (Avec les valeurs actuelles)

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Modifier l'utilisateur</title>
</head>
<body>
    
<h1>Modifier l'utilisateur : <?= htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']) ?></h1>

<?php if (isset($error)): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>
 
<form action="update.php" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

    <input type="text" name="nom" placeholder="Nom" required 
           value="<?= htmlspecialchars($user['lastname']) ?>">

    <input type="text" name="prenom" placeholder="Prénom" required
           value="<?= htmlspecialchars($user['firstname']) ?>">

    <input type="number" name="age" placeholder="Àge" required
           value="<?= htmlspecialchars($user['age']) ?>">

    <select name="sexe" required>
        <option value="">Sexe</option>
        
        <option value="Homme" <?= ($user['sex'] === 'Homme' ? 'selected' : '') ?>>Homme</option>
        <option value="Femme" <?= ($user['sex'] === 'Femme' ? 'selected' : '') ?>>Femme</option>
        <option value="Autre" <?= ($user['sex'] === 'Autre' ? 'selected' : '') ?>>Autre</option>
    </select>
    
    <input type="submit" value="Enregistrer les modifications">
    <p><a href="index.php">Annuler et Retour à la liste</a></p>
</form>

</body>
</html>