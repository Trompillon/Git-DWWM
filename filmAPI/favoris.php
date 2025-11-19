<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Récupérer les films favoris de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM favoris WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$favoris = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes favoris - TopFilms</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<?php include 'navbar.php'; ?>

<main>
    <h1>Mes films favoris</h1>

    <?php if (empty($favoris)): ?>
        <p>Vous n'avez pas encore ajouté de films à vos favoris.</p>
        <p><a href="films.php">Voir les films</a></p>
    <?php else: ?>
        <div id="favorisContainer">
            <?php foreach($favoris as $film): ?>
                <div class="filmFavori">
                    <?php if($film['image']): ?>
                        <a href="infosFilms.php?id=<?= $film['tmdb_id'] ?>">
                        <img src="https://image.tmdb.org/t/p/w200<?= $film['image'] ?>" alt="<?= htmlspecialchars($film['titre']) ?>">
                        </a>
                        <h3><?= htmlspecialchars($film['titre']) ?></h3>
                    <?php endif; ?>
                    <form action="supprimerFavoris.php" method="post" style="width: 100%;">
                        <input type="hidden" name="id" value="<?= $film['id'] ?>">
                        <button type="submit">Supprimer des favoris</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
