<!DOCTYPE html>
<html lang="en">
<?php
    $pageTitle = 'CarMate — Mot de passe oublié';
    include('includes/head.php');
?>
<body>
    <?php  
        session_start();

        $afficher = false;

        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);  

        if (isset($_POST['envoyer'])) {
            $afficher = true;
            $_SESSION['afficher'] = $afficher;
        }
    ?>
    <main>
        <?php include('includes/headerSecond.php');?>
        <main class="main-connexion">
            <div class="fond-connexion">
            <div class="col-4 fond-formulaireConnexion mt-5">
                <form class="row g-3 needs-validation" method="POST" action="traitement_mdp_oublie.php" novalidate>
                    <div class="row">
                        <div class="col-12">
                            <h3>Informations nécessaires</h3>
                            <div class="line5 mb-2"></div>
                            <p>Nous vous contacterons par mail afin de réinitialiser votre mot de passe.</p>
                        </div>
    
                        <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'danger'): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                            </div>
                            <?php unset($_SESSION['flash_message']); ?>
                        <?php endif; ?>

                        <div class="col-12 mb-4">
                            <label for="validationCustom01" class="form-label">Adresse mail ou nom d'utilisateur</label>
                            <input type="email" class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>" id="validationCustom01" name="username" required>
                            <div class="invalid-feedback">
                                <?php echo $errors['username'] ?? ''; ?>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn mb-3" name="envoyer" value="envoyer">Recevoir le mail</button>
                            <a href="connexion.php"><p>Retourner à la page connexion</p></a>
                        </div>
                    </div>
                </form>
            </div>
            </div>    
    </main>
</body>
