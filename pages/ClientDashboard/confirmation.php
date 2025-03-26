<?php
//session_start();
//require_once "../../config/database.php";

// Vérifier si une commande a été passée
if (!isset($_GET['commande_id'])) {
    header("Location: ../../index.php"); // Redirige vers la page d'accueil si aucune commande
    exit();
}

$connexion = mysqli_connect("localhost", "root", "", "brazil_burger");

$commande_id = intval($_GET['commande_id']);

// Récupérer les informations de la commande
$sqlCommande = "SELECT c.*, u.nom, u.prenom
                FROM commande c
                JOIN `user` u ON c.user_id = u.id
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-lg p-4">
            <h2 class="text-success text-center">Commande confirmée !</h2>
            <p class="text-center">Merci <strong><?= $commande['prenom'] . " " . $commande['nom'] ?></strong> pour votre commande.</p>
            <p><strong>Date :</strong> <?= $commande['date_commande'] ?></p>
            <p><strong>Statut :</strong> <span class="badge bg-info text-dark"> <?= ucfirst($commande['statut']) ?> </span></p>

            <h3 class="mt-4">Détails de votre commande :</h3>
            <ul class="list-group">
                <?php while ($row = mysqli_fetch_assoc($details)) { ?>
                    <li class="list-group-item">
                        <?= !empty($row['nom_burger']) ? "<strong>Burger :</strong> " . $row['nom_burger'] : "<strong>Menu :</strong> " . $row['nom_menu'] ?>
                        <br>
                        <strong>Quantité :</strong> <?= $row['quantite'] ?>
                        <br>
                        <strong>Prix Unitaire :</strong> <?= number_format($row['prix_unitaire'], 2) ?> Fcfa
                        <?php if (!empty($row['nom_complement'])) { ?>
                            <br><strong>Complément :</strong> <?= $row['nom_complement'] ?>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
            <h3 class="mt-4 text-center">Total à payer : <span class="text-success fw-bold"><?= number_format($commande['total'], 2) ?> Fcfa</span></h3>
            <div class="text-center mt-3">
                <a href="../../index.php?action=pageAccueil" class="btn btn-primary">Retour à l'accueil</a>
                <a href="genererPdf.php?commande_id=<?= $commande_id ?>" class="btn btn-success ms-2">
             <i class="bi bi-file-earmark-pdf"></i> Télécharger PDF
    </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
