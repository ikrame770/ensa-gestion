<?php
$pdo = new PDO("mysql:host=localhost;dbname=gestion_materiel;charset=utf8", 'root', 'xuce1234', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$resultats = [];
$error = '';

if (isset($_POST['chercher'])) {
    $annee = trim($_POST['annee']);
    if (!preg_match('/^\d{4}$/', $annee)) {
        $error = "Veuillez entrer une année valide (ex: 2011).";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM materiel WHERE YEAR(date_achat) = :annee");
        $stmt->execute(['annee' => $annee]);
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function render_content()
{
    global $resultats, $error;
?>
    <h2>Rechercher par année d'achat</h2>

    <form method="POST">
        <label for="annee">Année :</label>
        <input type="text" id="annee" name="annee" placeholder="ex: 2011" required pattern="\d{4}" title="Année sur 4 chiffres">
        <button type="submit" name="chercher" class="btn primary">Rechercher</button>
    </form>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($resultats)): ?>
        <h3>Résultats :</h3>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Numéro d'ordre</th>
                    <th>Département</th>
                    <th>Catégorie</th>
                    <th>Désignation</th>
                    <th>Fournisseur</th>
                    <th>Prix HT (DH)</th>
                    <th>Date d'achat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultats as $mat): ?>
                    <tr>
                        <td><?= htmlspecialchars($mat['numero_ordre']) ?></td>
                        <td><?= htmlspecialchars($mat['departement']) ?></td>
                        <td><?= htmlspecialchars($mat['categorie']) ?></td>
                        <td><?= htmlspecialchars($mat['designation']) ?></td>
                        <td><?= htmlspecialchars($mat['fournisseur']) ?></td>
                        <td><?= number_format($mat['prix_ht'], 2) ?></td>
                        <td><?= htmlspecialchars($mat['date_achat']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php elseif (isset($_POST['chercher'])): ?>
        <p>Aucun matériel trouvé pour l'année <?= htmlspecialchars($_POST['annee']) ?>.</p>
    <?php endif; ?>
<?php
}

include 'layout.php';
