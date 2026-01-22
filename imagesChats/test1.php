<?php
header('content-Type: text/plain; charset=utf-8');
echo "CONTENT_TYPE   = " . ($_SERVER['CONTENT_TYPE'] ?? 'null') . PHP_EOL;

    var_dump ($_POST);
    var_dump ($_FILES);
    echo 'size'. ini_get("post_max_size") . PHP_EOL;