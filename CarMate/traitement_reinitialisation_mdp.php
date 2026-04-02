<?php 

session_start();
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $iduser = $_POST['iduser'] ?? $_SESSION['iduser'] ?? null;

    if (!isset($_POST['newpassword']) || empty($_POST['newpassword'])) {
        $errors['newpassword'] = "Champ à remplir.";
    }
    if (!isset($_POST['newpasswordConfirmation']) || empty($_POST['newpasswordConfirmation'])) {
        $errors['newpasswordConfirmation'] = "Champ à remplir.";
    }

    if(!empty($_POST['newpassword']) && !empty($_POST['newpasswordConfirmation']) && $_POST['newpassword'] !== $_POST['newpasswordConfirmation']){
        $errors['newpasswordConfirmation'] = "Vous avez saisi 2 mots de passes différents";
        $errors['newpassword'] = "Vous avez saisi 2 mots de passes différents";
    }
    if (strlen($_POST['newpassword']) < 8) {
        $errors['newpassword'] = "Le mot de passe doit contenir au moins 8 caractères";
        $errors['newpasswordConfirmation'] = "Le mot de passe doit contenir au moins 8 caractères";
    }
    

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: reinitialisation_mdp.php');
        exit();
    }

    $token = $_SESSION['token'];
    $query = 'SELECT idusertok, tokenDate FROM token WHERE token = :token AND tokenDate > NOW()';
    $statement = $bdd -> prepare($query);
    $statement -> execute((['token' => $token]));
    $result = $statement->fetch();

    if($result == false){        
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Le lien de réinitialisation est invalide ou a expiré"
        ];
        header('location: mdp_oublie.php');
        exit();
    }

    $iduser = $result['idusertok'];

    $newpassword = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);

    $query = 'UPDATE utilisateur SET motDePasse = :motDePasse WHERE iduser = :iduser';
    $statement = $bdd->prepare($query);
    $result = $statement->execute([
        'motDePasse' => $newpassword,
        'iduser' => $iduser
    ]);

    if ($result) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Votre mot de passe a été réinitialisé avec succès.'
        ];
        header('Location: connexion.php');
        exit();
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Le mot de passe n\'a pas pu être réinitialisé, veuillez réessayer.'
        ];
        header('Location: reinitialisation_mdp.php');
        exit();
    }
}

?>