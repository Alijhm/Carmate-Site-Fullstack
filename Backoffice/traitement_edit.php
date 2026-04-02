<?php
    session_start();

    include('includes/db.php');

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateuser'])){
        $iduser = $_POST['updateuser']; 
        $newnomUtilisateur = htmlspecialchars(trim($_POST['newnomUtilisateur'][$iduser]));
        $newdateDeNaissance = htmlspecialchars(trim($_POST['newdateDeNaissance'][$iduser]));
        $newville = htmlspecialchars(trim($_POST['newville'][$iduser]));
        $newrue = htmlspecialchars(trim($_POST['newrue'][$iduser]));
        $newdescription = htmlspecialchars(trim($_POST['newdescription'][$iduser]));

        $q = 'UPDATE utilisateur SET nomUtilisateur = :newnomUtilisateur, dateDeNaissance = :newdateDeNaissance, ville = :newville, 
        rue = :newrue, description = :newdescription WHERE iduser = :iduser';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([
            'newnomUtilisateur' => $newnomUtilisateur,
            'newdateDeNaissance' => $newdateDeNaissance,
            'newville' => $newville,
            'newrue' => $newrue,
            'newdescription' => $newdescription,
            'iduser' => $iduser
        ]); 

 
        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Les valeurs ont été modifiées avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Les valeurs n\'ont pas été modifiées, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pageusers');
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatecar'])){
        $idvoiture = $_POST['updatecar']; 
        $newnom = htmlspecialchars(trim($_POST['newnom'][$idvoiture]));
        $newmarque = htmlspecialchars(trim($_POST['newmarque'][$idvoiture]));
        $newannee = $_POST['newannee'][$idvoiture];
        $newprix = $_POST['newprix'][$idvoiture];
        $newdescription = htmlspecialchars(trim($_POST['newdescription'][$idvoiture]));
        $newdimension = htmlspecialchars(trim($_POST['newdimension'][$idvoiture]));
        $newmoteur = htmlspecialchars(trim($_POST['newmoteur'][$idvoiture]));
        $newessence = htmlspecialchars(trim($_POST['newessence'][$idvoiture]));
        $newtransmission = htmlspecialchars(trim($_POST['newtransmission'][$idvoiture]));
        $newhybride = strtolower(trim($_POST['newhybride'][$idvoiture])) == 'oui' ? 1 : 0;
        $newmaniabilite = htmlspecialchars(trim($_POST['newmaniabilite'][$idvoiture]));
        $newlien = htmlspecialchars(trim($_POST['newlien'][$idvoiture]));

        $q = 'UPDATE voiture SET nom = :newnom, marque = :newmarque, annee = :newannee, prix = :newprix, description = :newdescription, 
        dimension = :newdimension, moteur = :newmoteur, essence = :newessence, transmission = :newtransmission, hybride = :newhybride,
        maniabilite = :newmaniabilite, lien = :newlien
        WHERE idvoiture = :idvoiture';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([
            'newnom' => $newnom,
            'newmarque' => $newmarque,
            'newannee' => $newannee,
            'newprix' => $newprix,
            'newdescription' => $newdescription,
            'newdimension' => $newdimension,
            'newmoteur' => $newmoteur,
            'newessence' => $newessence,
            'newtransmission' => $newtransmission,
            'newhybride' => $newhybride,
            'newmaniabilite' => $newmaniabilite,
            'newlien' => $newlien,
            'idvoiture' => $idvoiture
        ]); 

 
        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Les valeurs ont été modifiées avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Les valeurs n\'ont pas été modifiées, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagecars');
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateright'])){
        $iduser = $_POST['updateright']; 
        $newstatus = htmlspecialchars(trim($_POST['newstatus'][$iduser]));

        $q = 'UPDATE utilisateur SET status = :newstatus WHERE iduser = :iduser';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([
            'newstatus' => $newstatus,
            'iduser' => $iduser
        ]); 

 
        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Les valeurs ont été modifiées avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Les valeurs n\'ont pas été modifiées, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagerights');
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatequestion'])){
        $numero = $_POST['updatequestion']; 
        $newdescriptif = htmlspecialchars(trim($_POST['newdescriptif'][$numero]));
        $newtier = $_POST['newtier'][$numero];

        $q = 'UPDATE question SET descriptif = :newdescriptif, tier = :newtier WHERE numero = :numero';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([
            'newdescriptif' => $newdescriptif,
            'newtier' => $newtier,
            'numero' => $numero
        ]); 

 
        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Les valeurs ont été modifiées avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Les valeurs n\'ont pas été modifiées, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagequiz');
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletequestion'])){
        $numero = $_POST['deletequestion']; 

        $q = 'DELETE FROM question WHERE numero = :numero';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([':numero' => $numero]); 

        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'La question a été effacée avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'La question n\'a pas été effacée, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagequiz');
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateanswer'])){
        $idoptionrep = $_POST['updateanswer']; 
        $newtexte = htmlspecialchars(trim($_POST['newtexte'][$idoptionrep]));
        $newprofil = $_POST['newprofil'][$idoptionrep];
        $newnumeroquestion = $_POST['newnumeroquestion'][$idoptionrep];

        $q = 'UPDATE optionrep SET texte = :newtexte, profil = :newprofil, numeroquestion = :newnumeroquestion WHERE idoptionrep = :idoptionrep';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([
            'newtexte' => $newtexte,
            'newprofil' => $newprofil,
            'newnumeroquestion' => $newnumeroquestion,
            'idoptionrep' => $idoptionrep
        ]); 

 
        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Les valeurs ont été modifiées avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Les valeurs n\'ont pas été modifiées, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagequiz');
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteanswer'])){
        $idoptionrep = $_POST['deleteanswer']; 

        $q = 'DELETE FROM optionrep WHERE idoptionrep = :idoptionrep';
        $statement = $bdd->prepare($q);
        $result = $statement->execute(['idoptionrep' => $idoptionrep]); 
 
        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'La réponse a été effacée avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'La réponse n\'a pas été effacée, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagequiz');
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatecaptcha'])){
        $idcaptcha = $_POST['updatecaptcha']; 
        $newquestionCaptcha = htmlspecialchars(trim($_POST['newquestionCaptcha'][$idcaptcha]));
        $newreponseCaptcha = htmlspecialchars(trim($_POST['newreponseCaptcha'][$idcaptcha]));

        $q = 'UPDATE captcha SET questionCaptcha = :newquestionCaptcha, reponseCaptcha = :newreponseCaptcha WHERE idcaptcha = :idcaptcha';
        $statement = $bdd->prepare($q);
        $result = $statement->execute([
            'newquestionCaptcha' => $newquestionCaptcha,
            'newreponseCaptcha' => $newreponseCaptcha,
            'idcaptcha' => $idcaptcha
        ]); 
 
        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Les valeurs ont été modifiées avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Les valeurs n\'ont pas été modifiées, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagecaptcha');
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateban'])){
        $iduser = $_POST['updateban'];

        for($i=0; $i<count($_SESSION['listreports']); $i++){
            if($_SESSION['listreports'][$i][0]['iduser'] == $iduser){
                if($_SESSION['listreports'][$i][0]['ban'] == 0){
                    $q = 'UPDATE utilisateur SET ban = 1 WHERE iduser = :iduser';
                    $statement = $bdd->prepare($q);
                    $result = $statement->execute([
                        'iduser' => $iduser
                    ]);
                }else{
                    $q = 'UPDATE utilisateur SET reports = 0, ban = 0 WHERE iduser = :iduser';
                    $statement = $bdd->prepare($q);
                    $result = $statement->execute([
                        'iduser' => $iduser
                    ]);
                }
            }
        }

        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Les valeurs ont été modifiées avec succès.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Les valeurs n\'ont pas été modifiées, veuillez réessayer.'
            ];
        }
        header('Location: https://carmate.site//Backoffice/#pagereports');
        exit();
    }
?>