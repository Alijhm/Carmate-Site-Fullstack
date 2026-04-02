<?php

$user='root';
$pass='root';

try {
    $bdd = new PDO(
        'mysql:host=localhost;dbname=projetannuel;port=3306',
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (Exception $e) {
    die('Erreur PDO : ' . $e->getMessage());
}
?>