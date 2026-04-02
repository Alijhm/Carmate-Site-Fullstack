<?php
    session_start();

    include('includes/db.php');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    switch($_POST['action']){
        
        case 'conn':
            $searchvalue = htmlspecialchars(trim($_POST['searchvalue']));
            if($searchvalue == 'oui' || $searchvalue == 'Oui' || $searchvalue == 'OUI'){
                $searchvalue = 1;
            }
            if($searchvalue == 'non' || $searchvalue == 'Non' || $searchvalue == 'NON'){
                $searchvalue = 0;
            }

            $_SESSION['listconn'] = array();
            if($searchvalue == 0 || $searchvalue == 1){
                $q = 'SELECT iduser, nomUtilisateur, email, connexion FROM utilisateur WHERE connexion = :searchvalue';
            }else{
                $q = 'SELECT iduser, nomUtilisateur, email, connexion FROM utilisateur WHERE nomUtilisateur = :searchvalue OR email = :searchvalue';
            }
            $statement = $bdd->prepare($q);
            $statement->execute(['searchvalue' => $searchvalue]);
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
            $searchvalue = htmlspecialchars(trim($_POST['searchvalue']));

            $_SESSION['listusers'] = array();
            $q = 'SELECT iduser, nomUtilisateur, dateDeNaissance, ville, rue, description, email, status FROM utilisateur
            WHERE nomUtilisateur = :searchvalue OR ville = :searchvalue OR rue = :searchvalue OR email = :searchvalue OR status = :searchvalue';
            $statement = $bdd->prepare($q);
            $statement->execute(['searchvalue' => $searchvalue]);
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
            $searchvalue = htmlspecialchars(trim($_POST['searchvalue']));
            if($searchvalue == 'oui' || $searchvalue == 'Oui' || $searchvalue == 'OUI'){
                $searchvalue = 1;
            }
            if($searchvalue == 'non' || $searchvalue == 'Non' || $searchvalue == 'NON'){
                $searchvalue = 0;
            }

            $_SESSION['listcars'] = array();
            if(is_numeric($searchvalue)){
                $q = 'SELECT idvoiture, nom, marque, annee, prix, description, dimension, moteur, essence, transmission, hybride, 
                maniabilite, image, lien FROM voiture
                WHERE annee = :searchvalue OR prix = :searchvalue OR hybride = :searchvalue';
            }else{
                $q = 'SELECT idvoiture, nom, marque, annee, prix, description, dimension, moteur, essence, transmission, hybride, 
                maniabilite, image, lien FROM voiture
                WHERE nom = :searchvalue OR marque = :searchvalue OR dimension = :searchvalue OR moteur = :searchvalue OR essence = :searchvalue
                OR transmission = :searchvalue OR lien = :searchvalue';
            }
            $statement = $bdd->prepare($q);
            $statement->execute(['searchvalue' => $searchvalue]);
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
            $searchvalue = htmlspecialchars(trim($_POST['searchvalue']));

            $_SESSION['listrights'] = array();
            $q = 'SELECT iduser, nomUtilisateur, email, status FROM utilisateur WHERE nomUtilisateur = :searchvalue OR email = :searchvalue OR status = :searchvalue';
            $statement = $bdd->prepare($q);
            $statement->execute(['searchvalue' => $searchvalue]);
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

        case 'reports':
            $searchvalue = htmlspecialchars(trim($_POST['searchvalue']));
            if($searchvalue == 'oui' || $searchvalue == 'Oui' || $searchvalue == 'OUI'){
                $searchvalue = "szqsdqsdzqsdqxcwffqs";
            }
            if($searchvalue == 'non' || $searchvalue == 'Non' || $searchvalue == 'NON'){
                $searchvalue = "cwvsdfqssdqsxwqw";
            }

            $_SESSION['listreports'] = array();
            if($searchvalue == "szqsdqsdzqsdqxcwffqs"){
                $searchvalue = 1;
                $q = 'SELECT iduser, nomUtilisateur, email, reports, ban FROM utilisateur WHERE ban = :searchvalue';
            }else if($searchvalue == "cwvsdfqssdqsxwqw"){
                $searchvalue = 0;
                $q = 'SELECT iduser, nomUtilisateur, email, reports, ban FROM utilisateur WHERE ban = :searchvalue';
            }else if(is_numeric($searchvalue)){
                $q = 'SELECT iduser, nomUtilisateur, email, reports, ban FROM utilisateur WHERE reports = :searchvalue';
            }else{
                $q = 'SELECT iduser, nomUtilisateur, email, reports, ban FROM utilisateur WHERE nomUtilisateur = :searchvalue OR email = :searchvalue';
            }
            $statement = $bdd->prepare($q);
            $statement->execute(['searchvalue' => $searchvalue]);
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
    }
    
    header('Location: https://carmate.site//Backoffice/#pagewelcome');
    exit();
?>