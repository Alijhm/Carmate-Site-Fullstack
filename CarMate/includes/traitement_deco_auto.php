<?php 
    session_start();

    if(isset($_SESSION['iduser'])){
        if(isset($_SESSION['derniereAction'])){
            if(time() - $_SESSION['derniereAction'] > 1800){
                session_destroy();
                header('location:connexion.php');
                exit();
            }else{
                $_SESSION['derniereAction'] = time();
            }
        }
    }   
?>