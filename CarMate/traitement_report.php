<?php
    session_start();

    include('includes/db.php');

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reportuser'])){
            $iduser = $_POST['reportuser'];

            $q = 'UPDATE utilisateur SET reports = reports + 1 WHERE iduser = :iduser';
            $statement = $bdd->prepare($q);
            $result = $statement->execute([
                'iduser' => $iduser
            ]);

            if ($result) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Le profil a été signalé avec succès.'
                ];
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'danger',
                    'message' => 'Le profil n\'a pas été signalé, veuillez réessayer.'
                ];
            }
            header('Location: profil_autre.php?id=' . $iduser);
            exit();
        }
?>