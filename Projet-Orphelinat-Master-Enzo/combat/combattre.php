<?php 
require_once __DIR__ . '/../config.php';
require_once base_path('db.php');

if(!isset($_SESSION['user_id'])) {
    header('location: ' . base_url('connexion/connexion.php'));
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT op.niveau, op.pokedex_id
    FROM owned_pokemon op
    WHERE op.ownedBy = ?
");
$stmt->execute([$userId]);
$ownedPokemons = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalDamageBonus = 0;
foreach($ownedPokemons as $pokemon) {
    $totalDamageBonus += $pokemon['niveau'] / 10;
}

$stmt = $pdo->prepare("SELECT pokecoin FROM users WHERE id = ?");
$stmt->execute([$userId]);
$currentPokecoins = $stmt->fetchColumn();

require_once base_path('components/header.php');
?>
<div class="combat-background d-flex align-items-center justify-content-center min-vh-100">
  <div class="card text-center p-5 bg-dark bg-opacity-75 border-0">
    <h1 class="text-white mb-4">Zone de Combat</h1>
    
    <div id="gameContainer" class="d-none">
      <div class="text-warning fs-5 fw-bold mb-3">
        <span id="pokecoinCount"><?= $currentPokecoins ?></span> Pokécoins
      </div>
      
      <div class="text-white mb-4">
        <p class="mb-2">Pokémon vaincus: <span id="killCount">0</span></p>
        <p class="mb-2">Difficulté: <span id="difficultyLevel">1</span></p>
        <p class="mb-2">Dégâts par clic: <span id="damageDisplay">10</span></p>
        <p class="mb-0">Temps restant: <span id="timer" class="fs-2">10</span>s</p>
      </div>
      
      <div id="pokemonContainer" class="position-relative d-inline-block">
        <img id="pokemonSprite" class="pokemon-sprite-combat d-none" alt="Pokemon">
      </div>
      
      <div class="health-bar-container mx-auto my-4">
        <div id="healthBar" class="health-bar w-100">
          <span id="healthText" class="text-white fw-bold">100 / 100</span>
        </div>
      </div>
      
      <p class="text-white mt-3" id="pokemonName"></p>
    </div>
    
    <button id="btnStart" class="deco text-white text-decoration-none rounded px-3 py-2">Commencer à combattre</button>
    
    <div id="gameOver" class="d-none">
      <p class="text-white fs-3 mb-3">Temps écoulé !</p>
      <p class="text-white fs-5 mb-2">Pokémon vaincus: <span id="finalScore">0</span></p>
      <p class="text-white fs-5 mb-3">Pokécoins gagnés: <span id="coinsEarned">0</span></p>
      <button id="btnRestart" class="deco text-white text-decoration-none rounded px-3 py-2 mt-3">Recommencer</button>
    </div>
  </div>
</div>

<script>
const timerElement = document.getElementById('timer');
const btnStart = document.getElementById('btnStart');
const gameContainer = document.getElementById('gameContainer');
const gameOver = document.getElementById('gameOver');
const pokemonSprite = document.getElementById('pokemonSprite');
const pokemonContainer = document.getElementById('pokemonContainer');
const healthBar = document.getElementById('healthBar');
const healthText = document.getElementById('healthText');
const pokemonName = document.getElementById('pokemonName');
const killCountElement = document.getElementById('killCount');
const difficultyElement = document.getElementById('difficultyLevel');
const finalScoreElement = document.getElementById('finalScore');
const btnRestart = document.getElementById('btnRestart');
const pokecoinCountElement = document.getElementById('pokecoinCount');
const damageDisplayElement = document.getElementById('damageDisplay');
const coinsEarnedElement = document.getElementById('coinsEarned');

let totalSecondes = 10;
let interval = null;
let killedPokemonsCount = 0;
let difficulty = 1;
let vie = 100;
let vieMax = 100;
let degatsParClic = 10;
let pokemonActuel = null;
let totalPokecoins = <?= $currentPokecoins ?>;
let coinsGagnees = 0;

const damageBonus = <?= $totalDamageBonus ?>;
degatsParClic = 10 + damageBonus;

function genererPokemonAleatoire() {
    return Math.floor(Math.random() * 1025) + 1;
}

function estShiny() {
    return Math.random() < 0.01;
}

function chargerNouveauPokemon() {
    const pokemonId = genererPokemonAleatoire();
    const isShiny = estShiny();
    
    fetch(`https://tyradex.vercel.app/api/v1/pokemon/${pokemonId}`)
        .then(response => response.json())
        .then(data => {
            pokemonActuel = {
                id: pokemonId,
                nom: data.name.fr,
                isShiny: isShiny
            };
            
            pokemonSprite.src = isShiny ? data.sprites.shiny : data.sprites.regular;
            pokemonSprite.classList.remove('d-none');
            pokemonName.textContent = (isShiny ? 'Shiny' : '') + data.name.fr;
            
            vieMax = Math.floor(100 * Math.pow(1.15, killedPokemonsCount));
            vie = vieMax;
            healthBar.classList.add('health-bar-low');
            mettreAJourBarreVie();
        })
        .catch(error => {
            console.error('Erreur lors du chargement du Pokemon:', error);
            setTimeout(chargerNouveauPokemon, 500);
        });
}

function mettreAJourBarreVie() {
    const pourcentage = (vie / vieMax) * 100;
    healthBar.style.width = pourcentage + '%';
    healthText.textContent = Math.max(0, Math.floor(vie)) + ' / ' + vieMax;
    
    healthBar.classList.remove('health-bar-high', 'health-bar-medium', 'health-bar-low');
    if (pourcentage > 50) {
        healthBar.classList.add('health-bar-high');
    } else if (pourcentage > 25) {
        healthBar.classList.add('health-bar-medium');
    } else {
        healthBar.classList.add('health-bar-low');
    }
}

function afficherDegats(x, y) {
    const damageNumber = document.createElement('div');
    damageNumber.className = 'damage-number';
    damageNumber.textContent = '-' + Math.floor(degatsParClic);
    damageNumber.style.left = x + 'px';
    damageNumber.style.top = y + 'px';
    
    pokemonContainer.appendChild(damageNumber);
    
    setTimeout(() => {
        damageNumber.remove();
    }, 1000);
}

function afficherCoins(coins) {
    const coinNumber = document.createElement('div');
    coinNumber.className = 'coin-number';
    coinNumber.textContent = '+' + coins;
    coinNumber.style.left = '50%';
    coinNumber.style.top = '20px';
    coinNumber.style.transform = 'translateX(-50%)';
    
    pokemonContainer.appendChild(coinNumber);
    
    setTimeout(() => {
        coinNumber.remove();
    }, 1000);
}

function attaquerPokemon(event) {
    if (vie <= 0) return;
    
    vie -= degatsParClic;

    const rect = pokemonSprite.getBoundingClientRect();
    const x = event.clientX - rect.left - pokemonContainer.offsetLeft;
    const y = event.clientY - rect.top - pokemonContainer.offsetTop;
    afficherDegats(x, y);
    
    mettreAJourBarreVie();
    
    if (vie <= 0) {
        pokemonVaincu();
    }
}

function pokemonVaincu() {
    killedPokemonsCount++;
    difficulty = Math.floor(killedPokemonsCount / 10) + 1;
    
    const coinsGagnes = Math.floor(10 * difficulty * (pokemonActuel.isShiny ? 2 : 1));
    totalPokecoins += coinsGagnes;
    coinsGagnees += coinsGagnes;
    
    killCountElement.textContent = killedPokemonsCount;
    difficultyElement.textContent = difficulty;
    pokecoinCountElement.textContent = totalPokecoins;
    
    afficherCoins(coinsGagnes);
    
    chargerNouveauPokemon();
}

function sauvegarderPokecoins() {
    console.log('Base URL:', '<?= base_url("") ?>');
    console.log('URL complète:', '<?= base_url("combat/save_pokecoins.php") ?>');
    const url = '<?= base_url("combat/save_pokecoins.php") ?>';
    console.log('URL de sauvegarde:', url);
    console.log('Pokécoins à sauvegarder:', totalPokecoins);
    
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            pokecoins: totalPokecoins
        })
    })
    .then(response => {
        console.log('Status:', response.status);
        if (!response.ok) {
            throw new Error('Erreur HTTP: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Réponse:', data);
        if(!data.success) {
            throw new Error(data.error || 'Erreur inconnue');
        }
        console.log('Pokécoins sauvegardés avec succès!');
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur: Les pokécoins n\'ont pas pu être sauvegardés! ' + error.message);
    });
}

