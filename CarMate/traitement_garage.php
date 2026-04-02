<?php

session_start();

include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = 0;

    if (empty($_POST['nom']) || !isset($_POST['nom'])) {
        $errors = 1;
    }
    if (empty($_POST['categorie']) || !isset($_POST['categorie'])) {
        $errors = 1;
    }
    if (empty($_POST['prix']) || !isset($_POST['prix'])) {
        $errors = 1;
    }
    if (empty($_POST['etat']) || !isset($_POST['etat'])) {
        $errors = 1;
    }
    if (empty($_POST['description']) || !isset($_POST['description'])) {
        $errors = 1;
    }

    if ($errors == 1) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Veuillez correctement remplir l'ensemble des champs du formulaire"
        ];
        unset($_SESSION['formulaire']);
        header('Location: garage.php');
        exit();
    }

    $query = 'SELECT idvente FROM offre WHERE produit = :nom AND categorie = :categorie AND prix = :prix AND etat = :etat AND iduser = :iduser';
    $statement = $bdd->prepare($query);
    $statement->execute([
        'nom' => $_POST['nom'],
        'categorie' => $_POST['categorie'],
        'prix' => $_POST['prix'],
        'etat' => $_POST['etat'],
        'iduser' => $_SESSION['iduser']
    ]);
    $redondant = $statement->fetch();

    if($redondant == true){
        $_SESSION['nomProduit'] = $_POST['nom'];
        $_SESSION['categorieProduit'] = $_POST['categorie'];
        $_SESSION['prixProduit'] = $_POST['prix'];
        $_SESSION['etatProduit'] = $_POST['etat'];
        $_SESSION['descriptionProduit'] = $_POST['description'];

        $_SESSION['formulaire'] = 2;
        header('Location: garage.php');
        exit();
    }

    $dateCreation = date('Y-m-d');

    $query = 'INSERT INTO offre (produit, prix, etat, description, categorie, dateCreation, iduser) 
    VALUES (:nom, :prix, :etat, :description, :categorie, :dateCreation, :iduser)';
    $statement = $bdd->prepare($query);
    $result = $statement->execute([
        'nom' => $_POST['nom'],
        'prix' => $_POST['prix'],
        'etat' => $_POST['etat'],
        'description' => htmlspecialchars($_POST['description']),
        'categorie' => $_POST['categorie'],
        'dateCreation' => $dateCreation,
        'iduser' => $_SESSION['iduser']
    ]);

    if ($result === false) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Erreur lors de la mise en vente."
        ];
        unset($_SESSION['formulaire']);
        header('Location: garage.php');
        exit();
    }

    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => "Votre produit à bien été mis en vente !"
    ];
    unset($_SESSION['formulaire']);
    header('Location: garage.php');
    exit();

}

?>
