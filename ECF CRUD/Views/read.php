<?php

    include '../Controllers/read_ctrl.php'

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ECF CRUD</title>
</head>
<body>

    <main>

        <h2>Informations user</h2>

        <li>ID <?= htmlspecialchars($user['id']) ?></li>
        <li>Pseudo <?= htmlspecialchars($user['pseudo']) ?></li>
        <li>Mot de passe <?= htmlspecialchars($user['mot_de_passe']) ?></li>
        <li>Description <?= htmlspecialchars($user['description']) ?></li>       

    </main>
    
</body>
</html>