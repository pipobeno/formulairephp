<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mail'], $_POST['pseudo'], $_POST['password'])) {
        $_SESSION["user"]["mail"] = $_POST['mail'];
        $_SESSION["user"]["pseudo"] = $_POST['pseudo'];
        $_SESSION["user"]["password"] = $_POST['password'];

        echo "Bienvenue, " . htmlspecialchars($_SESSION["user"]["pseudo"]) . "!<br>";
        echo "Vous êtes connecté";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Login</title>
</head>

<body>
    <main>
        <h1>Connexion</h1>
        <form action="" method="POST">
            <div>
                <label for="mail">Entrez votre adresse e-mail :</label>
                <input type="text" id="mail" name="mail" required><br>
            </div>
            <div>
                <label for="pseudo">Entrez votre pseudo :</label>
                <input type="text" id="pseudo" name="pseudo" required><br>
            </div>
            <div>
                <label for="password">Entrez votre Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </main>
</body>

</html>
