<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php
    $pageTitle = 'CarMate — Personnalisation du profil';
    include('includes/head.php');
?>
<body>
    <?php
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);
    ?>
    <main>
        <?php include('includes/headerSecond.php');?>
        <main class="main-connexion">
            <div class="fond-connexion">
                <div class="col-4 fond-formulaireConnexion mt-5">
                <form method="POST" action="traitement_edit.php">
                    <div class="col-12">
                        <h3>Personnalisez votre compte</h3>
                        <div class="line5 mb-4"></div>
                    </div>
                    <label for="name" class="form-label">Voiture favorite</label>
                    <input
                        type="text"
                        name="voiturePrefGar"
                        class="form-control mb-3"
                        minlength="0"
                        maxlength="255"
                        size="100"
                    />
                    <div class="mb-4">
                        <label for="exampleFormControlTextarea1" class="form-label">Description (255 caractères max)</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="descriptionEdit" maxlength="165"></textarea>
                    </div>
                        <button type="submit" class="btn">Mettre à jour</button>
                        <a href="profil.php" class="mt-3">Retourner à la page profil</a>
                </form>
                </div>
            </div>
            
        
        <?php 
            include('includes/db.php');
        ?>
    </main>
</body>