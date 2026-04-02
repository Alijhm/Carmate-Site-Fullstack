<?php 

session_start();

include('includes/db.php');

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET['numMail'])) {
    $numMail = $_GET['numMail'];

    if($numMail === '1'){

        $email = $_SESSION['infoUser']['email'];
        $code = $_SESSION['code'];
    
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'carmateoff@gmail.com';
            $mail->Password   = 'znhinxbqmowdluva';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
    
            $mail->setFrom('carmateoff@gmail.com', 'Code de confirmation CarMate');
            $mail->addAddress($email);
            
            $mail->isHTML(true);
            $mail->Subject = 'CarMate - Code de confirmation';
            $mail->Body = '
            <div style= "background-color: #1a2a3d; padding: 35px; text-align: center;">
                <p style="color: white; text-decoration: none;">Votre code de confirmation est : <strong>'.$code.'</strong></p>;
            </div>
            ';
    
    
            $mail->send();
            
            $_SESSION['flash_message2'] = [
                'type' => 'success',
                'message' => "Un nouveau code de confirmation a été envoyé à $email."
            ];
            header('Location: code_verif.php');
            exit();
        } catch (Exception $e) {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => "L'envoi du nouveau code de vérification à échoué : " . $mail->ErrorInfo
            ];
            header('Location: code_verif.php');
            exit();
        }
    }elseif($numMail === '2'){
        
        $iduser = $_SESSION['mailto'];

        $query = 'SELECT email, iduser FROM utilisateur WHERE iduser = :iduser';
        $statement = $bdd->prepare($query);
        $statement->execute(['iduser' => $iduser]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

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
                <a  href="https://carmate.site//CarMate/reinitialisation_mdp.php?token=' . $token . '" style="color: white; text-decoration: none;">Cliquez <strong>ICI</strong> afin de finaliser la configuration de votre nouveau mot de passe CarMate.</a>
            </div>
            ';
            
            $mail->send();

            $_SESSION['email'] = $mailReceveur;
            $_SESSION['mailto'] = $user['iduser'];
            
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => "Un nouveau lien de réinitialisation de mot de passe vous a été envoyé à $mailReceveur."
            ];
            header('Location: connexion.php');
            exit();
        } catch (Exception $e) {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => "L'envoi du nouveau mail a échoué : " . $mail->ErrorInfo
            ];
            header('Location: conenxion.php');
            exit();
        }
    }
}

?>