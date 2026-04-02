
<!DOCTYPE html>
<html lang="en">
<?php
    $pageTitle = 'CarMate — Code de confirmation';
    include('includes/head.php');
?>
<body>
    <?php        
        session_start();
    
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);  
    ?>
    <main>
        <?php include('includes/headerSecond.php');?>
        <main class="main-connexion">
            <div class="fond-connexion">
                <div class="col-4 fond-formulaireConnexion mt-5">
                    <form class="row g-3 needs-validation" method="POST" action="traitement_code_verif.php"  novalidate>
                        <div class="row">
                            <div class="col-12">
                                <h3>Vérification du mail</h3>
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
                                    <label for="validationCustom01" class="form-label mt-3">Code</label>
                                    <input type="text" class="form-control <?php echo isset($errors['code']) ? 'is-invalid' : ''; ?>" id="validationCustom01" name="codeSaisi" required>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['code'] ?? ''; ?>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn mb-3">Confirmer</button>
                                <a href="traitement_renvoie_mail.php?numMail=1"><p>Renvoyer le code</p></a>
                                <a href="inscription.php"><p>Retourner à la page inscription</p></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>    
    </main>
</body>
