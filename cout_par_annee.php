<?php
function render_content()
{
    global $annees_couts, $error;
?>
    <h2>Coût global du matériel acheté par année</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif (!empty($annees_couts)): ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Année</th>
                    <th>Coût global (DH)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($annees_couts as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['annee']) ?></td>
                        <td><?= number_format($row['cout_global'], 2, ',', ' ') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun matériel trouvé dans la base de données.</p>
    <?php endif; ?>
<?php
}

$annees_couts = [];
$error = '';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestion_materiel;charset=utf8", 'root', 'xuce1234', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    $sql = "SELECT YEAR(date_achat) AS annee, SUM(prix_ht) AS cout_global
            FROM materiel
            GROUP BY annee
            ORDER BY annee ASC";
    $stmt = $pdo->query($sql);
    $annees_couts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Erreur de connexion à la base de données : " . $e->getMessage();
}

include 'layout.php';
