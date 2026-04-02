<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php 

    $pageTitle = 'CarMate — Réglages';
    include('includes/head.php');

    include('includes/reinitialisation_infos_quiz.php');

    unset($_SESSION['formulaire']);
?>

<body>
    <?php 
    include('includes/db.php');
    include('includes/headerSecond.php');

    if(isset($_SESSION['iduser'])){
        $q = 'SELECT theme FROM utilisateur WHERE iduser = :iduser';
        $statement = $bdd->prepare($q);
        $statement->execute([
            'iduser' => $_SESSION['iduser']
        ]);
        $results = $statement->fetch();

        if($results){
            $theme = $results['theme'];
        }
    }

    ?>

    <main class="main-connexion">
        <div class="fond-voiture">
            <div class="fond-connexion2">
                <div class="col-4 fond-formulaireConnexion2 mt-5 ms-5">
                    <h1> Réglages</h1>
                    <div class="line5 mb-2"></div>
                    <p><em>Personnalisez votre expérience sur CarMate à votre goût !</em></p>
                    <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'danger'): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                        </div>
                        <?php unset($_SESSION['flash_message']); ?>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'success'): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                        </div>
                        <?php unset($_SESSION['flash_message']); ?>
                    <?php endif; ?>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" <?php if(isset($_SESSION['iduser'])): ?> data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" <?php else: ?> onclick="window.location.href='connexion.php'" <?php endif ?>>
                                Changer le thème de couleurs
                            </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <?php if($theme == 1): ?>
                                    <form method="POST" action="traitement_theme.php">
                                        <p>Les couleurs de CarMate vous éblouissent trop ? Passez au mode sombre en un clic !</p>
                                        <button name="sombre" class="boutonSombre">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-moon-fill" viewBox="0 0 16 16">
                                                <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278"/>
                                            </svg>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" action="traitement_theme.php">
                                        <p>Les couleurs originales de CarMate vous manquent ? Passez au mode clair en un clic !</p>
                                        <button name="clair" class="boutonClair">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                Supprimer votre compte
                            </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>
                                La suppression de votre compte sera <strong>définitive</strong>. <br>
                                Toutes vos données, préférences et historiques seront <strong>effacés de manière permanente</strong> et ne pourront <strong>pas être récupérés</strong>. <br>
                                Si vous souhaitez simplement faire une pause, pensez à vous déconnecter.<br><br>
                                Vous êtes certain(e) de vouloir continuer ?
                                </p>

                                <a href="#modal" style="text-decoration:none;color:black">
                                <button type="button" class="btn" id="boutonSup" style="--bs-btn-padding-y: 1rem; --bs-btn-font-size: 1rem; width:100px">
                                    Oui
                                </button>
                                </a>

                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>






<div id="modal" class="modal">
  <div class="modal-container">
  <form method="POST" action="traitement_sup.php" novalidate>
    <div class="row">
        <h3>Vous êtes certain(e) de votre choix ?</h3>
        <div class="line2 mb-2 ms-2"></div>
        <p>Ceci est le dernier message préventif. La prochaine étape correspond soit à l'annulation de la suppression, soit à la suppression définitive de votre compte CarMate</p>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <label for="validationCustom02" class="form-label">Veuillez saisir votre mot de passe afin de supprimer votre compte</label>
            <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" id="validationCustom02"  name="password" required>
            <div class="invalid-feedback">
                <?php echo $errors['password'] ?? ''; ?>
            </div> 
        </div>
    </div>
    <div class="row buttonDelete mt-4 mb-2 text-center">
        <div class="col-12">
            <input type="hidden" name="action" value="delete">
            <button class="btn mb-1 me-4" type="submit" name="supprimer">Supprimer mon compte</button>
            <a href="reglage.php">Annuler la suppression</a>
        </div>
    </div>
  </form>
</div>