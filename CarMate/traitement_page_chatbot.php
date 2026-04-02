<?php

session_start();

include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(!empty($_POST['messageChatBot'])){
        
        $message = strtolower(trim($_POST['messageChatBot']));

        if(strpos($message,'bonjour') !== false || strpos($message,'salut') !== false || strpos($message,'coucou') !== false || strpos($message,'bjr') !== false || strpos($message,'slt') !== false){
            $_SESSION['reponseBot'] = 'Bonjour ! Comment vas-tu ?';

            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'ça va ?') !== false || strpos($message,'ca va ?') !== false || strpos($message,'cv ?') !== false || strpos($message,'comment tu vas') !== false || strpos($message,'comment vas tu') !== false || strpos($message,'tu vas bien ?') !== false){
            $_SESSION['reponseBot'] = 'Je vais très bien et toi ?';

            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'ça va') !== false && strpos($message,'et toi') !== false){
            $_SESSION['reponseBot'] = 'Je vais super bien ! Merci de demander. Comment puis-je t\'aider ?';

            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'vais bien') !== false && strpos($message,'ça va merci') !== false){
            $_SESSION['reponseBot'] = 'Super ! Comment puis-je t\'aider ?';

            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'es tu ?') !== false || strpos($message,'sert tu ?') !== false || strpos($message,'ton utilité ?') !== false){
            $_SESSION['reponseBot'] = 'Je suis CarBot, votre assistant automatique. Vous avez des questions concernant CarMate ? Je suis là pour vous aider et vous guider !';

            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'bouton rouge') !== false || strpos($message,'voiture aléatoire') !== false){
            $_SESSION['reponseBot'] = 'Sur la page d\'accueil, vous pouvez trouver un gros bouton rouge permettant de piocher une voiture aléatoire et élargir votre champ de connaissances automobile ! Cliquez dessus et vous serez guidé vers une page avec toutes les informations sur la voiture piochée. N\'hésitez pas à vous connecter afin de pouvoir enregistrer cette voiture dans vos likes !';

            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'créer') !== false && strpos($message,'compte') !== false){
            $_SESSION['reponseBot'] = 'Pour profiter de toutes les fonctionnalités CarMate il est nécessaire de vous créer un compte. Pour cela, cliquez sur "Tableau de bord", puis sur "Se connecter" et enfin sur "Pas de compte CarMate ? Créez en un !"';

            header('location:page_chatbot.php');
            exit();
        }elseif((strpos($message,'mot de passe') !== false || strpos($message,'mdp') !== false) && (strpos($message,'oublié') !== false || strpos($message,'perdu') !== false)){
            $_SESSION['reponseBot'] = 'Vous avez oublié votre mot de passe CarMate ? Pas de soucis, allez dans le menu connexion et cliquez sur "Mot de passe oublié". Vous pourrez modifier votre mot de passe en quelques instants';

            header('location:page_chatbot.php');
            exit();
        }elseif((strpos($message,'créer') !== false || strpos($message,'modifier') !== false || strpos($message,'changer') !== false || strpos($message,'personnaliser') !== false) && strpos($message,'avatar') !== false){
            $_SESSION['reponseBot'] = 'Vous voulez créer ou modifier votre avatar ? Dans un premier temps connectez-vous, allez sur votre profil. Cliquez sur votre avatar actuel ou l\'avatar CarMate par défaut et vous pourrez ainsi personnaliser votre avatar selon vos goûts !';

            header('location:page_chatbot.php');
            exit();
        }elseif((strpos($message,'personnaliser') !== false || strpos($message,'modifier') !== false || strpos($message,'changer') !== false) && (strpos($message,'profil') !== false || strpos($message,'description') !== false || strpos($message,'voiture préférée') !== false)){
            $_SESSION['reponseBot'] = 'Pour personnaliser les informations visibles sur votre profil. Connectez-vous, allez sur votre profil et cliquez sur éditer.';

            header('location:page_chatbot.php');
            exit();
        }elseif((strpos($message,'sert') !== false || strpos($message,'utilité') !== false || strpos($message,'que faire sur') !== false || strpos($message,'que faire avec') !== false) && strpos($message,'carmate') !== false){
            $_SESSION['reponseBot'] = 'CarMate est un site pour les passionés de voiture. Vous pouvez y trouver la voiture la plus adaptée à votre profil, acheter des équipements automobiles, trouver des événements et discuter avec d\'autres passionnés !';

            header('location:page_chatbot.php');
            exit();
        }elseif((strpos($message,'sert') !== false || strpos($message,'utilité') !== false || strpos($message,'que faire') !== false || strpos($message,'que faire') !== false) && strpos($message,'voiture idéale') !== false){
            $_SESSION['reponseBot'] = 'La section voiture idéale de CarMate vous permet de répondre à un quiz sur les voitures et sur votre personnalité. C\'est un quiz unique qui vous permettra de trouver le véhicule le plus adapté à vos goûts et à votre rythme de vie !';

            header('location:page_chatbot.php');
            exit();
        }elseif((strpos($message,'sert') !== false || strpos($message,'utilité') !== false || strpos($message,'que faire') !== false || strpos($message,'que faire') !== false) && strpos($message,'garage') !== false){
            $_SESSION['reponseBot'] = 'La section garage de CarMate vous permet de d\'acheter et vendre des accessoires, équipements et pièces automobiles à l\ensemble de la communauté CarMate.';

            header('location:page_chatbot.php');
            exit();
        }elseif((strpos($message,'sert') !== false || strpos($message,'utilité') !== false || strpos($message,'que faire') !== false || strpos($message,'que faire') !== false) && strpos($message,'forum') !== false){
            $_SESSION['reponseBot'] = 'La section forum de CarMate vous permet de discuter avec des utilisateurs CarMate à travers le monde ! Vous pouvez accéder à notre chat général ou alors contacter certains utilisateurs précisémment directement via leur profil.';

            header('location:page_chatbot.php');
            exit();
        }elseif((strpos($message,'sert') !== false || strpos($message,'utilité') !== false || strpos($message,'que faire') !== false || strpos($message,'que faire') !== false) && strpos($message,'événement') !== false){
            $_SESSION['reponseBot'] = 'La section événement de CarMate vous permet de découvrir des événements automobiles mis en avant par CarMate. Exposition, course, rassemblement... Chacun y trouvera son compte !';

            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'esgi') !== false){
            $_SESSION['reponseBot'] = 'En tant que bot je suis censé rester neutre, mais cette fois ci je vais faire une exception. L\'ESGI est une excellente école d\'informatique avec les meilleurs professeurs (notamment M. Sananes). Les éléves sont exceptionnels, je me doit de vous parler de : Ali Jahmi, Thomas Large et Roland Fert qui vont sans aucun doute avoir une excellente note à leur Projet Annuel !';

            $_SESSION['ESGI'] = 1;
            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'plus') !== false && strpos($message,'chère') !== false && strpos($message,'voiture') !== false && strpos($message,'?') !== false){
            $_SESSION['reponseBot'] = 'Actuellement, la voiture la plus chère est certainement la Rolls-Royce Sweptail estimée au prix de 12 millions d\'euros !';

            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'plus') !== false && strpos($message,'belle') !== false && strpos($message,'voiture') !== false && strpos($message,'?') !== false){
            $_SESSION['reponseBot'] = 'C\'est une question très compliquée et subjective. Mais une des plus belles voitures de l\'histoire de l\'automobile est sans aucun doute la Ferrari Roma';

            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'plus') !== false && strpos($message,'culte') !== false && strpos($message,'voiture') !== false && strpos($message,'?') !== false){
            $_SESSION['reponseBot'] = 'C\'est une question très compliquée et subjective. Mais une des voitures les plus cultes de l\'histoire de l\'automobile est sans aucun doute l\'Aston Martin DB5';

            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'merci') !== false || strpos($message,'bien vu') !== false|| strpos($message,'bv') !== false || strpos($message,'mrc') !== false){
            $_SESSION['reponseBot'] = 'Avec plaisir ! Une autre question ?';

            header('location:page_chatbot.php');
            exit();
        }elseif((strpos($message,'entretien') !== false || strpos($message,'vidange') !== false || strpos($message,'revision') !== false || strpos($message,'révision') !== false) && (strpos($message,'quand') !== false || strpos($message,'comment') !== false)){
            $_SESSION['reponseBot'] = 'Pour l\'entretien de votre voiture, pensez à consulter le carnet d\'entretien du constructeur. En général, une vidange est recommandée tous les 10 000 à 15 000 km. Si vous avez besoin d\'une réponse précise, n\'hésitez pas à poser votre question sur le chat général. Un tas de passionnés et de professionnels sauront vous répondre !';

            header('location:page_chatbot.php');
            exit();
        }elseif(strpos($message,'probleme') !== false || strpos($message,'problème') !== false || strpos($message,'panne') !== false || strpos($message,'cassé') !== false || strpos($message,'casser') !== false || strpos($message,'ne fonctionne pas') !== false || strpos($message,'ne démarre pas') !== false || strpos($message,'ne demarre pas') !== false || strpos($message,'comment réparer') !== false || strpos($message,'comment reparer') !== false){
            $_SESSION['reponseBot'] = 'Vous rencontrez un problème avec votre voiture ? Décrivez votre souci sur notre forum, des professionnels vous répondront en quelques instants. C\'est ça la magie de la communauté CarMate !';

            header('location:page_chatbot.php');
            exit();
        }elseif((strpos($message,'acheter') !== false || strpos($message,'trouver') !== false || strpos($message,'comparateur') !== false) && (strpos($message,'voiture') !== false || strpos($message,'véhicule') !== false || strpos($message,'automobile') !== false || strpos($message,'vehicule') !== false)){
            $_SESSION['reponseBot'] = 'Pour trouver la voiture qu\'il vous faut, utilisez notre section "Voiture idéale" qui vous donnera une idée du type de voiture le plus adapté à vous. N\'hésitez pas à discuter de votre projet d\'acheter une voiture sur notre forum !';

            header('location:page_chatbot.php');
            exit();
        }else{
            $_SESSION['reponseBot'] = 'Désolé, je n\'ai pas compris votre demande. CarBot est encore en phase Beta, réessayez en utilisant plus de mots clés';

            header('location:page_chatbot.php');
            exit();
        }
    }else{
        $_SESSION['reponseBot'] = 'Bonjour, je suis CarBot. Avez vous des questions concernant CarMate ?';

        header('location:page_chatbot.php');
        exit();
    }
}    
?>