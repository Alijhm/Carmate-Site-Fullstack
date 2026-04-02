<?php 

    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();

    include('includes/db.php');

    $q = 'SELECT email, ville, rue FROM utilisateur WHERE iduser = :iduser';
    $statement = $bdd->prepare($q);
    $statement->execute([
        'iduser' => $_SESSION['iduser']
    ]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    $mailAcheteur = $result['email'];
    $adresseAcheteur = $result['rue'] . ', ' . $result['ville'];

    $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'carmateoff@gmail.com';
            $mail->CharSet = 'UTF-8';
            $mail->Password   = 'znhinxbqmowdluva';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('carmateoff@gmail.com', 'Confirmation Commande CarMate');
            $mail->addAddress($mailAcheteur);
            
            $mail->isHTML(true);
            $mail->Subject = 'CarMate - confirmation Commande';
            $mail->Body = '
            <div style= "background-color: #1a2a3d; padding: 35px; text-align: center;">
                <p style="color: white; text-decoration: none;">Votre commande est validée, le vendeur procéde dès à présent à son envoi.</strong></p>;
            </div>
            ';


            $mail->send();

            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => "Vous avez reçu un mail de confirmation à $mailAcheteur."
            ];
            
        } catch (Exception $e) {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => "L'envoi du mail de confirmation a échoué."
            ];
        }

    
    foreach($_SESSION['panier'] as $article){
        $idvente = $article['idvente'];

        $q = 'SELECT email, produit FROM utilisateur 
        INNER JOIN offre ON utilisateur.iduser = offre.iduser
        WHERE idvente = :idvente';
        $statement = $bdd->prepare($q);
        $statement->execute([
            'idvente' => $idvente
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $mailVendeur = $result['email'];
        $nomArticle = $result['produit'];

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->CharSet = 'UTF-8';
            $mail->Username   = 'carmateoff@gmail.com';
            $mail->Password   = 'znhinxbqmowdluva';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('carmateoff@gmail.com', 'Notification de Vente CarMate');
            $mail->addAddress($mailVendeur);
            
            $mail->isHTML(true);
            $mail->Subject = 'CarMate - Notification de Vente';
            $mail->Body = '
            <div style= "background-color: #1a2a3d; padding: 35px; text-align: center;">
                <p style="color: white; text-decoration: none;">Félicitations, un de vos articles à été acheté sur le système e-commerce de CarMate. Veuillez procéder à l\'envoi de l\'article.</strong><br>L\'article concerné est : ' . $nomArticle . ' qui doit être envoyé à l\'adresse suivant : ' . $adresseAcheteur . '</p>;
            </div>
            ';


            $mail->send();
            
        } catch (Exception $e) {
        
        }

        $query = 'UPDATE offre SET vendu = 1, idacheteur = :iduser, dateAchat = NOW() WHERE idvente = :idvente';
        $statement = $bdd->prepare($query);
        $result = $statement->execute([
            'iduser' => $_SESSION['iduser'],
            'idvente' => $idvente
        ]);

    }

    unset($_SESSION['panier']);

?>

<!DOCTYPE html>
<html lang="en">

<?php 
    $pageTitle = 'CarMate — Inscription';
    include('includes/head.php');
?>

<body>
    <?php include('includes/headerSecond.php'); ?>
    
    <main>
    <div class="fond-connexion">
            <div class="col-6 fond-formulaireConnexion mt-5">
                <h3>Paiement validé</h3>
                <div class="line5 mb-2"></div>
                <p>La transaction a réussi ! Félicitations pour votre achat. Le vendeur concerné va dès à présent vous procéder à l'envoi de votre commande.</p>
                <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'success'): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                    </div>
                    <?php unset($_SESSION['flash_message']); ?>
                <?php endif; ?>
                
                <a href="index.php"><p class="mt-2">Accueil</p></a>
                
            </div>
        </div>
    </main>
</body>