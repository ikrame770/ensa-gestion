<?php
function render_content()
{
    global $materiels, $error;
?>
    <h2>Liste de tout le matériel</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif (!empty($materiels)): ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Numéro d'ordre</th>
                    <th>Département</th>
                    <th>Catégorie</th>
                    <th>Désignation</th>
                    <th>Fournisseur</th>
                    <th>Prix HT (DH)</th>
                    <th>Date d'acquisition</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materiels as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['numero_ordre']) ?></td>
                        <td><?= htmlspecialchars($m['departement']) ?></td>
                        <td><?= htmlspecialchars($m['categorie']) ?></td>
                        <td><?= htmlspecialchars($m['designation']) ?></td>
                        <td><?= htmlspecialchars($m['fournisseur']) ?></td>
                        <td><?= number_format($m['prix_ht'], 2, ',', ' ') ?></td>
                        <td><?= htmlspecialchars($m['date_achat']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun matériel trouvé dans la base de données.</p>
<?php endif;
}

$error = '';
$materiels = [];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestion_materiel;charset=utf8", 'root', 'xuce1234', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $stmt = $pdo->query("SELECT * FROM materiel ORDER BY numero_ordre ASC");
    $materiels = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Erreur lors de la récupération des données : " . $e->getMessage();
}

include 'layout.php';
