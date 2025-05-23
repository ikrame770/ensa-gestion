<?php
session_start();

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=gestion_materiel;charset=utf8", 'root', 'xuce1234', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Vérifie si l'utilisateur existe
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            header("Location: layout.php");
            exit();
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Log-In page</title>
    <link rel="stylesheet" href="styles/loginStyles.css">
</head>

<body>

    <header>
        <h1>ENSA Fès - Gestion du Matériel</h1>
        <nav class="nav-links">
            <a href="login.php">Connexion</a>
            <a href="register.php">Créer un compte</a>
        </nav>
    </header>

    <div class="main-content">
        <div class="login-container">
            <h2> Connexion </h2>

            <?php if ($error): ?>
                <p style="color:red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" value="Se connecter">
            </form>

            <div class="footer-text">© ENSA Fès - Gestion du Matériel Scientifique</div>
        </div>
    </div>

</body>

</html>