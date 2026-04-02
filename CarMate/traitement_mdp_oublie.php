<?php

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

include('includes/db.php');

date_default_timezone_set('Europe/Paris');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    if (!isset($_POST['username']) || empty($_POST['username'])) {
        $errors['username'] = "Champ à remplir.";
    }else {
        $username = $_POST['username'];
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: mdp_oublie.php');
    exit();
}

$q = 'SELECT iduser, email FROM utilisateur WHERE nomUtilisateur = :username OR email = :username';
$statement = $bdd->prepare($q);
$statement->execute(['username' => $username]);
$user = $statement->fetch();

if ($user==false) {
    $_SESSION['flash_message'] = [
        'type' => 'danger',
        'message' => "Aucun compte n'a été retrouvé. Assurez-vous de l'orthographe. Sinon essayez de vous créer un compte."
    ];
    header('Location: mdp_oublie.php');
    exit();
}

$_SESSION['afficher'] = true;

$mailReceveur = trim($user['email']);

$token = bin2hex(random_bytes(32));
$tokenDate = date('Y-m-d H:i:s',time() + 3600);

$query = 'INSERT INTO token (idusertok, token, tokenDate) VALUES (:idusertok, :token, :tokenDate)';
$statement = $bdd -> prepare($query);
$statement -> execute([
    'idusertok' => $user['iduser'],
    'token' => $token,
    'tokenDate' => $tokenDate
]);

$mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'carmateoff@gmail.com';
        $mail->Password   = 'znhinxbqmowdluva';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('carmateoff@gmail.com', 'Mot de passe perdu');
        $mail->addAddress($mailReceveur);
        
        $mail->isHTML(true);
        $mail->Subject = 'CarMate - Mot de passe perdu'; 
        $mail->Body = '
        <div style= "background-color: #1a2a3d; padding: 35px; text-align: center;">
            <a  href="http://151.80.57.110/CarMate/reinitialisation_mdp.php?token=' . $token . '" style="color: white; text-decoration: none;">Cliquez <strong>ICI</strong> afin de finaliser la configuration de votre nouveau mot de passe CarMate.</a>
        </div>
        ';
        
        $mail->send();

        $_SESSION['email'] = $mailReceveur;
        $_SESSION['mailto'] = $user['iduser'];
        
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Un lien de réinitialisation de mot de passe vous a été envoyé à $mailReceveur."
        ];
        header('Location: connexion.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Le mail n'a pas pu être envoyé, veuillez réessayer. Erreur: " . $mail->ErrorInfo
        ];
        header('Location: mdp_oublie.php');
        exit();
    }

}

?>