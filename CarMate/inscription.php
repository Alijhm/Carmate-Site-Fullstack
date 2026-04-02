<!DOCTYPE html>
<html lang="en">

<?php 
    $pageTitle = 'CarMate — Inscription';
    include('includes/head.php');
?>

<body>
    <?php include('includes/headerSecond.php');

    session_start();
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);

    include('includes/db.php');

    $q = 'SELECT count(*) FROM captcha';
    $statement = $bdd->prepare($q);
    $statement->execute([]);
    $nbLignes = $statement->fetchColumn();

    $numQuestion = rand(1,$nbLignes);

    $q = 'SELECT questionCaptcha, reponseCaptcha FROM captcha WHERE idcaptcha = :numQuestion';
    $statement = $bdd->prepare($q);
    $statement->execute([
        'numQuestion' => $numQuestion
    ]);
    $captcha = $statement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['captcha_answer'] = $captcha['reponseCaptcha']
    ?>
    <main>
    <div class="fond-connexion">
            <div class="col-6 fond-formulaireConnexion mt-5">
                <form class="row g-3 needs-validation" method="POST" action="traitement_inscription.php" novalidate>
                    <div class="row">
                        <div class="col-12">
                            <h3>Inscrivez vous</h3>
                            <div class="line5 mb-4"></div>
                        </div>
                        
                        <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'danger'): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                            </div>
                            <?php unset($_SESSION['flash_message']); ?>
                        <?php endif; ?>

                        <div class="col-4 mb-3">
                            <label for="validationCustom10" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>" id="validationCustom10" name="username" 
                            value="<?php echo $_SESSION['saisi']['username'] ?? ''; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $errors['username'] ?? ''; ?>
                            </div> 
                        </div>
                        <div class="col-4 mb-4">
                            <label for="validationCustom11" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" id="validationCustom11"  name="password" 
                            value="<?php echo $_SESSION['saisi']['password'] ?? ''; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $errors['password'] ?? ''; ?>
                            </div> 
                        </div>
                        <div class="col-4 mb-4">
                            <label for="validationCustom12" class="form-label">Confirmation</label>
                            <input type="password" class="form-control <?php echo isset($errors['passwordConfirmation']) ? 'is-invalid' : ''; ?>" id="validationCustom12"  name="passwordConfirmation" 
                            value="<?php echo $_SESSION['saisi']['passwordConfirmation'] ?? ''; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $errors['passwordConfirmation'] ?? ''; ?>
                            </div> 
                        </div>
                    </div> 

                    <div class="row mb-4">
                        <div class="col-4">
                            <label for="validationCustomUsername" class="form-label">Adresse mail</label>
                            <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="email" 
                            value="<?php echo $_SESSION['saisi']['email'] ?? ''; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $errors['email'] ?? ''; ?>
                            </div> 
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="validationCustom13" class="form-label">Naissance</label>
                            <input type="date" class="form-control <?php echo isset($errors['dateNaissance']) ? 'is-invalid' : ''; ?>" id="validationCustom13" name="dateNaissance" 
                            value="<?php echo $_SESSION['saisi']['dateNaissance'] ?? ''; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $errors['dateNaissance'] ?? ''; ?>
                            </div> 
                        </div>
                        <div class="col-2">
                            <label for="validationCustom14" class="form-label">Ville</label>
                            <input type="text" class="form-control <?php echo isset($errors['ville']) ? 'is-invalid' : ''; ?>" id="validationCustom14" name="ville" 
                            value="<?php echo $_SESSION['saisi']['ville'] ?? ''; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $errors['ville'] ?? ''; ?>
                            </div> 
                        </div>
                        <div class="col-3">
                            <label for="validationCustom15" class="form-label">Rue</label>
                            <input type="text" class="form-control <?php echo isset($errors['rue']) ? 'is-invalid' : ''; ?>" id="validationCustom15" name="rue" 
                            value="<?php echo $_SESSION['saisi']['rue'] ?? ''; ?>" required> 
                            <div class="invalid-feedback">
                                <?php echo $errors['rue'] ?? ''; ?>
                            </div> 
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-4">
                            <p>Vérifions qu'il n y a pas de bots parmi nous. <?php echo $captcha['questionCaptcha']; ?></p>
                            <input type="text" name="captcha_response" id="captcha_question" class="form-control <?php echo isset($errors['captcha']) ? 'is-invalid' : ''; ?>" 
                            value="<?php echo $_SESSION['saisi']['captcha'] ?? ''; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $errors['captcha'] ?? ''; ?>
                            </div> 
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn">S'inscrire</button>
                            <a href="connexion.php"><p class="mt-3">Retourner à la page connexion</p></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>