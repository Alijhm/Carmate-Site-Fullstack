<?php 

session_start();

include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    if (!isset($_POST['codeSaisi']) || empty($_POST['codeSaisi'])) {
        $errors['code'] = "Champ à remplir.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: code_verif.php');
        exit();
    }

    if (trim($_POST['codeSaisi']) != $_SESSION['code']) {
        $_SESSION['flash_message2'] = [
            'type' => 'danger',
            'message' => "Code de vérification incorrect. "
        ];
        header('Location: code_verif.php');
        exit();
    }

    $username = $_SESSION['infoUser']['username'];
    $email = $_SESSION['infoUser']['email'];
    $dateNaissance = $_SESSION['infoUser']['dateNaissance'];
    $ville = $_SESSION['infoUser']['ville'];
    $rue = $_SESSION['infoUser']['rue'];
    $password = $_SESSION['infoUser']['password'];

    $query = 'INSERT INTO utilisateur (nomUtilisateur, motDePasse, dateDeNaissance, ville, email, rue) VALUES (:nomUtilisateur, :motDePasse, :dateDeNaissance, :ville, :email, :rue)';
    $statement = $bdd->prepare($query);
    $result = $statement->execute([
        'nomUtilisateur' => $username,
        'motDePasse' => $password,
        'dateDeNaissance' => $dateNaissance,
        'ville' => $ville,
        'email' => $email,
        'rue' => $rue
    ]);

    if ($result === false) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Erreur lors de l'enregistrement."
        ];
        header('Location: inscription.php');
        exit();
    }
    
    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => "Compte créé avec succès !"
    ];
    header('Location: connexion.php');
    exit();
    

}
?>