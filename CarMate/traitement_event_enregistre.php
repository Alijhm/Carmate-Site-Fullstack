<?php 

session_start();

include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['action']) && $_POST['action'] == 'like' || $_POST['action'] == 'like2') {
        $query = 'SELECT COUNT(*) FROM inscrit 
        WHERE idusersub = :iduser AND ideventsub = :idevent';
        $statement = $bdd->prepare($query);
        $result= $statement->execute([
            ':iduser' => $_SESSION['iduser'],
            ':idevent' => $_POST['eventid'],
        ]);
        $compteur = $statement->fetchColumn();

        if ($compteur == 0) {
            $query = 'INSERT INTO inscrit (idusersub, ideventsub) VALUES (:idusersub, :ideventsub)';
            $statement = $bdd->prepare($query);
            $result2 = $statement->execute([
                'idusersub' => $_SESSION['iduser'],
                'ideventsub' => $_POST['eventid'],
            ]);

            $query = 'UPDATE evenement SET likes = likes + 1 WHERE idevent = :idevent';
            $statement = $bdd->prepare($query);
            $result2 = $statement->execute([
                'idevent' => $_POST['eventid'],
            ]);

            if($result2){
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => "Événement enregistré."
                ];
                if($_POST['action'] == 'like'){
                    header('Location: event.php');
                    exit();
                }else{
                    header('Location: event_postFiltre.php');
                    exit();
                }
            }else{
                $_SESSION['flash_message'] = [
                    'type' => 'danger',
                    'message' => "Erreur lors de l'enregistrement de l'événement'."
                ];
                if($_POST['action'] == 'like'){
                    header('Location: event.php');
                    exit();
                }else{
                    header('Location: event_postFiltre.php');
                    exit();
                }
            }
            
        }else{
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => "Événement déjà enregistré."
            ];
            if($_POST['action'] == 'like'){
                header('Location: event.php');
                exit();
            }else{
                header('Location: event_postFiltre.php');
                exit();
            }
        }
    }

}
?>