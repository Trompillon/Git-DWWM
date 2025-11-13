<?php
require_once __DIR__ . '/../config.php';
require_once base_path('components/header.php');
require_once base_path('db.php');

$message = '';

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE login = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['login' => $login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user["role"];
        header('location: ' . base_url('index.php'));
        exit;
    } else {
        $message = 'Mauvais Identifiants';
    }
}
?>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center form-container">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">
            <div class="bg-white p-4 p-md-5 shadow-sm">
                <h1 class="text-center mb-4 fw-normal fs-2">Connexion</h1>

                <?php if ($message): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form action="<?= base_url('connexion/connexion.php') ?>" method="post">
                    <div class="mb-3">
                        <label for="login" class="form-label small">Username</label>
                        <input type="text" class="form-control border-0 py-3 form-input-custom" name="login" id="login" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label small">Mot de passe</label>
                        <input type="password" class="form-control border-0 py-3 form-input-custom" name="password" id="password" required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn text-white py-3 fs-5 btn-custom">Connexion</button>
                    </div>

                    <p class="text-center small mb-0">
                        <a href="<?= base_url('connexion/inscription.php') ?>" class="text-decoration-none link-custom">Vous n'êtes pas inscrit?</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once base_path('components/footer.php'); ?>