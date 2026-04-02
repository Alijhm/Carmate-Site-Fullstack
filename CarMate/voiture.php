<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">
    
<?php
    $pageTitle = 'CarMate — Votre voiture idéale';
    include('includes/head.php');
    unset($_SESSION['formulaire']);
?>

<body>
    <?php include('includes/header.php');?>
    <main>
        <div class="fond-voiture">
            <div class="fond-connexion">
                <div class="col-4 fond-formulaireConnexion mt-5" style="width:auto">
                    <form method="POST" action="traitement_quiz_voiture.php">
                        <?php if(!isset($_SESSION['compteur'])): ?>
                            <h1>Trouvez votre voiture idéale</h1>
                            <div class="line5 mb-2"></div>
                            <p>Répondez à un court quiz d'une quinzaine de questions et trouvez la voiture<br>la plus adaptée à vos goûts et votre rythme de vie !</p>

                            <button type="submit" name="lancerQuiz" class="btn mt-4" style="padding:1rem;width:auto;color:white;">
                                Commencer le Quiz
                            </button>
                        <?php else: ?>
                            <h1>Question n°<?php echo $_SESSION['compteur'] ?></h1>
                            <div class="line5 mb-2"></div>
                            <p><strong><?php echo $_SESSION['question'] ?></strong></p>
                            <div class="d-flex gap-3">
                                <?php foreach ($_SESSION['reponse'] as $reponse): ?>
                                    <button type="submit" name="reponseQuiz" class="choixQuiz btn mt-4" value="<?php echo htmlspecialchars($reponse['profil']); ?>" style="width:200px;">
                                        <?php echo htmlspecialchars($reponse['texte']); ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include('includes/lien_chatbot.php'); ?>
</body>
</html>