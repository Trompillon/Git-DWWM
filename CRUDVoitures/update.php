<?php

session_start();

require 'db.php';

$token = $_SESSION['csrf_token'];

if (!empty($_POST)) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Token CSRF invalide');
    }
}

// 1. GESTION DE LA SOUMISSION DU FORMULAIRE (Le UPDATE)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier que toutes les données sont présentes
    if (!empty($_POST['owner_lastname']) && !empty($_POST['owner_firstname']) && !empty($_POST['car_brand']) && !empty($_POST['car_model']) && !empty($_POST['car_registration']) && !empty($_POST['car_year']) && !empty($_POST['car_color'])) {
        
        // Assainir et récupérer les données
        $id = intval($_POST['id']);
        $lastname = trim($_POST['owner_lastname']);
        $firstname = trim($_POST['owner_firstname']);
        $brand = trim($_POST['car_brand']);
        $model = trim($_POST['car_model']);
        $registration = trim($_POST['car_registration']);
        $year = ($_POST['car_year']);
        $color = trim($_POST['car_color']);

        try {
            // Requête préparée pour l'UPDATE
            $sql = "UPDATE users SET carownerlastname = :owner_lastname, carownerfirstname = :owner_firstname, carbrand = :car_brand, carmodel = :car_model, carregistration = :car_registration, caryear = :car_year, carcolor = :car_color  WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            
            // Exécution
            $stmt->execute([
                'owner_lastname' => $lastname,
                'owner_firstname' => $firstname,
                'car_brand' => $brand,
                'car_model' => $model,
                'car_registration' => $registration,
                'car_year' => $year,
                'car_color' => $color,
                'id' => $id
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

// 2 SELECT : obtenir les informations actuelles de l’utilisateur

// S'assurer que l'ID est dans l'URL et est valide
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?error=invalid_id");
    exit;
}

$id_user_to_edit = intval($_GET['id']);

try {
    // Requête SELECT pour récupérer les données actuelles de l'utilisateur
    $sql_select = "SELECT * FROM users WHERE id = :id";
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

?>

<!-- 3. AFFICHAGE DU FORMULAIRE (Avec les valeurs actuelles) -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

    <h1>Modifier l'utilisateur : <?= htmlspecialchars($user['carownerfirstname']) . ' ' . htmlspecialchars($user['carownerlastname']) ?></h1>

    <?php if (isset($error)): ?>
    <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <main>

        <form action="update.php" id="" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
            <input type="text" name="owner_lastname" value="<?= htmlspecialchars($user['carownerlastname']) ?>" required>
            <input type="text" name="owner_firstname" value="<?= htmlspecialchars($user['carownerfirstname']) ?>" required>
            <input type="text" name="car_brand" value="<?= htmlspecialchars($user['carbrand']) ?>" required>
            <input type="text" name="car_model" value="<?= htmlspecialchars($user['carmodel']) ?>" required>
            <input type="text" name="car_registration" value="<?= htmlspecialchars($user['carregistration']) ?>" required>
            <input type="date" name="car_year" value="<?= htmlspecialchars($user['caryear']) ?>" required>
            <input type="text" name="car_color" value="<?= htmlspecialchars($user['carcolor']) ?>" required>
            <input type="submit" value="Enregistrer les modifications">
            <p><a href="index.php">Annuler et Retour à la liste</a></p>
        </form>

    </main>

</body>
</html>