<?php
    session_start();

    include('includes/db.php');

    switch($_POST['action']){

        case 'conn':
            $q = 'SELECT COUNT(*) FROM utilisateur WHERE connexion = 1';
            $statement = $bdd->prepare($q);
            $statement->execute();
            $_SESSION['total'] = $statement->fetchColumn();

            $_SESSION['offsetConn'] = 0;
            $_SESSION['listconn'] = array();
            $q = 'SELECT iduser, nomUtilisateur, email, connexion FROM utilisateur LIMIT 10';
            $statement = $bdd->prepare($q);
            $statement->execute();
            $results = $statement->fetchAll();
            foreach($results as $user){
                $userConn = array([
                    'iduser' => $user['iduser'],
                    'nomUtilisateur' => $user['nomUtilisateur'],
                    'email' => $user['email'],
                    'connexion' => $user['connexion']
                ]);
                $_SESSION['listconn'][] = $userConn;
            }

            header('Location: https://carmate.site//Backoffice/#pageconnexion');
            exit();
            break;

        case 'users':
            $_SESSION['offsetUsers'] = 0;
            $_SESSION['listusers'] = array();
            $q = 'SELECT iduser, nomUtilisateur, dateDeNaissance, ville, rue, description, email, status FROM utilisateur LIMIT 10';
            $statement = $bdd->prepare($q);
            $statement->execute();
            $results = $statement->fetchAll();
            foreach($results as $user){
                $registeredUser = array([
                    'iduser' => $user['iduser'],
                    'nomUtilisateur' => $user['nomUtilisateur'],
                    'dateDeNaissance' => $user['dateDeNaissance'],
                    'ville' => $user['ville'],
                    'rue' => $user['rue'],
                    'description' => $user['description'],
                    'email' => $user['email'],
                    'status' => $user['status']
                ]);
                $_SESSION['listusers'][] = $registeredUser;
            }

            header('Location: https://carmate.site//Backoffice/#pageusers');
            exit();
            break;

        case 'cars':
            $_SESSION['offsetCars'] = 0;
            $_SESSION['listcars'] = array();
            $q = 'SELECT idvoiture, nom, marque, annee, prix, description, dimension, moteur, essence, transmission, hybride, maniabilite, image, lien FROM voiture LIMIT 10';
            $statement = $bdd->prepare($q);
            $statement->execute();
            $results = $statement->fetchAll();
            foreach($results as $car){
                $registeredCar = array([
                    'idvoiture' => $car['idvoiture'],
                    'nom' => $car['nom'],
                    'marque' => $car['marque'],
                    'annee' => $car['annee'],
                    'prix' => $car['prix'],
                    'description' => $car['description'],
                    'dimension' => $car['dimension'],
                    'moteur' => $car['moteur'],
                    'essence' => $car['essence'],
                    'transmission' => $car['transmission'],
                    'hybride' => $car['hybride'],
                    'maniabilite' => $car['maniabilite'],
                    'image' => $car['image'],
                    'lien' => $car['lien']
                ]);
                $_SESSION['listcars'][] = $registeredCar;
            }

            header('Location: https://carmate.site//Backoffice/#pagecars');
            exit();
            break;

        case 'rights':
            $_SESSION['offsetRights'] = 0;
            $_SESSION['listrights'] = array();
            $q = 'SELECT iduser, nomUtilisateur, email, status FROM utilisateur LIMIT 10';
            $statement = $bdd->prepare($q);
            $statement->execute();
            $results = $statement->fetchAll();
            foreach($results as $user){
                $userRights = array([
                    'iduser' => $user['iduser'],
                    'nomUtilisateur' => $user['nomUtilisateur'],
                    'email' => $user['email'],
                    'status' => $user['status']
                ]);
                $_SESSION['listrights'][] = $userRights;
            }

            header('Location: https://carmate.site//Backoffice/#pagerights');
            exit();
            break;

        case 'quiz':
            $_SESSION['offsetQuestions'] = 0;
            $_SESSION['listquestions'] = array();
            $q = 'SELECT numero, descriptif, tier FROM question LIMIT 10';
            $statement = $bdd->prepare($q);
            $statement->execute();
            $results = $statement->fetchAll();
            foreach($results as $question){
                $questionValues = array([
                    'numero' => $question['numero'],
                    'descriptif' => $question['descriptif'],
                    'tier' => $question['tier']
                ]);
                $_SESSION['listquestions'][] = $questionValues;
            }

            $_SESSION['offsetAnswers'] = 0;
            $_SESSION['listanswers'] = array();
            $q = 'SELECT idoptionrep, texte, profil, numeroquestion FROM optionrep LIMIT 10';
            $statement = $bdd->prepare($q);
            $statement->execute();
            $results = $statement->fetchAll();
            foreach($results as $answer){
                $answerValues = array([
                    'idoptionrep' => $answer['idoptionrep'],
                    'texte' => $answer['texte'],
                    'profil' => $answer['profil'],
                    'numeroquestion' => $answer['numeroquestion']
                ]);
                $_SESSION['listanswers'][] = $answerValues;
            }

            header('Location: https://carmate.site//Backoffice/#pagequiz');
            exit();
            break;
    
        case 'captcha':
            $_SESSION['offsetCaptcha'] = 0;
            $_SESSION['listcaptcha'] = array();
            $q = 'SELECT idcaptcha, questionCaptcha, reponseCaptcha FROM captcha LIMIT 10';
            $statement = $bdd->prepare($q);
            $statement->execute();
            $results = $statement->fetchAll();
            foreach($results as $captcha){
                $captchaValues = array([
                    'idcaptcha' => $captcha['idcaptcha'],
                    'questionCaptcha' => $captcha['questionCaptcha'],
                    'reponseCaptcha' => $captcha['reponseCaptcha']
                ]);
                $_SESSION['listcaptcha'][] = $captchaValues;
            }

            header('Location: https://carmate.site//Backoffice/#pagecaptcha');
            exit();
            break;

        case 'reports':
            $_SESSION['offsetReports'] = 0;
            $_SESSION['listreports'] = array();
            $q = 'SELECT iduser, nomUtilisateur, email, reports, ban FROM utilisateur LIMIT 10';
            $statement = $bdd->prepare($q);
            $statement->execute();
            $results = $statement->fetchAll();
            foreach($results as $user){
                $userReports = array([
                    'iduser' => $user['iduser'],
                    'nomUtilisateur' => $user['nomUtilisateur'],
                    'email' => $user['email'],
                    'reports' => $user['reports'],
                    'ban' => $user['ban']
                ]);
                $_SESSION['listreports'][] = $userReports;
            }

            header('Location: https://carmate.site//Backoffice/#pagereports');
            exit();
            break;
        
        case 'messages':

            header('Location: https://carmate.site//Backoffice/#pagemessages');
            exit();
            break;
        
        case 'mails':

            header('Location: https://carmate.site//Backoffice/#pagemails');
            exit();
            break;
    }

    header('Location: https://carmate.site//Backoffice/#pagewelcome');
    exit();
?>