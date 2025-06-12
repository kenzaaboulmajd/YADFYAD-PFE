<?php
$host = 'localhost';
$db = 'yadfyad';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
  $pdo = new PDO($dsn, $user, $pass);
} catch (\PDOException $e) {
  // Never show full error in production
  echo "Connection failed: " . $e->getMessage();
}
