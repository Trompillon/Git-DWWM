<?php

session_start();
$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;


require 'db.php';

    $sql = "SELECT * FROM user";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    <header>

    </header>

    <main>

        <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Pseudo</th>
                        <th>Mot de passe</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                        <a href='Views/create.php'>Créer un utilisateur</a>
                </thead>

                <tbody>

                <?php

                if (!empty($users)) {
                    foreach($users as $user){
                ?>

                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['pseudo']) ?></td> 
                    <td><?= htmlspecialchars($user['mot_de_passe']) ?></td>
                    <td><?= htmlspecialchars($user['description']) ?></td>
                    
                    <td>
                        <button class="buttonDelete"
                                onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) { window.location.href='Controllers/delete_ctrl.php?id=<?= htmlspecialchars($user['id']) ?>'; }">
                        Supprimer
                        </button>
                        <button class="buttonModify" 
                                onclick="window.location.href='Views/update.php?id=<?= htmlspecialchars($user['id']) ?>'">
                        Modifier
                        </button>
                        <button class="buttonSee" 
                                onclick="window.location.href='Views/read.php?id=<?= htmlspecialchars($user['id']) ?>'">
                        Voir
                        </button>
                    </td>   
                </tr>

                <?php

                }
                } else {
                    // Affichage d'un message si aucun utilisateur n'est trouvé
                    ?>

                    <tr>
                        <td colspan="5">Aucun utilisateur trouvé.</td>
                    </tr>

                    <?php
                }
                    ?>

                </tbody>
                
            </table>

    </main>

</body>
</html>