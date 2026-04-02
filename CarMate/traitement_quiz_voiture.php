<?php

session_start();

include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['lancerQuiz'])){
        $_SESSION['compteur']=1;

        $_SESSION['profils'] = [
            'écologique' => 0,
            'luxe' => 0,
            'familiale' => 0,
            'aventurière' => 0,
            'sportive' => 0
        ];
    }

    if(isset($_POST['reponseQuiz'])){
        $profil = $_POST['reponseQuiz'];

        $_SESSION['profils'][$profil]++;

        $_SESSION['compteur']+=1;
    }

    if(isset($_SESSION['compteur']) && $_SESSION['compteur']<=10){

        $q = 'SELECT descriptif FROM question WHERE numero = :compteur';
        $statement = $bdd->prepare($q);
        $statement->execute([
            'compteur' => $_SESSION['compteur']
        ]);
        $question = $statement->fetchColumn();

        $_SESSION['question'] = $question;

        $q = 'SELECT texte, profil FROM optionrep INNER JOIN question ON numeroquestion = numero WHERE numero = :compteur';
        $statement = $bdd->prepare($q);
        $statement->execute([
            'compteur' => $_SESSION['compteur']
        ]);
        $reponse = $statement->fetchAll(PDO::FETCH_ASSOC);

        $_SESSION['reponse'] = $reponse;

        header('location:voiture.php');
        exit();
        
    }

    if($_SESSION['compteur'] == 11){
        $profils = array_values($_SESSION['profils']);
        $max = max($profils);
        $ocurence = 0;
        $profilEgaux = [];
        
        $cle = array_keys($_SESSION['profils']);
        for ($i = 0; $i < count($profils); $i++) {
            if ($profils[$i] === $max) {
                $ocurence++;
                $profilEgaux[]=$cle[$i];
            }
        }
    
        if ($ocurence >= 2) {
            $q = 'SELECT descriptif FROM question WHERE numero = 11';
            $statement = $bdd->prepare($q);
            $statement->execute([]);
            $question = $statement->fetchColumn();

            $_SESSION['question'] = $question;

            $q = 'SELECT texte, profil FROM optionrep WHERE numeroquestion = 11';
            $statement = $bdd->prepare($q);
            $statement->execute([]);
            $reponses = $statement->fetchAll(PDO::FETCH_ASSOC);

            $reponsesProfilsADepartager = [];
            foreach($reponses as $reponse){
                if(in_array($reponse['profil'],$profilEgaux)){
                    $reponsesProfilsADepartager[] = $reponse;
                }
            }

            $_SESSION['reponse'] = $reponsesProfilsADepartager;

            header('location:voiture.php');
            exit();
        } 
    }

    if($_SESSION['compteur'] == 11 && $ocurence == 1 || $_SESSION['compteur'] >= 12){
        $premierProfil = '';
        $compteurProfilMax = -1;

        foreach($_SESSION['profils'] as $profil => $compteur){
            if($compteur > $compteurProfilMax){
                $compteurProfilMax = $compteur;
                $premierProfil = $profil;
            }
        }

        if(!isset($_SESSION['tier'])){
            if($premierProfil == 'écologique'){
                $_SESSION['tier'] = 3;
                $_SESSION['numero'] = 12;
            }elseif($premierProfil == 'luxe'){
                $_SESSION['tier'] = 4;
                $_SESSION['numero'] = 16;
            }elseif($premierProfil == 'familiale'){
                $_SESSION['tier'] = 5;
                $_SESSION['numero'] = 20;
            }elseif($premierProfil == 'aventurière'){
                $_SESSION['tier'] = 6;
                $_SESSION['numero'] = 24;
            }elseif($premierProfil == 'sportive'){
                $_SESSION['tier'] = 7;
                $_SESSION['numero'] = 28;
            }
        }

        if(!isset($_SESSION['compteur2'])){
            $_SESSION['compteur2']=1;

            $_SESSION['profils'] = [
                'écologique' => 0,
                'luxe' => 0,
                'familiale' => 0,
                'aventurière' => 0,
                'sportive' => 0
            ];
        }

        if($_SESSION['compteur2'] <= 4){

            $q = 'SELECT descriptif FROM question WHERE numero = :numero';
            $statement = $bdd->prepare($q);
            $statement->execute([
                'numero' => $_SESSION['numero']
            ]);
            $question = $statement->fetchColumn();

            $_SESSION['question'] = $question;

            $q = 'SELECT texte, profil FROM optionrep INNER JOIN question ON numeroquestion = numero WHERE numero = :numero';
            $statement = $bdd->prepare($q);
            $statement->execute([
                'numero' => $_SESSION['numero']
            ]);
            $reponse = $statement->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION['reponse'] = $reponse;
            
            $_SESSION['compteur2'] += 1;
            $_SESSION['numero']+=1;
            header('location:voiture.php');
            exit();

        }else{
            $secondProfil = '';
            $compteurProfilMax = -1;

            foreach($_SESSION['profils'] as $profil => $compteur){
                if($compteur > $compteurProfilMax && $profil != $premierProfil){
                    $compteurProfilMax = $compteur;
                    $secondProfil = $profil;
                }
            }
        }
    }

    if($_SESSION['compteur2'] == 5){

        $profilsSansPremierChoix = [];
        
        foreach($_SESSION['profils'] as $profil => $compteur){
            if($profil != $premierProfil){
                $profilsSansPremierChoix[$profil] = $compteur;
            }
        }
        
        $max = max($profilsSansPremierChoix);
        $ocurence2 = 0;
        $profilsEgaux = [];
        
        foreach($profilsSansPremierChoix as $profil => $compteur){
            if($compteur == $max){
                $ocurence2++;
                $profilsEgaux[] = $profil;
            }
        }

        if($ocurence2 >= 2){
            $q = 'SELECT descriptif FROM question WHERE numero = 32';
            $statement = $bdd->prepare($q);
            $statement->execute([]);
            $question = $statement->fetchColumn();
    
            $_SESSION['question'] = $question;
    
            $q = 'SELECT texte, profil FROM optionrep WHERE numeroquestion = 32';
            $statement = $bdd->prepare($q);
            $statement->execute([]);
            $reponses = $statement->fetchAll(PDO::FETCH_ASSOC);
    
            $reponsesProfilsADepartager = [];
            foreach($reponses as $reponse){
                if(in_array($reponse['profil'],$profilsEgaux)){
                    $reponsesProfilsADepartager[] = $reponse;
                }
            }
    
            $_SESSION['reponse'] = $reponsesProfilsADepartager;

            $_SESSION['compteur2'] += 1;
    
            header('location:voiture.php');
            exit();
        }
    }

    if($_SESSION['compteur'] > 5){

        $_SESSION['premierProfil'] = $premierProfil;
        $_SESSION['secondProfil'] = $secondProfil;

        header('location:resultat_quiz.php');
        exit();
    }

}    

?>

