<?php
    session_start();

    include('includes/db.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pageConn'])){
        if($_POST['pageConn'] == 'plus'){
            $_SESSION['offsetConn'] += 10;
        }
        if($_POST['pageConn'] == 'moins'){
            $_SESSION['offsetConn'] -= 10;
        }
        if($_SESSION['offsetConn']<0){
            $_SESSION['offsetConn'] = 0;
        }
        
        $_SESSION['listconn'] = array();
        $q = 'SELECT iduser, nomUtilisateur, email, connexion FROM utilisateur LIMIT 10 OFFSET :offset';
        $statement = $bdd->prepare($q);
        $statement->bindValue(':offset', $_SESSION['offsetConn'], PDO::PARAM_INT);
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
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pageUsers'])){
        if($_POST['pageUsers'] == 'plus'){
            $_SESSION['offsetUsers'] += 10;
        }
        if($_POST['pageUsers'] == 'moins'){
            $_SESSION['offsetUsers'] -= 10;
        }
        if($_SESSION['offsetUsers']<0){
            $_SESSION['offsetUsers'] = 0;
        }

        $_SESSION['listusers'] = array();
        $q = 'SELECT iduser, nomUtilisateur, dateDeNaissance, ville, rue, description, email, status FROM utilisateur LIMIT 10 OFFSET :offset';
        $statement = $bdd->prepare($q);
        $statement->bindValue(':offset', $_SESSION['offsetUsers'], PDO::PARAM_INT);
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
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pageCars'])){
        if($_POST['pageCars'] == 'plus'){
            $_SESSION['offsetCars'] += 10;
        }
        if($_POST['pageCars'] == 'moins'){
            $_SESSION['offsetCars'] -= 10;
        }
        if($_SESSION['offsetCars']<0){
            $_SESSION['offsetCars'] = 0;
        }

        $_SESSION['listcars'] = array();
        $q = 'SELECT idvoiture, nom, marque, annee, prix, description, dimension, moteur, essence, transmission, hybride, maniabilite, image, lien FROM voiture LIMIT 10 OFFSET :offset';
        $statement = $bdd->prepare($q);
        $statement->bindValue(':offset', $_SESSION['offsetCars'], PDO::PARAM_INT);
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
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pageRights'])){
        if($_POST['pageRights'] == 'plus'){
            $_SESSION['offsetRights'] += 10;
        }
        if($_POST['pageRights'] == 'moins'){
            $_SESSION['offsetRights'] -= 10;
        }
        if($_SESSION['offsetRights']<0){
            $_SESSION['offsetRights'] = 0;
        }

        $_SESSION['listrights'] = array();
        $q = 'SELECT iduser, nomUtilisateur, email, status FROM utilisateur LIMIT 10 OFFSET :offset';
        $statement = $bdd->prepare($q);
        $statement->bindValue(':offset', $_SESSION['offsetRights'], PDO::PARAM_INT);
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
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pageQuestions'])){
        if($_POST['pageQuestions'] == 'plus'){
            $_SESSION['offsetQuestions'] += 10;
        }
        if($_POST['pageQuestions'] == 'moins'){
            $_SESSION['offsetQuestions'] -= 10;
        }
        if($_SESSION['offsetQuestions']<0){
            $_SESSION['offsetQuestions'] = 0;
        }

        $_SESSION['listquestions'] = array();
        $q = 'SELECT numero, descriptif, tier FROM question LIMIT 10 OFFSET :offset';
        $statement = $bdd->prepare($q);
        $statement->bindValue(':offset', $_SESSION['offsetQuestions'], PDO::PARAM_INT);
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

        header('Location: https://carmate.site//Backoffice/#pagequiz');
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pageAnswers'])){
        if($_POST['pageAnswers'] == 'plus'){
            $_SESSION['offsetAnswers'] += 10;
        }
        if($_POST['pageAnswers'] == 'moins'){
            $_SESSION['offsetAnswers'] -= 10;
        }
        if($_SESSION['offsetAnswers']<0){
            $_SESSION['offsetAnswers'] = 0;
        }

        $_SESSION['listanswers'] = array();
        $q = 'SELECT idoptionrep, texte, profil, numeroquestion FROM optionrep LIMIT 10 OFFSET :offset';
        $statement = $bdd->prepare($q);
        $statement->bindValue(':offset', $_SESSION['offsetAnswers'], PDO::PARAM_INT);
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
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pageCaptcha'])){
        if($_POST['pageCaptcha'] == 'plus'){
            $_SESSION['offsetCaptcha'] += 10;
        }
        if($_POST['pageCaptcha'] == 'moins'){
            $_SESSION['offsetCaptcha'] -= 10;
        }
        if($_SESSION['offsetCaptcha']<0){
            $_SESSION['offsetCaptcha'] = 0;
        }

        $_SESSION['listcaptcha'] = array();
        $q = 'SELECT idcaptcha, questionCaptcha, reponseCaptcha FROM captcha LIMIT 10 OFFSET :offset';
        $statement = $bdd->prepare($q);
        $statement->bindValue(':offset', $_SESSION['offsetCaptcha'], PDO::PARAM_INT);
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
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pageReports'])){
        if($_POST['pageReports'] == 'plus'){
            $_SESSION['offsetReports'] += 10;
        }
        if($_POST['pageReports'] == 'moins'){
            $_SESSION['offsetReports'] -= 10;
        }
        if($_SESSION['offsetReports']<0){
            $_SESSION['offsetReports'] = 0;
        }

        $_SESSION['listreports'] = array();
        $q = 'SELECT iduser, nomUtilisateur, email, reports, ban FROM utilisateur LIMIT 10 OFFSET :offset';
        $statement = $bdd->prepare($q);
        $statement->bindValue(':offset', $_SESSION['offsetReports'], PDO::PARAM_INT);
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
    }
?>