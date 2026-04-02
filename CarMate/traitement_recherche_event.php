<?php 

session_start();

include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $recherche = '';

    if(isset($_POST['recherche']) && !empty($_POST['recherche'])){
        $recherche = trim($_POST['recherche']);

        $q = 'SELECT evenement.*, avatar.tete, avatar.lunettes, avatar.chapeau, utilisateur.nomUtilisateur, utilisateur.iduser 
        FROM evenement JOIN organise ON evenement.idevent = organise.ideventorga
        JOIN utilisateur ON organise.iduserorga = utilisateur.iduser
        LEFT JOIN avatar ON avatar.idavataruser = utilisateur.iduser
        WHERE INSTR(evenement.titre,:recherche)>0 OR INSTR(evenement.ville,:recherche)>0 OR INSTR(evenement.type,:recherche)>0 OR INSTR(evenement.description,:recherche)>0';
        $statement = $bdd->prepare($q);
        $statement->execute(['recherche' => $recherche]);
        $results = $statement->fetchAll();

        if(!empty($results)){
            $_SESSION['filtrage']=[];
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
        }else{
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => "Aucun élément ne correspond à votre recherche.",
            ];
            header('Location: event.php');
            exit();
        }

    }elseif(isset($_POST['rechercheGarage']) && !empty($_POST['rechercheGarage'])){
        $recherche = trim($_POST['rechercheGarage']);

        $query = 'SELECT idvente, produit, prix, etat, offre.description, categorie, dateCreation, nomUtilisateur 
        FROM offre INNER JOIN utilisateur on offre.iduser = utilisateur.iduser
        WHERE INSTR(offre.produit,:recherche)>0 OR INSTR(offre.description,:recherche)>0
        ORDER BY dateCreation ASC';
        $statement = $bdd->prepare($query);
        $statement->execute(['recherche' => $recherche]);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($results)){
            $_SESSION['filtrage']=[];
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
        }else{
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => "Aucun élément ne correspond à votre recherche.",
            ];
            header('Location: garage.php');
            exit();
        }

    }else{
        $redirect = 'event.php';
        if (isset($_POST['rechercheGarage'])) {
            $redirect = 'garage.php';
        }

        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Veuillez saisir un élément à rechercher.",
        ];
        header("Location: $redirect");
        exit();
    }
    
}

?>