<?php

include '../Controllers/update_ctrl.php'

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

    <h1>Modifier l'utilisateur : <?= htmlspecialchars($user['pseudo']) . ' ' . htmlspecialchars($user['mot_de_passe']) . ' ' . htmlspecialchars($user['description']) ?></h1>

    <?php if (isset($error)): ?>
    <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <main>

        <form action="" id="" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
            <input type="text" name="pseudo" value="<?= htmlspecialchars($user['pseudo']) ?>" required>
            <input type="password" name="mot_de_passe" value="<?= htmlspecialchars($user['mot_de_passe']) ?>" required>
            <input type="text" name="description" value="<?= htmlspecialchars($user['description']) ?>" required>
            <input type="submit" value="Enregistrer les modifications">
            <p><a href="../index.php">Annuler et Retour à la liste</a></p>
        </form>

    </main>

</body>
</html>