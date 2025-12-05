<?php
// 1. Inclure le fichier de connexion à la base de données
include 'db.php'; 

// Le code de traitement doit être avant l'affichage HTML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si tous les champs sont remplis
    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
        
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password']; // Mot de passe non haché
        $confirmPassword = $_POST['confirmPassword'];

        // 2. Vérifier que les mots de passe correspondent
        if ($password !== $confirmPassword) {
            $erreur = "Les mots de passe ne correspondent pas.";
        } else {
            
            // 3. Hacher le mot de passe (essentiel pour la sécurité)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role_par_defaut = 'user'; // Définir un rôle initial
            $date_creation = date('Y-m-d H:i:s'); // Date/heure actuelle

            try {
                // 4. Préparer et exécuter la requête d'insertion (CORRIGÉE)
                $stmt = $pdo->prepare("
                INSERT INTO users (login, email, password_hash, role, created_at) 
                VALUES (:login, :email, :password_hash, :role, :created_at)
                ");
    
                $stmt->execute([
                    'login' => $email, // Utiliser l'email comme login par défaut
                    'email' => $email,
                    'password_hash' => $hashed_password, // Changement ici
                    'role' => $role_par_defaut,
                    'created_at' => $date_creation
                ]);

                $message_succes = "Inscription réussie ! Vous pouvez maintenant vous connecter.";

            } catch (PDOException $e) {
                // Gérer les erreurs, par exemple, si l'email existe déjà
                if ($e->getCode() == 23000) { // Code d'erreur pour les violations de contrainte (UNIQUE)
                    $erreur = "Cet email est déjà utilisé.";
                } else {
                    $erreur = "Une erreur est survenue lors de l'inscription.";
                    // Loguer $e->getMessage() pour le débogage, mais ne pas l'afficher à l'utilisateur final.
                }
            }
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
if (isset($message_succes)) {
    echo '<div class="alert alert-success text-center">' . $message_succes . '</div>';
}
?>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center form-container">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">
            <div class="bg-white p-4 p-md-5 shadow-sm">
                <h1 class="text-center mb-4 fw-normal fs-2">Inscription</h1>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email</label>
                        <input type="email" class="form-control border-0 py-3 form-input-custom" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control border-0 py-3 form-input-custom" name="password" id="password" required>
                    </div>
                    <div class="mb-4">
                        <label for="confirmPassword" class="form-label">Confirmez le Mot de passe</label>
                        <input type="password" class="form-control border-0 py-3 form-input-custom" name="confirmPassword" id="confirmPassword" required>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn text-white py-3 fs-5 btn-custom">Inscription</button>
                    </div>
                    <p class="text-center mb-0">
                        <a href="connexion.php" class="text-decoration-none link-custom">Vous avez déjà un compte?</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>