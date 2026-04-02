<?php

session_start();

include('includes/db.php');

if (!isset($_SESSION['iduser'])) {
    $_SESSION['flash_message'] = [
        'type' => 'danger',
        'message' => "Veuillez vous connecter."
    ];
    header('Location: connexion.php');
    exit();
}

if(isset($_POST["sombre"])){
    $theme=0;

    $query = 'UPDATE utilisateur SET theme = 0 WHERE iduser = :iduser';
    $statement = $bdd->prepare($query);
    $result = $statement->execute([
        'iduser' => $_SESSION['iduser']
    ]);
    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Le mode sombre à bien été appliqué.'
    ];
    header('location:reglage.php');

}elseif(isset($_POST["clair"])){
    $theme=1;

    $query = 'UPDATE utilisateur SET theme = 1 WHERE iduser = :iduser';
    $statement = $bdd->prepare($query);
    $result = $statement->execute([
        'iduser' => $_SESSION['iduser']
    ]);
    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Le mode clair à bien été appliqué.'
    ];
    header('location:reglage.php');
}
?>
