<?php

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    if (empty($_POST['titre']) || !isset($_POST['titre'])) {
        $errors['titre'] = "Veuillez correctement remplir ce champ.";
    }
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || !isset($_POST['email'])) {
        $errors['email'] = "Veuillez correctement remplir ce champ.";
    }
    if (empty($_POST['dateDebut']) || $_POST['dateDebut'] < date('Y-m-d') || $_POST['dateDebut'] > date('2035-12-31') || !isset($_POST['dateDebut'])) {
        $errors['dateDebut'] = "Veuillez correctement remplir ce champ.";
    }
    if (empty($_POST['dateFin']) || $_POST['dateFin'] < date('Y-m-d') || $_POST['dateFin'] > date('2035-12-31') || !empty($_POST['dateDebut']) && !empty($_POST['dateFin']) && $_POST['dateFin'] < $_POST['dateDebut'] || !isset($_POST['dateFin'])) {
        $errors['dateFin'] = "Veuillez correctement remplir ce champ.";
    }
    if (empty($_POST['ville']) || !isset($_POST['ville'])) {
        $errors['ville'] = "Veuillez correctement remplir ce champ.";
    }
    if (empty($_POST['rue']) || !isset($_POST['rue'])) {
        $errors['rue'] = "Veuillez correctement remplir ce champ.";
    }
    if (empty($_POST['duree']) || !in_array($_POST['duree'], ['-30min', '-1h', '-2h', '+2h']) || !isset($_POST['duree'])) {
        $errors['duree'] = "Veuillez correctement remplir ce champ.";
    }
    if (!isset($_POST['prix']) || !is_numeric($_POST['prix']) || $_POST['prix'] < 0) {
        $errors['prix'] = "Veuillez correctement remplir ce champ.";
    }
    if (!isset($_POST['capacite']) || !is_numeric($_POST['capacite']) || $_POST['capacite'] < 1 || empty($_POST['capacite'])) {
        $errors['capacite'] = "Veuillez correctement remplir ce champ.";
    }
    if (empty($_POST['type']) || !isset($_POST['type'])) {
        $errors['type'] = "Veuillez correctement remplir ce champ.";
    }
    if (strlen($_POST['description']) > 255 || !isset($_POST['description'])) {
        $errors['description'] = "Veuillez correctement remplir ce champ.";
    }
    if (!isset($_POST['attestation']) || !isset($_POST['attestation'])) {
        $errors['attestation'] = "";
    }

    if (!empty($_POST)) {
        $_SESSION['saisi'] = $_POST;
    }
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: event.php');
        exit();
    }

    $titre = htmlspecialchars(trim($_POST['titre']));
    $email = htmlspecialchars(trim($_POST['email']));
    $dateDebut = htmlspecialchars(trim($_POST['dateDebut']));
    $dateFin = htmlspecialchars(trim($_POST['dateFin']));
    $ville = htmlspecialchars(trim($_POST['ville']));
    $rue = htmlspecialchars(trim($_POST['rue']));
    $duree = htmlspecialchars(trim($_POST['duree']));
    $prix = htmlspecialchars(trim($_POST['prix']));
    $capacite = htmlspecialchars(trim($_POST['capacite']));
    $type = htmlspecialchars(trim($_POST['type']));
    $description = htmlspecialchars(trim($_POST['description']));

    $query = 'SELECT idevent FROM evenement WHERE titre = :titre AND dateDebut = :dateDebut AND dateFin = :dateFin AND ville = :ville AND rue = :rue AND duree = :duree AND prixEntree = :prixEntree AND type = :type';
    $statement = $bdd->prepare($query);
    $statement->execute([
        'titre' => $_POST['titre'],
        'dateDebut' => $_POST['dateDebut'],
        'dateFin' => $_POST['dateFin'],
        'ville' => $_POST['ville'],
        'rue' => $_POST['rue'],
        'duree' => $_POST['duree'],
        'prixEntree' => $_POST['prix'],
        'type' => $_POST['type']
    ]);
    $redondant = $statement->fetch();

    if($redondant == true){
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Votre événement est déjà proposé par CarMate."
        ];
        unset($_SESSION['saisi']);
        header('Location: event.php');
        exit();
    }

    $query = 'INSERT INTO evenement (titre, dateDebut, dateFin, ville, rue, duree, prixEntree, nbPlaces, type, description) 
    VALUES (:titre, :dateDebut, :dateFin, :ville, :rue, :duree, :prixEntree, :nbPlaces, :type, :description)';
    $statement = $bdd->prepare($query);
    $result = $statement->execute([
        'titre' => $titre,
        'dateDebut' => $dateDebut,
        'dateFin' => $dateFin,
        'ville' => $ville,
        'rue' => $rue,
        'duree' => $duree,
        'prixEntree' => $prix,
        'nbPlaces' => $capacite,
        'type' => $type,
        'description' => $description
    ]);

    $iduserorga = $_SESSION['iduser'];
    $ideventorga = $bdd->lastInsertId();

    $query = 'INSERT INTO organise (iduserorga, ideventorga) 
    VALUES (:iduserorga, :ideventorga)';
    $statement = $bdd->prepare($query);
    $result = $statement->execute([
        'iduserorga' => $iduserorga,
        'ideventorga' => $ideventorga
    ]);

    if ($result === false) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Erreur lors de l'enregistrement de l'événement."
        ];
        unset($_SESSION['saisi']);
        header('Location: event.php');
        exit();
    }

    $dateDebutEnTime = strtotime($dateDebut);
    $token = bin2hex(random_bytes(32));
    $tokenDate = date('Y-m-d H:i:s',$dateDebutEnTime - 172800);

    $userId = $_SESSION['iduser'];

    $query = 'INSERT INTO token (idusertok, token, tokenDate) VALUES (:idusertok, :token, :tokenDate)';
    $statement = $bdd -> prepare($query);
    $statement -> execute([
        'idusertok' => $userId,
        'token' => $token,
        'tokenDate' => $tokenDate
    ]);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'carmateoff@gmail.com';
        $mail->Password   = 'znhinxbqmowdluva';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('carmateoff@gmail.com', 'Confirmation de mise en avant par CarMate');
        $mail->addAddress($email);
        
        $mail->isHTML(true);
        $mail->Subject = 'CarMate - Confirmation de mise en avant de votre "$titre"';
        $mail->Body = '
        <div style="background-color: #1a2a3d; padding: 35px; text-align: left; color: white; font-family: Arial, sans-serif;">
            <h2 style="text-align: center;">Confirmation de votre événement</h2>
            <p>Votre événement est désormais bien mis en avant par CarMate. Voici les informations que vous avez saisies :</p>
            <ul style="list-style: none; padding-left: 0;">
                <li><strong>Titre :</strong> ' . htmlspecialchars($titre) . '</li>
                <li><strong>Date de début :</strong> ' . htmlspecialchars($dateDebut) . '</li>
                <li><strong>Date de fin :</strong> ' . htmlspecialchars($dateFin) . '</li>
                <li><strong>Ville :</strong> ' . htmlspecialchars($ville) . '</li>
                <li><strong>Rue :</strong> ' . htmlspecialchars($rue) . '</li>
                <li><strong>Durée :</strong> ' . htmlspecialchars($duree) . '</li>
                <li><strong>Prix d\'entrée :</strong> ' . htmlspecialchars($prix) . ' €</li>
                <li><strong>Capacité :</strong> ' . htmlspecialchars($capacite) . ' personnes</li>
                <li><strong>Type :</strong> ' . htmlspecialchars($type) . '</li>
                <li><strong>Description :</strong> ' . htmlspecialchars($description) . '</li>
            </ul>

            <div style="padding-top:40px">
                <p><small>Un imprévu qui viens contrarier le bon déroulement de votre événement ? Si jamais vous êtes contraints d\'annuler l\'événement, <strong><a style="text-decoration:none;color:white;" href="https://carmate.site//CarMate/annulation_event.php?token=' . $token . '&idevent=' . $ideventorga . '">cliquez ici</a></strong>. Attention, aucun événement ne peut être annuler à moins de 2 jours de la date de début de l\'événement !</small></p>
            </div>
        </div>
    ';

        $mail->send();
        
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Événement créé avec succès ! Un mail de confirmation a été envoyé à $email."
        ];

    } catch (Exception $e) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "L'envoi du mail de confirmation à échoué : " . $mail->ErrorInfo
        ];

    }

    header('Location: event.php?pdf=true');
    exit();
    
}

?>
