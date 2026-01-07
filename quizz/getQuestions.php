<?php

header("Content-Type: application/json");

require 'db.php';

$sql = "SELECT * FROM questions WHERE `id` = ROUND( RAND() * 140 ) + 1";
$stmt = $pdo->prepare($sql);
        $stmt->execute();
        $questions = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($questions, JSON_UNESCAPED_UNICODE);

?>