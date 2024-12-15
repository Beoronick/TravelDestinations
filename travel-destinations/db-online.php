<?php


try {
    $host = 'sql108.infinityfree.com';
    $db   = 'if0_37923247_destinations';
    $user = 'if0_37923247';
    $pass = 'jYkVHJ099rr';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES   => false, 
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

?>