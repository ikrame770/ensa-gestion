<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.html");
    exit();
}

$numero_ordre = trim($_POST['numero_ordre'] ?? '');
$departement = trim($_POST['departement'] ?? '');
$categorie = trim($_POST['categorie'] ?? '');
$designation = trim($_POST['designation'] ?? '');
$fournisseur = trim($_POST['fournisseur'] ?? '');
$prix_ht = trim($_POST['prix_ht'] ?? '');
$date_achat = trim($_POST['date_achat'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($numero_ordre === '' || $departement === '' || $categorie === '' || $designation === '' || $fournisseur === '' || $prix_ht === '' || $date_achat === '') {
        die("Tous les champs sont obligatoires.");
    }

    // Connexion à ma base
    $host = 'localhost';
    $dbname = 'gestion_materiel';
    $username = 'root';
    $password = 'xuce1234';
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $sql = "INSERT INTO materiel (numero_ordre, departement, categorie, designation, fournisseur, prix_ht, date_achat)
                VALUES (:numero_ordre, :departement, :categorie, :designation, :fournisseur, :prix_ht, :date_achat)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':numero_ordre' => $numero_ordre,
            ':departement' => $departement,
            ':categorie' => $categorie,
            ':designation' => $designation,
            ':fournisseur' => $fournisseur,
            ':prix_ht' => $prix_ht,
            ':date_achat' => $date_achat
        ]);
//redirect
        header("Location: accueil.php?msg=Matériel ajouté avec succès");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de l'insertion : " . $e->getMessage());
    }
} else {
    header("Location: accueil.php");
    exit();
}
