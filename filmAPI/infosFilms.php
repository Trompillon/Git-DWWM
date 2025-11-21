<?php
session_start();
require 'db.php';

if (!isset($_GET['id'])) {
    echo "Film introuvable.";
    exit;
}

$film_id = intval($_GET['id']); // sécurité pour s'assurer que c'est un nombre

// URL TMDB pour récupérer les détails
$api_key = 'cf2fcaf64521efda91fbc7fb7be72638';
$url = "https://api.themoviedb.org/3/movie/$film_id?api_key=$api_key&language=fr-FR";

// Récupérer les données
$film_data = file_get_contents($url);
$film = json_decode($film_data, true);

if (!$film) {
    echo "Impossible de récupérer les informations du film.";
    exit;
}

// Ensuite tu peux afficher les infos
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($film['title']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>
    
    <div id="filmContainer">
        <h1><?= htmlspecialchars($film['title']) ?></h1>
        <p><?= htmlspecialchars($film['overview']) ?></p>
        <p>Date de sortie : <?= htmlspecialchars($film['release_date']) ?></p>
        <p>Note : <?= htmlspecialchars($film['vote_average']) ?>/10</p>
        <img src="https://image.tmdb.org/t/p/w500<?= $film['poster_path'] ?>" alt="Affiche de <?= htmlspecialchars($film['title']) ?>">

        <button onclick="ajouterFavori(<?= $film['id'] ?>, '<?= addslashes($film['title']) ?>', '<?= $film['poster_path'] ?>', '<?= addslashes($film['overview']) ?>')">
            Ajouter aux favoris
        </button>


        <script>
        // Fonction existante pour ajouter aux favoris
            function ajouterFavori(tmdbId, titre, image, description) {
                fetch('ajouterFavoris.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `tmdb_id=${tmdbId}&titre=${encodeURIComponent(titre)}&image=${encodeURIComponent(image)}&description=${encodeURIComponent(description)}`
                })
                .then(response => response.text())
                .then(data => alert(data))
                .catch(err => alert('Erreur : ' + err));
            }

        </script>

        <h2>Commentaires</h2>

        <form id="commentaireForm" action="ajouterCommentaires.php" method="post">
            <input type="hidden" name="tmdb_id" value="<?= $film['id'] ?>">
            <textarea id="texteCommentaire" name="commentaire" placeholder="Écris ton commentaire..." required></textarea>
            <button type="submit">Envoyer</button>
        </form>

        <div id="listeCommentaires"></div>

        
    </div>

    <script>

    // Fonction pour récupérer et afficher les commentaires existants
    function chargerCommentaires() {
        const tmdb_id = <?= $film['id'] ?>; // ID du film courant

        fetch(`getCommentaires.php?tmdb_id=${tmdb_id}`)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('listeCommentaires');
                container.innerHTML = '';
                if (data.length === 0) {
                    container.innerHTML = '<p>Aucun commentaire pour le moment.</p>';
                    return;
                }
                data.forEach(comment => {
                    const div = document.createElement('div');
                    div.classList.add('commentaire');
                    div.innerHTML = `<strong>${comment.login}</strong> : ${comment.texte} <em>(${comment.created_at})</em>`;
                    container.appendChild(div);
                });
            })
            .catch(err => console.error(err));
    }

    // Envoyer un nouveau commentaire
    document.getElementById('commentaireForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const texte = document.getElementById('texteCommentaire').value.trim();
        const tmdb_id = <?= $film['id'] ?>;

        if (texte === '') return;

        fetch('ajouterCommentaires.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `tmdb_id=${tmdb_id}&commentaire=${encodeURIComponent(texte)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('texteCommentaire').value = '';
                chargerCommentaires(); // recharger la liste
            } else {
                alert(data.message);
            }
        })
        .catch(err => alert('Erreur : ' + err));
    });

    // Charger les commentaires dès le chargement de la page
    document.addEventListener('DOMContentLoaded', chargerCommentaires);

</script>


</body>
</html>
