<!DOCTYPE html>
<html lang="en">

<?php 
    $pageTitle = 'CarMate — Connexion';
    include('includes/head.php');
    include('includes/formulaire_reinit.php');
?>

<body>
    <?php 
    session_start();
    unset($_SESSION['saisi']);
    include('includes/headerSecond.php');
    
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);
    ?>

    <main class="main-connexion">
        <div class="fond-connexion">
            <div class="col-4 fond-formulaireConnexion mt-5">
                <form class="row g-3 needs-validation" method="POST" action="traitement_connexion.php" novalidate>
                    <div class="row">
                        <div class="col-12">
                            <h3>Connectez vous</h3>
                            <div class="line5 mb-4"></div>
                        </div>
                        <div class="col-12">
                            <?php if (isset($errors['login'])): ?>
                                <div class="alert alert-danger">
                                    <?php echo htmlspecialchars($errors['login']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'success'): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                            </div>
                            <?php unset($_SESSION['flash_message']); ?>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'danger'): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                            </div>
                            <?php unset($_SESSION['flash_message']); ?>
                        <?php endif; ?>

                        <div class="col-12 mb-3">
                            <label for="validationCustom01" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>" id="validationCustom01" name="username" required> 
                            <div class="invalid-feedback">
                                <?php echo $errors['username'] ?? ''; ?>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="validationCustom02" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>" id="validationCustom02"  name="password" required>
                            <div class="invalid-feedback">
                                <?php echo $errors['password'] ?? ''; ?>
                            </div> 
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn">Se connecter</button>
                            <?php if (isset($_SESSION['afficher']) && $_SESSION['afficher'] === true): ?>
                                <a class="mt-3" href="traitement_renvoie_mail.php?numMail=2"><p>Renvoyer le mail</p></a>
                            <?php endif; ?>
                            
                            <?php if (isset($_SESSION['afficher']) && $_SESSION['afficher'] === true): ?>
                                <a href="inscription.php"><p><strong> Pas de compte CarMate ? Créez en un !</strong></p></a>
                            <?php else: ?>
                                <a href="inscription.php" class="mt-3" ><p><strong> Pas de compte CarMate ? Créez en un !</strong></p></a>
                            <?php endif; ?>
                            <a href="mdp_oublie.php"><p>Mot de passe oublié ?</p></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php 
            include('includes/db.php');
            unset($_SESSION['afficher']); 
        ?>
    </main>
</body>