
<?php
session_start();

$errors = null;
global $mail;
global $pseudo;
global $password;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST["mail"]) && !empty($_POST["pseudo"]) && !empty($_POST["password"])) {
        $_SESSION["loged_user"] = [
            "mail" => $_POST['mail'],
            "pseudo" => $_POST['pseudo'],
            "password" => $_POST['password']
        ];
        header("Location: ./test.php");
    }else {
        $errors = "Veuillez remplir tout les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/jsp.css">
    <title>Formulaire d'inscription</title>
</head>

<body>
    <main>
        <h1>Formulaire d'inscription</h1>
        <form action="" method="POST">
        <p><?=!empty($errors) ? $errors : ""?></p>
            <div>
                <label for="mail">Entrez votre adresse e-mail :</label>
                <input type="text" id="mail" name="mail">
            </div>
            <div>
                <label for="pseudo">Entrez votre Pseudo :</label>
                <input type="text" id="pseudo" name="pseudo"><br>
            </div>
            <div>
                <label for="password">Entrez votre Mot de passe :</label>
                <input type="password" id="password" name="password">
            </div>
            <div>
                <button type="submit">S'inscrire</button>
            </div>
        </form>
    </main>
</body>

</html>
