<?php
//session_start();
//require_once "../../config/database.php";

// Vérifier si une commande a été passée
if (!isset($_GET['commande_id'])) {
    header("Location: ../../index.php"); // Redirige vers la page d'accueil si aucune commande
    exit();
}

$connexion = mysqli_connect("localhost", "root", "", "brasil_burger");

$commande_id = intval($_GET['commande_id']);

// Récupérer les informations de la commande
$sqlCommande = "SELECT c.id, c.date_commande, c.total, c.statut, u.nom, u.prenom
                FROM commande c
                JOIN user u ON c.user_id = u.id
                WHERE c.id = $commande_id";
$resultCommande = mysqli_query($connexion, $sqlCommande);
$commande = mysqli_fetch_assoc($resultCommande);

// Récupérer les détails des produits commandés
$sqlDetails = "SELECT cd.quantite, cd.prix_unitaire, 
                      b.nom_burger, m.nom_menu, comp.nom_complement
               FROM commande_detail cd
               LEFT JOIN burger b ON cd.burger_id = b.id
               LEFT JOIN menu m ON cd.menu_id = m.id
               LEFT JOIN complement comp ON cd.complement_id = comp.id
               WHERE cd.commande_id = $commande_id";
$details = mysqli_query($connexion, $sqlDetails);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Commande confirmée !</h2>

        <p>Merci <strong><?= $commande['prenom'] . " " . $commande['nom'] ?></strong> pour votre commande.</p>
        <p><strong>Date :</strong> <?= $commande['date_commande'] ?></p>
        <p><strong>Statut :</strong> <?= ucfirst($commande['statut']) ?></p>

        <h3>Détails de votre commande :</h3>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($details)) { ?>
                <li>
                    <?= !empty($row['nom_burger']) ? "<strong>Burger :</strong> " . $row['nom_burger'] : "<strong>Menu :</strong> " . $row['nom_menu'] ?>
                    <br>
                    <strong>Quantité :</strong> <?= $row['quantite'] ?>
                    <br>
                    <strong>Prix Unitaire :</strong> <?= number_format($row['prix_unitaire'], 2) ?> €
                    <?php if (!empty($row['nom_complement'])) { ?>
                        <br><strong>Complément :</strong> <?= $row['nom_complement'] ?>
                    <?php } ?>
                </li>
                <hr>
            <?php } ?>
        </ul>

        <h3>Total à payer : <span style="color:green;"><?= number_format($commande['total'], 2) ?> €</span></h3>

        <a href="../../index.php" class="btn btn-primary">Retour à l'accueil</a>
    </div>
</body>
</html>
