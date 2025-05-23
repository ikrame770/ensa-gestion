<?php

$host = 'localhost';
$dbname = 'gestion_materiel'; 
$username = 'root';
$password = 'xuce1234';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$error = '';
$success = '';
$inputValue = '';
$inputClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero_ordre']);
    $inputValue = htmlspecialchars($numero);

    if ($numero === '') {
        $error = "Veuillez entrer un numéro d'ordre.";
        $inputClass = 'invalid';
    } else {
        
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM materiel WHERE numero_ordre = :num");
        $stmt->execute(['num' => $numero]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            
            $delete = $pdo->prepare("DELETE FROM materiel WHERE numero_ordre = :num");
            $delete->execute(['num' => $numero]);
            $success = "Le matériel avec le numéro $numero a été supprimé.";
            $inputValue = '';
        } else {
            $error = "Aucun matériel trouvé avec ce numéro.";
            $inputClass = 'invalid';
        }
    }
}

// Fonction pour afficher le contenu dans le layout
function render_content()
{
    global $error, $success, $inputValue, $inputClass;
?>
    <h2>Supprimer un Matériel</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="numero_ordre">Numéro d'ordre :</label>
            <input type="text" id="numero_ordre" name="numero_ordre" class="<?= $inputClass ?>" value="<?= $inputValue ?>">
            <?php if ($error): ?>
                <div class="error-message" style="color:red;"><?= $error ?></div>
            <?php elseif ($success): ?>
                <div class="success-message" style="color:green;"><?= $success ?></div>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn primary">Supprimer</button>
    </form>
<?php
}

include 'layout.php';
