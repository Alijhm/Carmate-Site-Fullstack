<!DOCTYPE html>
<html lang="en">
<?php
    $pageTitle = 'CarMate — Réinitialisation mot de passe';
    include('includes/head.php');
?>
<body>
    <?php 
    session_start();
    
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);

    $token = $_GET['token'];
    $_SESSION['token']=$token;

    $iduser = $_GET['id'] ?? $_SESSION['iduser'] ?? null;

    if ($iduser) {
        $_SESSION['iduser'] = $iduser;
    }
    ?>
    <main>
        <?php include('includes/headerSecond.php');?>
        <main class="main-connexion">
            <div class="fond-connexion">
                <div class="col-4 fond-formulaireConnexion mt-5">
                <form class="row g-3 needs-validation" method="POST" action="traitement_reinitialisation_mdp.php" novalidate>
                    <div class="row">
                        <div class="col-12">
                            <h3>Modifiez votre mot de passe</h3>
                            <div class="line5 mb-4"></div>
                        </div>
                        
                        <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'danger'): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                            </div>
                            <?php unset($_SESSION['flash_message']); ?>
                        <?php endif; ?>

                        <div class="col-12 mb-4">
                            <label for="validationCustom11" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control <?php echo isset($errors['newpassword']) ? 'is-invalid' : ''; ?>" id="validationCustom30"  name="newpassword" 
                            value="<?php echo $_SESSION['saisi']['newpassword'] ?? ''; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $errors['newpassword'] ?? ''; ?>
                            </div> 
                        </div>
                        <div class="col-12 mb-4">
                            <label for="validationCustom12" class="form-label">Confirmation</label>
                            <input type="password" class="form-control <?php echo isset($errors['newpasswordConfirmation']) ? 'is-invalid' : ''; ?>" id="validationCustom31"  name="newpasswordConfirmation" 
                            value="<?php echo $_SESSION['saisi']['newpasswordConfirmation'] ?? ''; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $errors['newpasswordConfirmation'] ?? ''; ?>
                            </div> 
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
                            <input type="hidden" name="iduser" value="<?= htmlspecialchars($_SESSION['iduser'] ?? '') ?>">
                            <button type="submit" class="btn">Valider</button>
                            <a href="connexion.php"><p class="mt-3">Annuler</p></a>
                        </div>
                    </div>
                </form>
                </div>
            </div>
    </main>
</body>