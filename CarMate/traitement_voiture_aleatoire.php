<?php

include('includes/db.php');

$query = 'SELECT MAX(idvoiture) FROM voiture';
$statement = $bdd->prepare($query);
$statement->execute();
$results = $statement->fetchColumn();

$id_max = $results;

$id_aleatoire = rand(1,$id_max);

$query = 'SELECT idvoiture, nom, marque, annee, prix, description, dimension, moteur, essence, transmission, hybride, maniabilite, image FROM voiture WHERE idvoiture = :id_aleatoire';
$statement = $bdd->prepare($query);
$statement->execute([
    ':id_aleatoire' => $id_aleatoire
]);
$voiture = $statement->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['voitureId'])) {
    
    session_start();

    $query = 'SELECT COUNT(*) FROM dans_historique 
    WHERE iduserhis = :iduser AND nom = :nom';
    $statement = $bdd->prepare($query);
    $result= $statement->execute([
        ':iduser' => $_SESSION['iduser'],
        ':nom' => $_POST['voitureNom']
    ]);
    $compteur = $statement->fetchColumn();


    if ($compteur == 0) {
        $query = 'INSERT INTO dans_historique (iduserhis, nom, date, favori) VALUES (:iduserhis, :nom, :date, 1)';
        $statement = $bdd->prepare($query);
        $result2 = $statement->execute([
            'iduserhis' => $_SESSION['iduser'],
            'nom' => $_POST['voitureNom'],
            'date' => date('Y-m-d')
        ]);

        if($result2){
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => "Voiture ajoutée à vos favoris."
            ];
            header('Location: voiture_aleatoire.php');
            exit();
        }else{
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => "Erreur lors de l'ajout de la voiture aux favoris."
            ];
            header('Location: voiture_aleatoire.php');
            exit();
        }
        
    }else{
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Voiture déjà dans vos favoris."
        ];
        header('Location: voiture_aleatoire.php');
        exit();
    }

    header('location:voiture_aleatoire.php');
    exit();
}



?>