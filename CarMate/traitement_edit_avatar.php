<?php

session_start();

include('includes/db.php');

$iduser = $_SESSION['iduser'];
$tete = $_SESSION['avatar'];
$lunettes = $_SESSION['lunettes'] ?? null;
$chapeau = $_SESSION['chapeau'] ?? null;

$query = 'SELECT idavatar FROM avatar WHERE idavataruser = :iduser';
$statement = $bdd->prepare($query);
$statement->execute([
    'iduser' => $iduser
]);
$results = $statement->fetchAll();

if(!$results){
    $query = 'INSERT INTO avatar (tete, lunettes, chapeau, idavataruser) VALUES (:tete, :lunettes, :chapeau, :iduser)';
    $statement = $bdd->prepare($query);
    $statement->execute([
        'tete' => $tete,
        'lunettes' => $lunettes,
        'chapeau' => $chapeau,
        'iduser' => $iduser
    ]);
    $results = $statement->fetchAll();
}else{
    $query = 'UPDATE avatar SET tete = :tete, lunettes = :lunettes, chapeau = :chapeau WHERE idavataruser = :iduser';
    $statement = $bdd->prepare($query);
    $statement->execute([
        'tete' => $tete,
        'lunettes' => $lunettes,
        'chapeau' => $chapeau,
        'iduser' => $iduser
    ]);
    $results = $statement->fetchAll();
}

$_SESSION['avatar']=null;
$_SESSION['lunettes']=null;
$_SESSION['chapeau']=null;

if(isset($_POST['supAvatar'])){
    $q = 'DELETE FROM avatar WHERE idavataruser = :iduser';
    $statement = $bdd->prepare($q);
    $statement->execute([
        'iduser' => $_SESSION['iduser']
    ]);
    $result = $statement->fetch();

    header('location:profil.php');
    exit();
}

header('location:profil.php');
exit();

?>