function startTimer() {
    if (interval !== null) return;
    
    killedPokemonsCount = 0;
    difficulty = 1;
    totalSecondes = 10;
    coinsGagnees = 0;
    
    btnStart.classList.add('d-none');
    gameContainer.classList.remove('d-none');
    gameOver.classList.add('d-none');
    
    killCountElement.textContent = killedPokemonsCount;
    difficultyElement.textContent = difficulty;
    timerElement.textContent = totalSecondes;
    damageDisplayElement.textContent = Math.floor(degatsParClic);

    chargerNouveauPokemon();
    
    interval = setInterval(updateTimer, 1000);
}

function updateTimer() {
    totalSecondes--;
    timerElement.textContent = totalSecondes;
    
    if (totalSecondes <= 0) {
        clearInterval(interval);
        interval = null;
        
        gameContainer.classList.add('d-none');
        gameOver.classList.remove('d-none');
        finalScoreElement.textContent = killedPokemonsCount;
        coinsEarnedElement.textContent = coinsGagnees;
        
        sauvegarderPokecoins();
    }
}

btnStart.addEventListener('click', startTimer);
btnRestart.addEventListener('click', startTimer);
pokemonSprite.addEventListener('click', attaquerPokemon);
</script>

<?php require_once base_path('components/footer.php')?>