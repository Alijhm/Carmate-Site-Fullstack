<?php

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

include('includes/db.php');

if (isset($_POST['envoyer'])) {

    $q = 'SELECT iduser, nomUtilisateur, email
    FROM utilisateur
    WHERE derniereConnexion < :dateLimite';
    $statement = $bdd->prepare($q);
    $statement->execute([
        'dateLimite' => $_POST['dateLimite'],
    ]);
    $users = $statement->fetchAll();

    $_SESSION['utilisateurs_concernes'] = [];

    foreach ($users as $user) {
        $_SESSION['utilisateurs_concernes'][] = [
            'id' => $user['iduser'],
            'nom' => $user['nomUtilisateur'],
            'email' => $user['email'],
        ];

        $email = $user['email'];

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->CharSet = 'UTF-8';
            $mail->Username   = 'carmateoff@gmail.com';
            $mail->Password   = 'znhinxbqmowdluva';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('carmateoff@gmail.com', 'Vous manquez à CarMate');
            $mail->addAddress($email);
            
            $mail->isHTML(true);
            $mail->Subject = 'CarMate - Vous manquez à CarMate';
            $mail->Body = '
            <div style= "background-color: #1a2a3d; padding: 35px; text-align: center;">
                <p style="color: white; text-decoration: none;">Cela fait depuis le ' . $_POST['dateLimite'] . ' que vous ne vous êtes pas connecté à votre compte CarMate. N\'hésitez pas à venir nous rendre visite et à profiter de la variété des services proposés.<br>Tout passionné d\'automobile trouve de quoi se plaire sur CarMate !<br><br>À très vite !</p>;
            </div>
            ';


            $mail->send();
            
        } catch (Exception $e) {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => "L'envoi de certains mails a échoué."
            ];
        }
    }
        
    
    
}

header("Location: https://carmate.site//Backoffice/#pagemails");
exit();
?>