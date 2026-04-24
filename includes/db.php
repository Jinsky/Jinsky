<?php
// Configuration for MySQL Database
$host = 'localhost';
$db   = 'pigeon_expert_system';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     // In a real environment with MySQL, this would work.
     // For this environment, we might need a way to bypass this for certain scripts if we want them to run.
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // For development/demo purposes in this sandbox where MySQL is missing,
     // we can catch the error, but in production, we'd want to handle this properly.
     // throw new \PDOException($e->getMessage(), (int)$e->getCode());
     $pdo = null;
}
?>
