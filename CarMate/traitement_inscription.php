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

    $reponseCaptcha = strtolower($_POST['captcha_response']);

    if (!isset($_POST['username']) || empty($_POST['username'])) {
        $errors['username'] = "Champ à remplir.";
    }
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['password'] = "Champ à remplir.";
    }
    if (!isset($_POST['passwordConfirmation']) || empty($_POST['passwordConfirmation'])) {
        $errors['passwordConfirmation'] = "Champ à remplir.";
    }
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors['email'] = "Champ à remplir.";
    }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Veuillez saisir un mail valide.";
    }

    if (!isset($_POST['dateNaissance']) || empty($_POST['dateNaissance'])) {
        $errors['dateNaissance'] = "Champ à remplir.";
    }
    if (!isset($_POST['ville']) || empty($_POST['ville'])) {
        $errors['ville'] = "Champ à remplir.";
    }
    if (!isset($_POST['rue']) || empty($_POST['rue'])) {
        $errors['rue'] = "Champ à remplir.";
    }
    if(!empty($_POST['password']) && !empty($_POST['passwordConfirmation']) && $_POST['password'] !== $_POST['passwordConfirmation']){
        $errors['passwordConfirmation'] = "Vous avez saisi 2 mots de passes différents";
        $errors['password'] = "Vous avez saisi 2 mots de passes différents";
    }
    if (strlen($_POST['password']) < 8) {
        $errors['password'] = "Le mot de passe doit contenir au moins 8 aractères";
        $errors['passwordConfirmation'] = "Le mot de passe doit contenir au moins 8 caractères";
    }
    if(!isset($_POST['captcha_response']) || $reponseCaptcha !== $_SESSION['captcha_answer']){
        $errors['captcha'] = "Réessayer";
    }


    if (!empty($_POST)) {
        $_SESSION['saisi'] = $_POST;
    }
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: inscription.php');
        exit();
    }

    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $ville = htmlspecialchars(trim($_POST['ville']));
    $rue = htmlspecialchars(trim($_POST['rue']));
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $q = 'SELECT iduser FROM utilisateur WHERE email = :email';
    $statement = $bdd->prepare($q);
    $statement->execute([
        'email' => $_POST['email']
    ]);
    $results = $statement->fetchAll();

    if (!empty($results)) {
        $errors['email'] = "L'adresse email est déjà utilisée.";
        $_SESSION['errors'] = $errors;
        header('Location: inscription.php');
        exit();
    }

    $code = rand(100000, 999999);

    $_SESSION['infoUser'] = [
        'username' => $username,
        'email' => $email,
        'dateNaissance' => $dateNaissance,
        'ville' => $ville,
        'rue' => $rue,
        'password' => $password
    ];
    $_SESSION['code'] = $code;

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
            'message' => "Un code de confirmation a été envoyé à $email."
        ];
        header('Location: code_verif.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "L'envoi du code de vérification à échoué : " . $mail->ErrorInfo
        ];
        header('Location: inscription.php');
        exit();
    }

}
?>