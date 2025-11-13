<?php
// 1. Inclure le fichier de connexion à la base de données
include 'db.php'; 

// Démarrer une session (crucial pour garder l'utilisateur connecté)
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        // 2. Préparer la requête pour récupérer l'utilisateur (CORRIGÉE)
        // On sélectionne toutes les colonnes, mais on va surtout utiliser 'password_hash'
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        // 3. Vérifier si l'utilisateur existe
        if ($user) {
            // 4. Vérifier si le mot de passe correspond au hash stocké (CORRIGÉE)
            if (password_verify($password, $user['password_hash'])) { // Changement ici
        
                // Connexion réussie !
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                // Ajoutez d'autres variables de session si besoin (ex: login, role)
                $_SESSION['user_role'] = $user['role'];

                // Rediriger vers une page sécurisée (ex: profil.php)
                header('Location: index.php'); // Changez 'index.php' par votre page d'accueil après connexion
                exit;

            } else {
                $erreur = "Email ou mot de passe incorrect.";
            }
        } else {
            $erreur = "Email ou mot de passe incorrect.";
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}
// Fin du code de traitement PHP
?>

<?php
// Inclure header.php et afficher les messages
include 'header.php';

if (isset($erreur)) {
    echo '<div class="alert alert-danger text-center">' . $erreur . '</div>';
}
?>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center form-container">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">
            <div class="bg-white p-4 p-md-5 shadow-sm">
                <h1 class="text-center mb-4 fw-normal fs-2">Connexion</h1>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label small">Email</label>
                        <input type="email" class="form-control border-0 py-3 form-input-custom" name="email" id="email" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label small">Mot de passe</label>
                        <input type="password" class="form-control border-0 py-3 form-input-custom" name="password" id="password" required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn text-white py-3 fs-5 btn-custom">Connexion</button>
                    </div>

                    <p class="text-center small mb-0">
                        <a href="inscription.php" class="text-decoration-none link-custom">Vous n'êtes pas inscrit?</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>