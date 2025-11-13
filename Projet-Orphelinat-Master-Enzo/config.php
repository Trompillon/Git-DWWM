<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', __DIR__);
define('BASE_URL', '/Projet-Orphelinat-Master-Enzo');

function base_path($path = '') {
    return BASE_PATH . '/' . ltrim($path, '/');
}

function base_url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}
?>