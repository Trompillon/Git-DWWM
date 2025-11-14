<?php
require 'db.php'; // connexion à la BDD

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $login = trim($_POST['login'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';

    // Vérifications de base
    if (empty($login) || empty($email) || empty($password) || empty($confirmPassword) || empty($birthdate)) {
        $message = 'Tous les champs sont obligatoires.';
    } elseif ($password !== $confirmPassword) {
        $message = 'Les mots de passe ne correspondent pas.';
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            $message = 'Cet email est déjà utilisé.';
        } else {
            // Hacher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insérer dans la BDD
            $insert = $pdo->prepare("INSERT INTO users (login, email, password, birthdate) VALUES (:login, :email, :password, :birthdate)");
            $result = $insert->execute([
                'login' => $login,
                'email' => $email,
                'password' => $hashedPassword,
                'birthdate' => $birthdate
            ]);

            if ($result) {
                header('Location: connexion.php');
                exit;
            } else {
                $message = 'Erreur lors de l\'inscription.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Le site des topfilms</title>
</head>
<body>

   <?php include 'navbar.php'; ?>

    <form class="formInscription" action="inscription.php" method="post">
        
    <h1>Inscription</h1>

    <?php if ($message): ?>
        <p style="color:red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <label for="login">Pseudo</label>
    <input type="text" name="login" id="login" required>
    <br><br>

    <label for="email">Adresse Email</label>
    <input type="email" name="email" id="email" required>
    <br><br>

    <label for="date">Date de naissance</label>
    <input type="date" name="birthdate" required>


    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password" required>
    <br><br>

    <label for="confirmPassword">Confirmez le mot de passe</label>
    <input type="password" name="confirmPassword" id="confirmPassword" required>
    <br><br>

    <button type="submit">S’inscrire</button>
</form>


</body>
</html>