<?php

// définir la base URL
define('BASE_URL', '/projetDWWM/');

session_start();
session_unset();
session_destroy();

header('Location: ' . BASE_URL . 'index.php');
exit;
