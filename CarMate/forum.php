<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php
    $pageTitle = 'CarMate — Forum';
    include('includes/head.php');
    include('includes/db.php');

    include('includes/choix_theme.php');

    include('includes/reinitialisation_infos_quiz.php');

    unset($_SESSION['formulaire']);
?>

<body class="bodyForum" style="<?php if(isset($_SESSION['iduser'])):if($themeSombreClair == 0):?>background-color:rgb(89, 89, 89)   ;<?php endif;endif; ?>">
    <?php include('includes/header.php');?>
    <main class="row">
        <div class="col-3 fond-lateral">
            <div class="conversations mt-4 ms-2 mb-5">
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
                <div class="row mb-5">
                    <p>CarMate vous permet de discuter avec des passionnés <strong>tout autour du monde</strong> !</p>
                    <p>Discutez sur notre <strong>Chat général</strong> avec tous les utilisateurs CarMate. Ou alors, créez vos propres <strong>discutions privées</strong> en un clic !</p>
                </div>

                <a id="lienForum" <?php if(isset($_GET['forum'])){ ?> href="forum.php" <?php }else{ ?> href="forum.php?forum" <?php } ?>><p><strong>Accédez à notre Chat général</strong></p></a>

                <p class="mt-5"><strong>Accédez à vos discussions privées :</strong></p>

                <?php 

                $q = 'SELECT * FROM discussion WHERE iduserdisc = :iduser AND iddiscussion != 1';
                $statement = $bdd->prepare($q);
                $statement->execute(['iduser' => $_SESSION['iduser']]);
                $discussions = $statement->fetchAll();

                if(empty($discussions)){
                    echo "<p>Vous n'avez pas encore eu de discussion privée avec un utilisateur CarMate.<br>Vous pouvez directement discuter avec des utilisateurs CarMate en les contactant de puis leur profil !<p>";
                }else{
                    foreach($discussions as $discussion){
                        echo "<p>- <a id='lienForum' href='forum.php?disc=" . $discussion['iddiscussion'] . "'>" . htmlspecialchars((string)$discussion['titre']) . "</a></p>";
                    }

                }
                
                ?>

            </div>
            <div class="line-vertical"></div>
        </div>

        <div class="col-8 zone-event">
            <?php if(isset($_GET['forum'])){ ?>
                <div class="row ms-4 mt-5 me-5">
                    <h1>Chat Général</h1>
                    <div class="line5 mb-2 ms-2"></div>

                    <div class="zoneMessage mb-3 mt-2">
                        <?php

                        $q = 'SELECT message.contenu, message.date, utilisateur.nomUtilisateur, message.idusermess
                        FROM message INNER JOIN utilisateur ON message.idusermess = utilisateur.iduser
                        WHERE iddiscussion = 1 ORDER BY message.date ASC'; 
                        $statement = $bdd->prepare($q);
                        $statement->execute([]);
                        $results = $statement->fetchAll();

                        foreach ($results as $message) {
                            if($message['idusermess'] == $_SESSION['iduser']){
                                echo "<div class='monMessage mb-2'>";
                                echo "<strong><a style='text-decoration:none;color:black' href='profil.php'>Moi</a> : </strong>" . htmlspecialchars($message['contenu']);
                                echo "<br><small>" . $message['date'] . "</small>";
                                echo "</div>";
                            }else{
                                echo "<div class='autreMessage mb-2'>";
                                echo "<strong><a style='text-decoration:none;color:black' href='profil_autre.php?id=" . $message['idusermess'] . "'>" . htmlspecialchars($message['nomUtilisateur']) . "</a> : </strong>" . htmlspecialchars($message['contenu']);
                                echo "<br><small>" . $message['date'] . "</small>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>

                    <form method="POST" action="traitement_forum.php" class="row zoneEcriture">
                        <input type="hidden" name="forumOuDiscussion" value="chatGeneral">
                        <div class="col-11">
                            <input type="text" class="form-control" name="message" id="exampleFormControlTextarea1" rows="1"></input>
                        </div>
                        <div class="col-1">
                            <button class="btn" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            <?php }elseif(isset($_GET['disc'])) { ?>
                <div class="row ms-4 mt-5 me-5">
                <?php
                    $iddiscussion = $_GET['disc'];

                    $q = 'SELECT titre FROM discussion WHERE iddiscussion = :iddiscussion';
                    $statement = $bdd->prepare($q);
                    $statement->execute(['iddiscussion' => $iddiscussion]);
                    $discussion = $statement->fetch(PDO::FETCH_ASSOC);
                ?>
                <h1><?php echo htmlspecialchars($discussion['titre']) ?></h1>
                <div class="zoneMessage mb-3 mt-2">
                    <?php
                        $q = 'SELECT message.contenu, message.date, utilisateur.nomUtilisateur, message.idusermess
                        FROM message INNER JOIN utilisateur ON message.idusermess = utilisateur.iduser
                        WHERE iddiscussion = :iddiscussion ORDER BY message.date ASC'; 
                        $statement = $bdd->prepare($q);
                        $statement->execute(['iddiscussion' => $iddiscussion]);
                        $results = $statement->fetchAll();

                        foreach ($results as $message) {
                            if($message['idusermess'] == $_SESSION['iduser']){
                                echo "<div class='monMessage mb-2'>";
                                echo "<strong><a style='text-decoration:none;color:black' href='profil.php'>" . htmlspecialchars($message['nomUtilisateur']) . "</a> : </strong>" . htmlspecialchars($message['contenu']);
                                echo "<br><small>" . $message['date'] . "</small>";
                                echo "</div>";
                            }else{
                                echo "<div class='autreMessage mb-2'>";
                                echo "<strong><a style='text-decoration:none;color:black' href='profil_autre.php?id=" . $message['idusermess'] . "'>" . htmlspecialchars($message['nomUtilisateur']) . "</a> : </strong>" . htmlspecialchars($message['contenu']);
                                echo "<br><small>" . $message['date'] . "</small>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>

                    <form method="POST" action="traitement_forum.php" class="row zoneEcriture">
                        <input type="hidden" name="forumOuDiscussion" value="<?php echo htmlspecialchars($iddiscussion);?>">
                        <div class="col-11">
                            <input type="text" class="form-control" name="message" id="exampleFormControlTextarea1" rows="1"></input>
                        </div>
                        <div class="col-1">
                            <button class="btn" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                    </div>
            <?php }else{ ?>
                <div class="row ms-4 mt-5 me-5">
                    <h1>Accédez au forum général et à vos discussions privées !</h1>
                    <div class="line5 mb-2 ms-2"></div>
                    <p>Utilisez le menu latéral pour discuter sur le forum général de CarMate. Sinon, accédez à vos discussions privées ou créez-en une !</p>
                </div>
            <?php } ?>
        </div>
    </main>
    <?php include('includes/footer.php');?>
    <?php include('includes/lien_chatbot.php'); ?>
</body>
</html>