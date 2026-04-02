<?php
session_start();

include('includes/db.php');

if (isset($_POST['controler'])) {
    
    $mots_interdits = array_map('trim', file('blacklist.txt'));
    
    $_SESSION['messages_suspects'] = [];

    $q = 'SELECT idmessage, date, contenu, nomUtilisateur 
    FROM message INNER JOIN utilisateur ON idusermess = iduser
    WHERE date >= :date';
    $statement = $bdd->prepare($q);
    $statement->execute([
        'date' => $_POST['dateControl'],
    ]);
    $messages = $statement->fetchAll();
    
    foreach ($messages as $message) {
        foreach ($mots_interdits as $mot_interdit) {            
            if (stripos($message['contenu'], $mot_interdit) !== false) {
                $_SESSION['messages_suspects'][] = [
                    'id' => $message['idmessage'],
                    'date' => $message['date'],
                    'contenu' => $message['contenu'],
                    'expediteur' => $message['nomUtilisateur']
                ];
                break;
            }
        }
    }
}

header("Location: https://carmate.site//Backoffice/#pagemessages");
exit();
?>