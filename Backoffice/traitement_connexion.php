<?php
    session_start();

    include('includes/db.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['connection'])){
        $errors = [];

        if (!isset($_POST['username']) || empty($_POST['username'])) {
            $errors['username'] = "Champ à remplir.";
        }
        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $errors['password'] = "Champ à remplir.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: index.php');
            exit();
        }
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        $q = 'SELECT iduser, motDePasse, status FROM utilisateur WHERE nomUtilisateur = :username OR email = :username';
        $statement = $bdd->prepare($q);
        $statement->execute(['username' => $username]);
        $user = $statement->fetch();

        if ($user && password_verify($password, $user['motDePasse'])) {
            if($user['status'] == "admin" || $user['status'] == "mod"){
                $_SESSION['user'] = $user['iduser'];
                $_SESSION['status'] = $user['status'];
            }
        }

        header('Location: https://carmate.site//Backoffice/#pagewelcome');
        exit();
    }

    header('location:index.php');
    exit();
?>