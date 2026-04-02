<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php
    $pageTitle = 'CarMate — Connexion';
    include('includes/head.php');
    include('traitement_voiture_aleatoire.php');
?>

<body>
    <?php 
    include('includes/headerSecond.php');
    ?>

    <main class="main-connexion">
        <div class="fond-voiture-aleatoire">
            <div class="row">
                <div class="col-5 ms-5 mt-3">
                    <div class="fondVoitureAleatoire1">
                        <div class="row">
                            <?php if(isset($_SESSION['iduser'])): ?>
                            <div class="col-1 mt-1">
                                <form method="POST" action="traitement_voiture_aleatoire.php">
                                    <input type="hidden" name="voitureId" value="<?php echo $voiture['idvoiture']; ?>">
                                    <input type="hidden" name="voitureNom" value="<?php echo htmlspecialchars($voiture['nom']); ?>">
                                    <button class="boutonLike">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color:#f52938" width="32" height="32" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <?php endif ?>
                            <div class="col-11">
                                <h3>Qu'avez vous pioché ?</h3>
                                <div class="line5 mb-2"></div>
                            </div>
                        </div>
                        <p>Découvrez dès maintenant la voiture que vous avez aléatoirement pioché !</p>
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
                    </div>
                    <div class="fondVoitureAleatoire2 mt-3">
                        <p><strong>Nom : </strong> <?php echo htmlspecialchars($voiture['nom']) ?></p>
                        <p><strong>Marque : </strong> <?php echo htmlspecialchars($voiture['marque']) ?></p>
                        <p><strong>Annee : </strong> <?php echo htmlspecialchars($voiture['annee']) ?></p>
                        <p><strong>Moteur : </strong> <?php echo htmlspecialchars($voiture['moteur']) ?></p>
                        <p><strong>Transmission : </strong> <?php echo htmlspecialchars($voiture['transmission']) ?></p>
                        <p><strong>Essence : </strong> <?php echo htmlspecialchars($voiture['essence']) ?></p>
                        <p><strong>Hybride : </strong> <?php echo htmlspecialchars($voiture['hybride']) ?></p>
                        <p><strong>Dimension : </strong> <?php echo htmlspecialchars($voiture['dimension']) ?></p>
                        <p><strong>Maniabilité : </strong> <?php echo htmlspecialchars($voiture['maniabilite']) ?></p>
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <div class="fondVoitureAleatoire3">
                        <p><?php echo htmlspecialchars($voiture['description']) ?></p>
                    </div>
                    <?php if ($voiture['image'] !== null) : ?>
                        <div class="fondVoitureAleatoire4">
                            <?php echo $voiture['image'] !== null ? htmlspecialchars($voiture['image']) : ''; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</body>




            
