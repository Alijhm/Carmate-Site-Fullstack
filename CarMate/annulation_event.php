
<!DOCTYPE html>
<html lang="en">
<?php
    $pageTitle = 'CarMate — Code de confirmation';
    include('includes/head.php');

    session_start();
?>
<body>
    <main>
        <?php include('includes/headerSecond.php');?>
        <main class="main-connexion">
            <div class="fond-connexion">
                <div class="col-4 fond-formulaireConnexion mt-5">
                    <form class="row g-3 needs-validation" method="POST" action="traitement_annulation_event.php"  novalidate>
                        <div class="row">
                            <div class="col-12">
                                <h3>Annulation de votre événement</h3>
                                <div class="line5 mb-2"></div>
                            </div>
        
                            <?php if(isset($_SESSION['flash_message2']) && $_SESSION['flash_message2']['type'] === 'success'): ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message2']['message']) . '</p>'; ?>
                                </div>
                                <?php unset($_SESSION['flash_message2']); ?>
                            <?php endif; ?>

                            <?php if(isset($_SESSION['flash_message2']) && $_SESSION['flash_message2']['type'] === 'danger'): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message2']['message']) . '</p>'; ?>
                                </div>
                                <?php unset($_SESSION['flash_message2']); ?>
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <p>Nous sommes désolés que l'organisation de votre événement ne se passe pas au mieux. Étes-vous certains de vouloir l'annuler ?<br><strong>L'annulation de votre événement sera définitive, aucun retour en arrière n'est possible.</strong></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" name="idevent" value="<?php echo htmlspecialchars($_GET['idevent'] ?? ''); ?>">
                                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">
                                <button type="submit" class="btn mb-3">Annuler définitivement</button>
                                <a href="index.php"><p>Maintenir l'événement</p></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>    
    </main>
</body>
