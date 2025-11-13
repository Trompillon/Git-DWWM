<?php
session_start();
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $message = 'Tous les champs sont obligatoires.';
    } else {
        // Récupérer l'utilisateur depuis la BDD
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_login'] = $user['login'];
            header('Location: index.php'); // ou page d'accueil après connexion
            exit;
        } else {
            $message = 'Email ou mot de passe incorrect.';
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
    <title>Connexion - TopFilms</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>Accueil</li>
                <li class="deco">Déconnexion</li>
            </ul>
        </nav>
    </header>

    <form class="formConnexion" action="connexion.php" method="post">
        <h1>Connexion</h1>

        <?php if ($message): ?>
            <p style="color:red;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <label for="email">Email</label>
        <input class="formInput" type="email" name="email" id="email" required>
        <br><br>

        <label for="password">Mot de passe</label>
        <input class="formInput" type="password" name="password" id="password" required>
        <br><br>

        <button type="submit" id="btn">Connexion</button>

        <p>
            <a href="inscription.php">Vous n'êtes pas inscrit ?</a>
        </p>
    </form>
</body>
</html>
