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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $errors = [];

    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Veuillez saisir votre mot de passe."
        ];
        header('Location: reglage.php');
        exit();
    }

    $password = $_POST['password'];

    $q = 'SELECT iduser, motDePasse FROM utilisateur WHERE iduser = :iduser';
    $statement = $bdd->prepare($q);
    $statement->execute([
        'iduser' => $_SESSION['iduser']
    ]);
    $user = $statement->fetch();

    if (!$user || !password_verify($password, $user['motDePasse'])) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Mot de passe incorrect."
        ];
        header('Location: reglage.php');
        exit();
    }

    $q = 'DELETE FROM avatar WHERE idavataruser = :iduser';
    $statement = $bdd->prepare($q);
    $statement->execute([
        'iduser' => $user['iduser']
    ]);
    $result = $statement->fetch();

    $q = 'DELETE FROM organise WHERE iduserorga = :iduser';
    $statement = $bdd->prepare($q);
    $statement->execute([
        'iduser' => $user['iduser']
    ]);
    $result = $statement->fetch();

    $q = 'DELETE FROM utilisateur WHERE iduser = :iduser';
    $statement = $bdd->prepare($q);
    $statement->execute([
        'iduser' => $user['iduser']
    ]);
    $result = $statement->fetch();

    session_destroy();

    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => "Votre compte a été supprimé avec succès."
    ];
    header('Location: index.php');
    exit();

}
?>