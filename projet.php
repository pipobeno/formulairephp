<?php
session_start();

$serverName = "localhost";
$username = "root";
$password = '';

try {
    $db = new PDO("mysql:host=$serverName;dbname=digamma", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie<br>";

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// Traitement du formulaire d'insertion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash du mot de passe

    try {
        $stmt = $db->prepare("INSERT INTO user (fname, name, email, password) VALUES (:fname, :name, :email, :password)");
        $stmt->execute([
            ':fname' => $fname,
            ':name' => $name,
            ':email' => $email,
            ':password' => $password
        ]);
        echo "Élève ajouté avec succès.<br>";

    } catch (PDOException $e) {
        die("Erreur d'insertion : " . $e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
</head>
<body>
    <header>
        <h1>Liste des élèves</h1>
        <?php
        try {
            $stmt = $db->query("SELECT * FROM user");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['fname']}</td>
                        <td>{$row['email']}</td>
                      </tr><br>";
            }
            echo "</table>";
        
        } catch (PDOException $e) {
            die("Erreur de récupération : " . $e->getMessage());
        }
        ?>
    </header>
    <main>
        <h2>Ajouter Un élève</h2>
        <form action="" method="POST">
            <label for="fname">Entrez votre Prénom :</label>
            <input type="text" id="fname" name="fname"><br>
            <label for="name">Entrez votre nom :</label>
            <input type="text" id="name" name="name"><br>
            <label for="email">Entrez votre e-mail :</label>
            <input type="text" id="email" name="email"><br>
            <label for="password">Entrez un mot de passe :</label>
            <input type="password" id="password" name="password">
            <button type="submit">Entrez</button>
        </form>
        
    </main>
    <footer></footer>
</body>
</html>