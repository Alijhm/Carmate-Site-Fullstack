<?php 
include('includes/db.php');

if(isset($_SESSION['iduser'])){
    $q = 'SELECT theme FROM utilisateur WHERE iduser = :iduser';
    $statement = $bdd->prepare($q);
    $statement->execute(['iduser' => $_SESSION['iduser']]);
    $result = $statement->fetch();

    $themeSombreClair = $result['theme'];
}
?>