<?php

session_start();

include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    if (!isset($_POST['username']) || empty($_POST['username'])) {
        $errors['username'] = "Champ à remplir.";
    }
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['password'] = "Champ à remplir.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: connexion.php');
        exit();
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $q = 'SELECT iduser, motDePasse FROM utilisateur WHERE nomUtilisateur = :username OR email = :username';
    $statement = $bdd->prepare($q);
    $statement->execute(['username' => $username]);
    $user = $statement->fetch();

    if ($user && password_verify($password, $user['motDePasse'])) {
        $_SESSION['iduser'] = $user['iduser'];
        
        $query = 'SELECT nomUtilisateur, dateDeNaissance, ville, description FROM utilisateur WHERE iduser = :iduser';
        $statement = $bdd->prepare($query);
        $statement->execute(['iduser' => $user['iduser']]);
        $userInfo = $statement->fetch();

        $_SESSION['username'] = $userInfo['nomUtilisateur'];
        $_SESSION['dateNaissance'] = $userInfo['dateDeNaissance'];
        $_SESSION['ville'] = $userInfo['ville'];
        $_SESSION['descriptionEdit'] = $userInfo['description'];

        $_SESSION['derniereAction'] = time();

        $q = 'UPDATE utilisateur SET connexion = :connexion, derniereConnexion = NOW() WHERE iduser = :iduser';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([
            'connexion' => 1,
            'iduser' => $_SESSION['iduser']
        ]); 
        header('Location: index.php');
        exit();
    } else {
        $errors['login'] = "Identifiants incorrect.";
        $_SESSION['errors'] = $errors;
        header('Location: connexion.php');
        exit();
    }
}    
?>