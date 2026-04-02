<?php
    session_start();

    include('includes/db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addcar'])) {
        $nom = htmlspecialchars(trim($_POST['nom']));
        $marque = htmlspecialchars(trim($_POST['marque']));
        $annee = $_POST['annee'];
        $prix = $_POST['prix'];
        $description = htmlspecialchars(trim($_POST['description']));
        $dimension = htmlspecialchars(trim($_POST['dimension']));
        $moteur = htmlspecialchars(trim($_POST['moteur']));
        $essence = htmlspecialchars(trim($_POST['essence']));
        $transmission = htmlspecialchars(trim($_POST['transmission']));
        $hybride = strtolower(trim($_POST['hybride'])) == 'oui' ? 1 : 0;
        $maniabilite = htmlspecialchars(trim($_POST['maniabilite']));
        $lien = htmlspecialchars(trim($_POST['lien']));

        $q = 'INSERT INTO voiture (nom, marque, annee, prix, description, dimension, moteur, essence, transmission, hybride, maniabilite, lien) 
        VALUES (:nom, :marque, :annee, :prix, :description, :dimension, :moteur, :essence, :transmission, :hybride, :maniabilite, :lien)';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([
            'nom' => $nom,
            'marque' => $marque,
            'annee' => $annee,
            'prix' => $prix,
            'description' => $description,
            'dimension' => $dimension,
            'moteur' => $moteur,
            'essence' => $essence,
            'transmission' => $transmission,
            'hybride' => $hybride,
            'maniabilite' => $maniabilite,
            'lien' => $lien
        ]);

        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Les valeurs ont été ajoutées avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Les valeurs n\'ont pas été ajoutées, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagecars');
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addquestion'])) {
        $descriptif = htmlspecialchars(trim($_POST['descriptif']));
        $tier = $_POST['tier'];

        $q = 'INSERT INTO question (descriptif, tier) VALUES (:descriptif, :tier)';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([
            'descriptif' => $descriptif,
            'tier' => $tier
        ]); 

        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Les valeurs ont été ajoutées avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Les valeurs n\'ont pas été ajoutées, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagequiz');
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addanswer'])) {
        $texte = htmlspecialchars(trim($_POST['texte']));
        $profil = $_POST['profil'];
        $numeroquestion = $_POST['numeroquestion'];

        $q = 'INSERT INTO optionrep (texte, profil, numeroquestion) VALUES (:texte, :profil, :numeroquestion)';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([
            'texte' => $texte,
            'profil' => $profil,
            'numeroquestion' => $numeroquestion
        ]); 

        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Les valeurs ont été ajoutées avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Les valeurs n\'ont pas été ajoutées, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagequiz');
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addcaptcha'])) {
        $questionCaptcha = htmlspecialchars(trim($_POST['questionCaptcha']));
        $reponseCaptcha = htmlspecialchars(trim($_POST['reponseCaptcha']));

        $q = 'INSERT INTO captcha (questionCaptcha, reponseCaptcha) VALUES (:questionCaptcha, :reponseCaptcha)';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([
            'questionCaptcha' => $questionCaptcha,
            'reponseCaptcha' => $reponseCaptcha
        ]); 

        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Les valeurs ont été ajoutées avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Les valeurs n\'ont pas été ajoutées, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagecaptcha');
        exit();
    }
?>