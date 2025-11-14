<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Récupération de la date de naissance de l'utilisateur depuis la session
$birthdate = $_SESSION['birthdate'];
$allowAdult = 'false'; // par défaut interdit pour les mineurs

if ($birthdate) {
    $today = new DateTime();
    $dob = new DateTime($birthdate);
    $age = $today->diff($dob)->y; // âge en années
    if ($age >= 18) {
        $allowAdult = 'true';
    }
}

?>

<script>
    const allowAdult = <?= $allowAdult ?>; // true ou false selon l'âge
</script>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Films - TopFilms</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Rechercher un film...">
        <select id="genreSelect">
            <option value="">Tous les genres</option>
            <!-- Tu peux ajouter ici les genres disponibles -->
            <option value="28">Action</option>
            <option value="12">Aventure</option>
            <option value="16">Animation</option>
            <option value="35">Comédie</option>
            <option value="80">Crime</option>
            <option value="99">Documentaire</option>
            <option value="18">Drame</option>
            <option value="27">Horreur</option>
            <option value="878">Science Fiction</option>
            <option value="53">Thriller</option>
            <option value="37">Western</option>
        </select>
        <button id="searchBtn">Rechercher</button>
    </div>
    <br>

    <h1>Films Populaires</h1>
    
    <div id="filmsContainer">
        <!-- Ici on affichera les films -->
    </div>

    <script>

        const apiKey = 'cf2fcaf64521efda91fbc7fb7be72638'; // Ta clé TMDB

        // Au chargement, afficher les films populaires
        document.addEventListener('DOMContentLoaded', () => {
            rechercherFilms();
        });

        // Événement du bouton Rechercher
        document.getElementById('searchBtn').addEventListener('click', () => {
            const query = document.getElementById('searchInput').value.trim();
            const genre = document.getElementById('genreSelect').value;

            rechercherFilms(query, genre);
        });

        // Fonction pour rechercher des films via TMDB
        function rechercherFilms(query = '', genre = '') {
            let url;

            if (genre) {
                // /discover/movie pour filtrer par genre
                url = `https://api.themoviedb.org/3/discover/movie?api_key=${apiKey}&language=fr&with_genres=${genre}&page=1&include_adult=${allowAdult}`;
                if(query) {
                    url += `&query=${encodeURIComponent(query)}`; // Combiner avec un mot-clé si présent
                }
            } else if (query) {
                // Recherche par titre seulement
                url = `https://api.themoviedb.org/3/search/movie?api_key=${apiKey}&language=fr&query=${encodeURIComponent(query)}&page=1&include_adult=${allowAdult}`;
            } else {
                // Aucun filtre : films populaires par défaut
                url = `https://api.themoviedb.org/3/movie/popular?api_key=${apiKey}&language=fr&page=1&include_adult=${allowAdult}`;
            console.log(allowAdult);
            }

            fetch(url)
                .then(response => response.json())
                .then(data => afficherFilms(data.results))
                .catch(err => console.error('Erreur API:', err));
        }

        // Fonction pour afficher les films dynamiquement
        function afficherFilms(films) {
            const container = document.getElementById('filmsContainer');
            container.innerHTML = ''; // Vider le conteneur avant d'afficher

            if (!films || films.length === 0) {
            container.innerHTML = '<p>Aucun film trouvé.</p>';
                return;
            }

            films.forEach(film => {
            const div = document.createElement('div');
                div.classList.add('film');

                div.innerHTML = `
                    <img src="https://image.tmdb.org/t/p/w200${film.poster_path}" alt="${film.title}">
                    <h3>${film.title}</h3>
                    <p>${film.release_date || ''}</p>
                    <p>${film.overview || ''}</p>
                    <button onclick="ajouterFavori(${film.id}, '${film.title.replace(/'/g,"\\'")}', '${film.poster_path}', '${film.overview.replace(/'/g,"\\'")}')">Ajouter aux favoris</button>
                `;
                container.appendChild(div);
            });
        }

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

</body>
</html>

