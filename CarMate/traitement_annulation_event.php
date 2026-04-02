<?php
    session_start();

    include('includes/db.php');

    $token = $_POST['token'] ?? null;
    $idevent = $_POST['idevent'] ?? null;
    
    $q = 'SELECT token, idusertok FROM token WHERE token = :token AND tokenDate > NOW()';
    $statement = $bdd->prepare($q);
    $statement->execute(['token' => $token]);
    $tokenRes = $statement->fetch();
    
    if (!$tokenRes) {
        $_SESSION['flash_message2'] = [
            'type' => 'danger',
            'message' => 'Lien invalide ou expiré.'
        ];
        header('Location: annulation_event.php');
        exit;
    }

    $q = 'SELECT evenement.titre, evenement.idevent, utilisateur.iduser
          FROM evenement 
          JOIN organise ON evenement.idevent = organise.ideventorga
          JOIN utilisateur ON organise.iduserorga = utilisateur.iduser
          WHERE utilisateur.iduser = :iduser AND evenement.idevent = :idevent';
    $statement = $bdd->prepare($q);
    $statement->execute([
        'iduser' => $tokenRes['idusertok'],
        'idevent' => $idevent,
    ]);
    $eventRes = $statement->fetch();

    $idevent = $eventRes['idevent'];
    $iduser = $eventRes['iduser'];

    try {     
        $q = 'DELETE FROM organise WHERE ideventorga = :idevent';
        $statement = $bdd->prepare($q);
        $statement->execute(['idevent' => $idevent]);
         
        $q = 'DELETE FROM evenement WHERE idevent = :idevent';
        $statement = $bdd->prepare($q);
        $statement->execute(['idevent' => $idevent]);
        
        $q = 'DELETE FROM token WHERE token = :token';
        $statement = $bdd->prepare($q);
        $statement->execute(['token' => $token]);
                
        $_SESSION['flash_message2'] = [
            'type' => 'success',
            'message' => 'Votre événement a bien été annulé.'
        ];
    } catch (Exception $e) {
        $_SESSION['flash_message2'] = [
            'type' => 'danger',
            'message' => 'Une erreur est survenue lors de l\'annulation de l\'événement.'
        ];
    }

    header('location:connexion.php');
    exit();
    
?>
