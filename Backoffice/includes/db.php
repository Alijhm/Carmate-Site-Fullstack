<?php

$user='debian';
$pass='ProjetAnnuel';

try {
    $bdd = new PDO(
        'mysql:host=151.80.57.110;port=6464;dbname=projetannuel',
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "Connexion à la base de données réussie.";
} catch (Exception $e) {
    die('Erreur PDO : ' . $e->getMessage());
}
?>