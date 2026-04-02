<?php

session_start();

include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dateCreation = date('Y-m-d');

    $query = 'INSERT INTO offre (produit, prix, etat, description, categorie, dateCreation, iduser) 
    VALUES (:nom, :prix, :etat, :description, :categorie, :dateCreation, :iduser)';
    $statement = $bdd->prepare($query);
    $result = $statement->execute([
        'nom' => $_SESSION['nomProduit'],
        'prix' => $_SESSION['prixProduit'],
        'etat' => $_SESSION['etatProduit'],
        'description' => htmlspecialchars($_SESSION['descriptionProduit']),
        'categorie' => $_SESSION['categorieProduit'],
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
