<!DOCTYPE html>
<html lang="en">

<?php 
    $pageTitle = 'CarMate — CarBot';
    include('includes/head.php');
    session_start();
?>

<body>
    <?php 
    include('includes/headerSecond.php');
    ?>

    <main class="main-connexion">
        <div class="fond-connexion">
            <div class="col-4 fond-formulaireConnexion mt-5" style="width:800px">
                <div class="row">
                    <div class="col-12">
                        <h3>Des question ?</h3>
                        <div class="line5 mb-2"></div>
                        <p>Posez les à notre CarBot</p>
                        <div class="zoneMessage mb-3 mt-2">
                            <?php if(isset($_SESSION['reponseBot'])){
                                $style = '';
                                if (isset($_SESSION['ESGI'])) {
                                    $style = 'background-color: #00eaff;';
                                }
                            ?>
                                <div class="autreMessage mb-2" style="<?= $style ?>">
                                    <strong><p>CarBot : </strong><?= htmlspecialchars($_SESSION['reponseBot']); ?></p>
                                </div>
                            <?php unset($_SESSION['reponseBot']); ?>
                            <?php unset($_SESSION['ESGI']); ?>
                            <?php } ?>
                        </div>

                        <form method="POST" action="traitement_page_chatbot.php" name="messageChatBot" class="row zoneEcriture">
                            <div class="col-10">
                                <input type="text" class="form-control" name="messageChatBot" id="exampleFormControlTextarea1" rows="1"></input>
                            </div>
                            <div class="col-2">
                                <button class="btn" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                        <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>