<?php 

session_start();

include('includes/db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['message']) && !empty($_POST['message'])){
    
        if($_POST['forumOuDiscussion'] == 'chatGeneral'){
            
            $message = htmlspecialchars($_POST['message']);
            $iduser = $_SESSION['iduser'];
            $iddiscussion = 1;
            $date = date('Y-m-d H:i:s');

            $query = 'INSERT INTO message (contenu, date, iddiscussion, idusermess) VALUES (:contenu, :date, :iddiscussion, :idusermess)';
            $statement = $bdd->prepare($query);
            $result = $statement->execute([
                'contenu' => $message,
                'date' => $date,
                'iddiscussion' => $iddiscussion,
                'idusermess' => $iduser,
            ]);

            header('location:forum.php?forum');
            exit();
        }else{

            $message = htmlspecialchars($_POST['message']);
            $iduser = $_SESSION['iduser'];
            $iddiscussion = $_POST['forumOuDiscussion'];
            $date = date('Y-m-d H:i:s');

            $query = 'INSERT INTO message (contenu, date, iddiscussion, idusermess) VALUES (:contenu, :date, :iddiscussion, :idusermess)';
            $statement = $bdd->prepare($query);
            $result = $statement->execute([
                'contenu' => $message,
                'date' => $date,
                'iddiscussion' => $iddiscussion,
                'idusermess' => $iduser,
            ]);

            header('location:forum.php?disc=' . $_POST['forumOuDiscussion']);
            exit();
        }
    }

}
?>