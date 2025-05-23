<?php
$pdo = new PDO("mysql:host=localhost;dbname=gestion_materiel;charset=utf8", 'root', 'xuce1234', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$resultats = [];
$error = '';

if (isset($_POST['chercher'])) {
    $designation = trim($_POST['designation']);
    if ($designation === '') {
        $error = "Veuillez saisir une designation.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM materiel WHERE designation LIKE :designation");
        $stmt->execute(['designation' => "%$designation%"]);
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function render_content()
{
    global $resultats, $error;
?>
    <h2>Rechercher par désignation</h2>

    <form method="POST">
        <label for="designation">Désignation :</label>
        <input type="text" id="designation" name="designation" placeholder="ex: OSCILLOSCOPE ANALOGIQUE" required>
        <button type="submit" name="chercher" class="btn primary">Rechercher</button>
    </form>

    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
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
        <p>Aucun matériel trouvé avec la désignation <?= htmlspecialchars($_POST['designation']) ?>.</p>
    <?php endif; ?>
<?php
}

include 'layout.php';
