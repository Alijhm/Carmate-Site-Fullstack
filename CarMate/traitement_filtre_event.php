<?php 

session_start();

include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if($_POST['source'] == 'event'){

        if(empty($_POST['prix']) && $_POST['ville'] == "-1" && $_POST['type'] == "-1" && $_POST['duree'] == "-1"){
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => "Veuillez filtrer votre recherche.",
            ];
            header('Location: event.php');
            exit();
        }

        $conditionsWhere = [];
        $parametres = [];
        $_SESSION['filtrage'] = [];

        
        if(!empty($_POST['prix'])){
            $conditionsWhere[] = "evenement.prixEntree <= :prix";
            $parametres['prix'] = $_POST['prix'];
        }
        if($_POST['ville'] != "-1"){
            $conditionsWhere[] = "evenement.ville = :ville";
            $parametres['ville'] = $_POST['ville'];
        }
        if($_POST['type'] != "-1"){
            $conditionsWhere[] = "evenement.type = :type";
            $parametres['type'] = $_POST['type'];
        }
        if($_POST['duree'] != "-1"){
            $conditionsWhere[] = "evenement.duree = :duree";
            $parametres['duree'] = $_POST['duree'];
        }

        $q = 'SELECT evenement.*, avatar.tete, avatar.lunettes, avatar.chapeau, utilisateur.nomUtilisateur, utilisateur.iduser 
        FROM evenement JOIN organise ON evenement.idevent = organise.ideventorga
        JOIN utilisateur ON organise.iduserorga = utilisateur.iduser
        LEFT JOIN avatar ON avatar.idavataruser = utilisateur.iduser
        WHERE '. implode(' AND ', $conditionsWhere);
        $statement = $bdd->prepare($q);
        $statement->execute($parametres);
        $results = $statement->fetchAll();

        foreach($results as $event) {
            $_SESSION['filtrage'][] = [
                'idevent' => $event['idevent'],
                'titre' => $event['titre'],
                'dateDebut' => $event['dateDebut'],
                'dateFin' => $event['dateFin'],
                'ville' => $event['ville'],
                'rue' => $event['rue'],
                'duree' => $event['duree'],
                'type' => $event['type'],
                'prixEntree' => $event['prixEntree'],
                'nbPlaces' => $event['nbPlaces'],
                'description' => $event['description'],
                'iduser' => $event['iduser'],
                'nomUtilisateur' => $event['nomUtilisateur'],
                'tete' => $event['tete'],
                'lunettes' => $event['lunettes'],
                'chapeau' => $event['chapeau'],
                'likes' => $event['likes'],
            ];
        }

        header('location:event_postFiltre.php');
        exit();

    }elseif($_POST['source'] == 'garage'){

        if(empty($_POST['prix']) && $_POST['categorie'] == "-1" && $_POST['etat'] == "-1"){
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => "Veuillez filtrer votre recherche.",
            ];
            header('Location: garage.php');
            exit();
        }

        $conditionsWhere = [];
        $parametres = [];
        $_SESSION['filtrage'] = [];

        
        if(!empty($_POST['prix'])){
            $conditionsWhere[] = "offre.prix <= :prix";
            $parametres['prix'] = $_POST['prix'];
        }
        if($_POST['categorie'] != "-1"){
            $conditionsWhere[] = "offre.categorie = :categorie";
            $parametres['categorie'] = $_POST['categorie'];
        }
        if($_POST['etat'] != "-1"){
            switch ($_POST['etat']) {
                case 'neuf':
                    $conditionsWhere[] = "offre.etat = 'neuf'";
                    break;
                case 'utilise':
                    $conditionsWhere[] = "offre.etat IN ('neuf', 'utilise')";
                    break;
                case 'abime':
                case 'pasDePref':
                    $conditionsWhere[] = "offre.etat IN ('neuf', 'utilise', 'abime')";
                    break;
            }
        }

        $query = 'SELECT idvente, produit, prix, etat, offre.description, categorie, dateCreation, nomUtilisateur 
        FROM offre INNER JOIN utilisateur on offre.iduser = utilisateur.iduser
        WHERE '. implode(' AND ', $conditionsWhere);
        $statement = $bdd->prepare($query);
        $statement->execute($parametres);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($results as $article) {
            $_SESSION['filtrage'][] = [
                    'idvente' => $article['idvente'],
                    'produit' => $article['produit'],
                    'prix' => $article['prix'],
                    'etat' => $article['etat'],
                    'description' => $article['description'],
                    'categorie' => $article['categorie'],
                    'dateCreation' => $article['dateCreation'],
                    'nomUtilisateur' => $article['nomUtilisateur'],
                ];
        }

        header('location:garage_postRecherche.php');
        exit();

    }
    
}

?>