<?php
session_start();
require 'db.php';

// Remplacez 'VOTRE_CLE_API_TMDB' par votre clé réelle
$tmdb_api_key = 'cf2fcaf64521efda91fbc7fb7be72638';
$base_url_poster = 'https://image.tmdb.org/t/p/w500'; // Taille standard pour une grande affiche

// ** 2. RÉCUPÉRATION DU FILM PHARE (Exemple: le film le plus populaire) **
$api_url = "https://api.themoviedb.org/3/movie/popular?api_key={$tmdb_api_key}&language=fr-FR&page=1";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$hero_film = [];

if ($response) {
    $data = json_decode($response, true);
    
    // On prend le premier film de la liste des populaires
    if (isset($data['results'][0])) {
        $film_data = $data['results'][0];

        // Construction des données du film Hero
        $hero_film = [
            'title' => $film_data['title'],
            'overview' => $film_data['overview'],
            'rating' => number_format($film_data['vote_average'], 1), // Formatage de la note
            'release_date' => substr($film_data['release_date'], 0, 4), // On garde seulement l'année
            
            // ** C'EST ICI QUE L'IMAGE EST CONSTRUITE **
            'poster_url' => $base_url_poster . $film_data['poster_path'],
            
            // Lien vers la fiche du film (vous devrez adapter ce lien à votre page de détails)
            'link_url' => 'films_details.php?id=' . $film_data['id'] 
        ];
    }
}

// ** 3. Gestion de l'échec (Fallback) **
if (empty($hero_film)) {
    // Si l'API échoue, on affiche un contenu par défaut
    $hero_film = [
        'title' => 'TopFilms : Découvrez l\'univers du cinéma',
        'overview' => 'Nous n\'avons pas réussi à récupérer les films pour l\'instant. Veuillez revenir plus tard ou utiliser la barre de recherche.',
        'rating' => 'N/A',
        'release_date' => '2025',
        'poster_url' => 'placeholder.jpg', // Une image par défaut si l'API est KO
        'link_url' => 'films.php' 
    ];
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopFilms - Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <?php include 'navbar.php'; ?>

    <main>

        <section class="heroSection">
            <div class="heroContent">
                <div class="heroPoster">
                    <img src="<?php echo $hero_film['poster_url']; ?>" alt="Affiche du film <?php echo $hero_film['title']; ?>">
                </div>

                <div class="heroDetails">
                    <p class="heroRating">⭐ <?php echo $hero_film['rating']; ?>/10</p>
                    
                    <h1><?php echo $hero_film['title']; ?> (<?php echo $hero_film['release_date']; ?>)</h1>
                    
                    <p class="heroOverview"><?php echo $hero_film['overview']; ?></p>
                    
                    <a href="infosFilms.php?id=<?php echo $film_data['id']; ?>" class="heroButton">
                        Voir la fiche du film
                    </a>
                </div>
            </div>
        </section>

        <section class="quick-links-section">

            <h2>Explorez TopFilms</h2>
            <div class="link-grid">
                <a href="films.php" class="quick-link-box">
                    <h3>Films Populaires</h3>
                    <p>Découvrez les blockbusters du moment.</p>
                </a>
                <a href="films.php?sort=upcoming" class="quick-link-box">
                    <h3>Prochaines Sorties</h3>
                    <p>Les films à ne pas manquer !</p>
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="favoris.php" class="quick-link-box">
                        <h3>Mes Favoris</h3>
                        <p>Retrouvez vos films sauvegardés.</p>
                    </a>
                <?php else: ?>
                    <a href="connexion.php" class="quick-link-box">
                        <h3>Connexion / Inscription</h3>
                        <p>Gérez votre liste de films.</p>
                    </a>
                <?php endif; ?>
            </div>
        </section>

    </main>

</body>
</html>

