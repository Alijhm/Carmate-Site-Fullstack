<?php 

session_start();

include('includes/db.php');

$errors = [];

$descriptionEdit = htmlspecialchars(trim($_POST['descriptionEdit']));
$voiturePrefGar = htmlspecialchars(trim($_POST['voiturePrefGar']));

$iduser = $_SESSION['iduser'];

$query = 'SELECT description FROM utilisateur WHERE iduser = :iduser';
$statement = $bdd->prepare($query);
$statement->execute(['iduser' => $iduser]);
$descriptionExistence = $statement->fetchColumn();

$query = 'SELECT nomposs FROM possede_voiture WHERE iduserposs = :iduser';
$statement = $bdd->prepare($query);
$statement->execute(['iduser' => $iduser]);
$voiturePrefGarExistence = $statement->fetchColumn();

if (!empty($descriptionEdit)) {
    if ($descriptionExistence!==false) {
        $query = 'UPDATE utilisateur SET description = :descriptionEdit WHERE iduser = :iduser';
        $statement = $bdd->prepare($query);
        $result = $statement->execute([
            'descriptionEdit' => $descriptionEdit,
            'iduser' => $iduser
        ]);
        $_SESSION['descriptionEdit'] = $descriptionEdit;
    }else{
        $query = 'INSERT INTO utilisateur (description) VALUES (:description)';
        $statement = $bdd->prepare($query);
        $result = $statement->execute([
            'descriptionEdit' => $descriptionEdit,
            'iduser' => $iduser
        ]);
        $_SESSION['descriptionEdit'] = $descriptionEdit;
    }
}


if (!empty($voiturePrefGar)) {

    $query = 'SELECT nom FROM voiture WHERE nom = :nom';
    $statement = $bdd->prepare($query);
    $statement->execute(['nom' => $voiturePrefGar]);
    $voitureExistence = $statement->fetchColumn();

    if($voitureExistence == false){
        $query = 'INSERT INTO voiture (nom) VALUES (:nom)';
        $statement = $bdd->prepare($query);
        $result = $statement->execute([
            'nom' => $voiturePrefGar
        ]);
    }

    if ($voiturePrefGarExistence !== false) {
        $query = 'UPDATE possede_voiture SET nomposs = :nomposs WHERE iduserposs = :iduserposs';
        $statement = $bdd->prepare($query);
        $result = $statement->execute([
            'iduserposs' => $iduser,
            'nomposs' => $voiturePrefGar
        ]);
        $_SESSION['voiturePrefGar'] = $voiturePrefGar;
    }else{
        $query = 'INSERT INTO possede_voiture (iduserposs, nomposs) VALUES (:iduserposs, :nomposs)';
        $statement = $bdd->prepare($query);
        $result = $statement->execute([
            'iduserposs' => $iduser,
            'nomposs' => $voiturePrefGar
        ]);
        $_SESSION['voiturePrefGar'] = $voiturePrefGar;
    }
}

header('Location: profil.php');
exit();

?>

