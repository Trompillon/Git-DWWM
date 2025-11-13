<?php 
require_once __DIR__ . '/../config.php';
require_once base_path('db.php');

if (isset($_SESSION['user_id'])) {

    echo '
        <li><a href="' . base_url('adoption/adoption.php') . '" class="text-white text-decoration-none">Adopter</a></li>
        <li><a href="' . base_url('combat/combattre.php') . '" class="text-white text-decoration-none">Combattre</a></li>
        <li><a href="' . base_url('pages/zoneDeCapture.php') . '" class="text-white text-decoration-none">Capturer</a></li>
        <li><a href="' . base_url('pages/recycler.php') . '" class="text-white text-decoration-none">Recycler</a></li>
    ';
    echo '
        <div class="position-absolute end-0 me-4 d-flex align-items-center gap-3">
            <a href="' . base_url('connexion/dashboard.php') . '" class="text-white text-decoration-none">Profile</a>
            <a href="' . base_url('connexion/deconnexion.php') . '" class="deco text-white text-decoration-none rounded px-3 py-2">
                Déconnexion
            </a>
        </div>
    ';
} else {
    echo '
        <div class="position-absolute end-0 me-4">
            <a href="' . base_url('connexion/connexion.php') . '" class="deco text-white text-decoration-none rounded px-3 py-2">
                Connexion
            </a>
        </div>
    ';
}
?>