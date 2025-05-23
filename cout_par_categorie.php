<?php
function render_content()
{
    global $categories_couts, $error;
?>
    <h2>Coût global du matériel par catégorie</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif (!empty($categories_couts)): ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Catégorie</th>
                    <th>Coût global (DH)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories_couts as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['categorie']) ?></td>
                        <td><?= number_format($row['cout_global'], 2, ',', ' ') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune catégorie trouvée dans la base de données.</p>
    <?php endif; ?>
<?php
}

$categories_couts = [];
$error = '';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestion_materiel;charset=utf8", 'root', 'xuce1234', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $sql = "SELECT categorie, SUM(prix_ht) AS cout_global
            FROM materiel
            GROUP BY categorie
            ORDER BY categorie ASC";
    $stmt = $pdo->query($sql);
    $categories_couts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Erreur de connexion à la base de données : " . $e->getMessage();
}

include 'layout.php';
