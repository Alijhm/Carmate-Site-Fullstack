<?php 

session_start();

include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $iduser = $_SESSION['iduser'];

    if(isset($_POST['suppression_like_voiture'])){

        $nomVoiture = $_POST['nom'];

        $q = 'DELETE FROM dans_historique WHERE iduserhis = :iduser AND nom = :nom';
        $statement = $bdd->prepare($q);
        $statement->execute([
            'iduser' => $iduser,
            'nom' => $nomVoiture,
        ]);

        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "La voiture a bien été retirée de vos likes."
        ];

        header('location:voiture_like.php');
        exit();

    }elseif(isset($_POST['suppression_enregistrement_event'])){

        $idevent = $_POST['idevent'];

        $q = 'DELETE FROM inscrit WHERE idusersub = :iduser AND ideventsub = :idevent';
        $statement = $bdd->prepare($q);
        $statement->execute([
            'iduser' => $iduser,
            'idevent' => $idevent,
        ]);

        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "L'événement a bien été retiré de vos enregistrements."
        ];

        header('location:event_enregistre.php');
        exit();

    }elseif(isset($_POST['suppression_article'])){
        $idvente = $_POST['idvente'];

        $q = 'DELETE FROM offre WHERE iduser = :iduser AND idvente = :idvente';
        $statement = $bdd->prepare($q);
        $statement->execute([
            'iduser' => $_SESSION['iduser'],
            'idvente' => $idvente
        ]);

        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Votre article a bien été retiré de la vente."
        ];

        header('location:articles_profil.php');
        exit();

    }elseif(isset($_POST['suppression_articles_panier'])){        
        $newPanier = [];

        foreach($_SESSION['panier'] as $article){
            if($article['idvente'] != $_POST['idvente']){
                $newPanier[] = $article;
            }
        }

        $_SESSION['panier'] = $newPanier;

        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "L'article a bien été retiré de votre panier."
        ];

        header('location:panier.php');
        exit();
    }
    
}
?>