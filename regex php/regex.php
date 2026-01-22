<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$user = $_POST['user'] ?? '';
$mail = $_POST['mail'] ?? '';
$psw  = $_POST['password'] ?? '';

$regexUser = "/^[a-zA-Z0-9_]{3,16}$/";
$regexMail = "/^[a-zA-Z]+\.[a-zA-Z]+@[a-zA-Z]+\.[a-zA-Z]{2,4}$/i";
$regexPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};:'\",.<>\/?\\|`~]).{8,}$/";

if (!preg_match($regexUser, $user)) {
        $errors[] = "Nom d'utilisateur invalide";
    }

    if (!preg_match($regexMail, $mail)) {
        $errors[] = "Email invalide";
    }

    if (!preg_match($regexPassword, $psw)) {
        $errors[] = "Mot de passe invalide";
    }
}

?>