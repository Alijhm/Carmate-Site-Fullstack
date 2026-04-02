<?php 

session_start();

include('includes/db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['contacter'])){

        $iduser = $_SESSION['iduser'];
        $iduserContacte = $_POST['iduserContacte'];
        $date = date('Y-m-d H:i:s');
        $theme = "privee";

        $q = 'SELECT nomUtilisateur FROM utilisateur WHERE iduser = :iduser';
        $statement = $bdd->prepare($q);
        $statement->execute([
            'iduser' => $iduser
        ]);
        $user1 = $statement->fetch(PDO::FETCH_ASSOC);
        $nom1 = $user1['nomUtilisateur'];

        $q = 'SELECT nomUtilisateur FROM utilisateur WHERE iduser = :iduser';
        $statement = $bdd->prepare($q);
        $statement->execute([
            'iduser' => $iduserContacte
        ]);
        $user2 = $statement->fetch(PDO::FETCH_ASSOC);
        $nom2 = $user2['nomUtilisateur'];

        $titre1 = "$nom1 et $nom2";
        $titre2 = "$nom2 et $nom1";

        $q = 'SELECT titre FROM discussion WHERE titre = :titre1 OR titre = :titre2';
        $statement = $bdd->prepare($q);
        $statement->execute([
            'titre1' => $titre1,
            'titre2' => $titre2
        ]);
        $results = $statement->fetchAll();

        if(!empty($results)){
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => "Vous avez déjà crée cette conversation !"
            ];

            header('location:forum.php');
            exit();
        }else{
            $query = 'INSERT INTO discussion (titre, theme, date, iduserdisc) VALUES (:titre, :theme, :date, :iduserdisc)';
            $statement = $bdd->prepare($query);
            $result = $statement->execute([
                'titre' => $titre1,
                'theme' => $theme,
                'date' => $date,
                'iduserdisc' => $iduser
            ]);

            $query = 'INSERT INTO discussion (titre, theme, date, iduserdisc) VALUES (:titre, :theme, :date, :iduserdisc)';
            $statement = $bdd->prepare($query);
            $result = $statement->execute([
                'titre' => $titre1,
                'theme' => $theme,
                'date' => $date,
                'iduserdisc' => $iduserContacte
            ]);

            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => "Conversation ajoutée avec succès !"
            ];

            header('location:forum.php');
            exit();
        }
       
    }

}
?>