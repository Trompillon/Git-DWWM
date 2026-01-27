<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$nbUsers = $_POST['number'];

$apiData = file_get_contents("https://randomuser.me/api/?results=$nbUsers");
$users = json_decode($apiData, true);

foreach($users['results'] as $user){
        $insert = $pdo->prepare("INSERT INTO users (first_name, last_name, phone, email, address, picture_url) VALUES (:first_name, :last_name, :phone, :email, :address, :picture_url)");
        $insert->execute([
            'first_name' => $user['name']['first'],
            'last_name' => $user['name']['last'],
            'phone' => $user['phone'],
            'email' => $user['email'],
            'address' => $user['location']['street']['number'] . ' ' . $user['location']['street']['name'] . ', ' . $user['location']['city'],
            'picture_url' => $user['picture']['thumbnail'],
        ]);
    }

    echo "$nbUsers utilisateurs ajoutés !";
}

?>