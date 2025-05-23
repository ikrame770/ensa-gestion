<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestion du matériel scientifique</title>
    <link rel="stylesheet" href="styles/layoutStyles.css">
</head>

<body>

    <header class="main-header">
        <div class="header-left">
            <img src="styles/ENSAFES_logo.png" alt="Logo ENSA Fès">
        </div>

        <div class="header-center">
            <h2>ENSA Fès – Gestion du Matériel</h2>
        </div>

        <div class="header-right">
            <a href="logout.php" class="logout-link"> Déconnexion </a>
        </div>
    </header>


    <div class="container">
        <div class="sidebar">
            <h3>Matériel Scientifique</h3>

            <strong>Gérer matériel</strong>
            <a href="ajouter_materiel.php">➕ Ajouter matériel</a>
            <a href="modifier_materiel.php">✏️ Modifier matériel</a>
            <a href="supprimer_materiel.php">🗑️ Supprimer matériel</a>

            <strong>Rechercher matériel</strong>
            <a href="Rechercher_par_annee.php">📅 Rechercher par date</a>
            <a href="Rechercher_par_designation.php">🔍 Rechercher par désignation</a>
            <a href="Rechercher_par_categorie.php">📂 Rechercher par catégorie</a>

            <strong>Statistiques</strong>
            <a href="cout_par_categorie.php">📊 Afficher par catégorie</a>
            <a href="cout_par_annee.php">💰 Afficher coûts par année</a>
            <a href="afficher_tous.php">Afficher tous les matériels</a>

            <br><br>
            <a href="accueil.php">🔙 Retour à la page d'accueil</a>
        </div>

        <div class="main">
            <?php
            if (function_exists('render_content')) {
                render_content();
            } else {
                echo '<h2>Bienvenue</h2>';
                echo '<p>Bienvenue dans l\'application de gestion du matériel scientifique de l\'ENSA Fès. Sélectionnez une option à gauche pour commencer.</p>';
            }
            ?>
        </div>
    </div>

    <footer>
        &copy; <?= date('Y') ?> ENSA Fès
    </footer>

</body>

</html>