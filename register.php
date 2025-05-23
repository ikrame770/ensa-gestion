<?php
session_start();

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=gestion_materiel;charset=utf8", 'root', 'xuce1234', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Vérifie si le nom est autorisé
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM noms_autorises WHERE nom_complet = :username");
        $stmt->execute(['username' => $username]);
        $isAuthorized = $stmt->fetchColumn();

        if (!$isAuthorized) {
            $error = "Ce nom n'est pas autorisé à s'inscrire. Veuillez contacter l'administration.";
        } else {
            // Vérifie si déjà inscrit
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE username = :username");
            $stmt->execute(['username' => $username]);
            if ($stmt->fetchColumn() > 0) {
                $error = "Ce nom d'utilisateur est déjà enregistré.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (username, password) VALUES (:username, :password)");
                $stmt->execute([
                    'username' => $username,
                    'password' => $hashedPassword
                ]);
                header("Location: login.php");
                exit();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer un compte - ENSA Fès</title>
    <link rel="stylesheet" href="styles/loginStyles.css">
</head>

<body>

    <header>
        <h1>ENSA Fès - Gestion du Matériel</h1>
        <nav class="nav-links">
            <a href="login.php">Connexion</a>
        </nav>
    </header>

    <div class="main-content">
        <div class="login-container">
            <h2>Créer un compte</h2>

            <?php if ($error): ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php elseif ($success): ?>
                <p style="color: green;"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <input type="submit" value="Créer le compte">
            </form>

            <div class="footer-text">© ENSA Fès - Gestion du Matériel Scientifique</div>
        </div>
    </div>

</body>

</html>