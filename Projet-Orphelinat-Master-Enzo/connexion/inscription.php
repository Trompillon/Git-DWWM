<?php
require_once __DIR__ . '/../config.php';
require_once base_path('components/header.php');
require_once base_path('db.php');

$message = '';

if (
    isset($_POST['login']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['confirmPassword'])
) {
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, login, password) VALUES (:email, :login, :password)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':email' => $email,
        ':login' => $login,
        ':password' => $password
    ]);

    if ($result) {
        $message = 'Inscription réussie';
        header('Location: ' . base_url('connexion/connexion.php'));
        exit;
    } else {
        $message = 'Erreur durant l\'inscription';
    }
}
?>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center form-container">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">
            <div class="bg-white p-4 p-md-5 shadow-sm">
                <h1 class="text-center mb-4 fw-normal fs-2">Inscription</h1>
                <?php if (!empty($message)): ?>
                    <p style="color:red"><?= htmlspecialchars($message) ?></p>
                <?php endif; ?>
                <form action="<?= base_url('connexion/inscription.php') ?>" method="post">
                    <div class="mb-3">
                        <label for="login" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control border-0 py-3 form-input-custom" name="login" id="login" required>
                    </div>
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
                        <a href="<?= base_url('connexion/connexion.php') ?>" class="text-decoration-none link-custom">Vous avez déjà un compte?</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once base_path('components/footer.php'); ?>