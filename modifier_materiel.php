<?php

// Connexion à la base de données
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
$materiel = null;

// Si on clique sur chercher pour récupérer un matériel à modifier
if (isset($_POST['fetch'])) {
    $numero_ordre = trim($_POST['numero_ordre']);
    if ($numero_ordre === '') {
        $error = "Veuillez entrer un numéro d'ordre.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM materiel WHERE numero_ordre = :num");
        $stmt->execute(['num' => $numero_ordre]);
        $materiel = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$materiel) {
            $error = "Aucun matériel trouvé avec ce numéro d'ordre.";
        }
    }
}

// Si on clique sur Modifier pour enregistrer les changements
if (isset($_POST['update'])) {
    $numero_ordre = trim($_POST['numero_ordre']);
    $departement = $_POST['departement'] ?? '';
    $categorie = trim($_POST['categorie'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $fournisseur = trim($_POST['fournisseur'] ?? '');
    $prix_ht = trim($_POST['prix_ht'] ?? '');
    $date_achat = $_POST['date_achat'] ?? '';

    // Validation simple
    if ($numero_ordre === '' || $categorie === '' || $designation === '' || $date_achat === '') {
        $error = "Veuillez remplir tous les champs obligatoires.";
        // Reload materiel to refill form on error
        $materiel = [
            'numero_ordre' => $numero_ordre,
            'departement' => $departement,
            'categorie' => $categorie,
            'designation' => $designation,
            'fournisseur' => $fournisseur,
            'prix_ht' => $prix_ht,
            'date_achat' => $date_achat
        ];
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE materiel SET departement = :departement, categorie = :categorie, designation = :designation, fournisseur = :fournisseur, prix_ht = :prix_ht, date_achat = :date_achat WHERE numero_ordre = :num");
            $stmt->execute([
                'departement' => $departement,
                'categorie' => $categorie,
                'designation' => $designation,
                'fournisseur' => $fournisseur,
                'prix_ht' => $prix_ht,
                'date_achat' => $date_achat,
                'num' => $numero_ordre
            ]);
            $success = "Le matériel a été modifié avec succès.";
            // Reload updated materiel
            $stmt = $pdo->prepare("SELECT * FROM materiel WHERE numero_ordre = :num");
            $stmt->execute(['num' => $numero_ordre]);
            $materiel = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}

function render_content()
{
    global $error, $success, $materiel;
?>

    <h1>Modifier un Matériel</h1>

    <!-- Form pour chercher le matériel par numéro d'ordre -->
    <form method="POST" action="">
        <fieldset>
            <legend>Rechercher Matériel</legend>
            <div class="form-group">
                <label for="numero_ordre_search">Numéro d'ordre :</label>
                <input type="text" id="numero_ordre_search" name="numero_ordre" value="<?= htmlspecialchars($materiel['numero_ordre'] ?? '') ?>" required>
            </div>
            <div class="button-group">
                <button type="submit" name="fetch" class="btn primary">Chercher</button>
            </div>
        </fieldset>
    </form>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($materiel): ?>
        <form method="POST" action="">
            <fieldset>
                <legend>Détails du matériel</legend>

                <input type="hidden" name="numero_ordre" value="<?= htmlspecialchars($materiel['numero_ordre']) ?>">

                <div class="form-group">
                    <label>Département :</label>
                    <div class="radio-group">
                        <input type="radio" id="gei" name="departement" value="GEI" <?= ($materiel['departement'] === 'GEI') ? 'checked' : '' ?>>
                        <label for="gei">GEI</label>

                        <input type="radio" id="gi" name="departement" value="GI" <?= ($materiel['departement'] === 'GI') ? 'checked' : '' ?>>
                        <label for="gi">GI</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="categorie">Catégorie :</label>
                    <input type="text" id="categorie" name="categorie" value="<?= htmlspecialchars($materiel['categorie']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="designation">Désignation :</label>
                    <input type="text" id="designation" name="designation" value="<?= htmlspecialchars($materiel['designation']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="fournisseur">Fournisseur :</label>
                    <input type="text" id="fournisseur" name="fournisseur" value="<?= htmlspecialchars($materiel['fournisseur']) ?>">
                </div>

                <div class="form-group">
                    <label for="prix_ht">Prix HT :</label>
                    <input type="text" id="prix_ht" name="prix_ht" value="<?= htmlspecialchars($materiel['prix_ht']) ?>">
                </div>

                <div class="form-group">
                    <label for="date_achat">Date d'acquisition :</label>
                    <input type="date" id="date_achat" name="date_achat" value="<?= htmlspecialchars($materiel['date_achat']) ?>">
                </div>

                <div class="button-group">
                    <button type="submit" name="update" class="btn primary">Modifier</button>
                    <button type="reset" class="btn secondary">Annuler</button>
                </div>
            </fieldset>
        </form>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
<?php endif;
}

include 'layout.php';
