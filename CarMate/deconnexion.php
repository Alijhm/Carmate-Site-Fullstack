<?php

session_start();

include('includes/db.php');

$q = 'UPDATE utilisateur SET connexion = :connexion WHERE iduser = :iduser';
$statement = $bdd->prepare($q);
$result = $statement->execute([
    'connexion' => 0,
    'iduser' => $_SESSION['iduser']
]); 
session_unset(); 

session_destroy();

header('location: index.php');

exit();
?>