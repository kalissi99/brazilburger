<?php




// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
     header("Location: ../../login.php");
   // echo "<script>window.location.href = '../../login.php</script>";
    exit();
}

// Vérifier si les paramètres "type" et "id" existent dans l'URL
if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die("Type ou ID du produit manquant !");
}

$type = $_GET['type'];
$id = intval($_GET['id']);

// Récupérer le produit en fonction de son type
if ($type === 'burger') {
    $sql = "SELECT * FROM burger WHERE id = $id";
} elseif ($type === 'menu') {
    $sql = "SELECT * FROM menu WHERE id = $id";
} else {
    die("Type de produit invalide !");
}

$result = mysqli_query($connexion, $sql);
$produit = mysqli_fetch_assoc($result);

if (!$produit) {
    die("Produit non trouvé !");
}

// Récupérer la liste des compléments
$sqlComplement = "SELECT * FROM complement";
$complements = mysqli_query($connexion, $sqlComplement);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passer une commande</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Passer votre commande</h2>

        <?php if ($produit) { ?>
            <div class="card">
                <img src="<?= $produit['image'] ?>" alt="Image du produit" style="width:200px;">
                <h3><?= ($type === 'burger') ? $produit['nom_burger'] : $produit['nom_menu'] ?></h3>
                <p><strong>Prix :</strong> <?= $produit['prix'] ?> Fcfa</p>
            </div>

            <form action="./pages/ClientDashboard/process_commande.php" method="POST">
                <input type="hidden" name="type" value="<?= $type ?>">
                <input type="hidden" name="produit_id" value="<?= $id ?>">
                <input type="hidden" name="prix_unitaire" value="<?= $produit['prix'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

                <label for="quantite">Quantité :</label>
                <input type="number" name="quantite" id="quantite" min="1" value="1" required>

                <?php if ($type === 'burger') { ?>
                    <label for="complement">Choisissez un complément :</label>
                    <select name="complement_id">
                        <option value="">Aucun</option>
                        <?php while ($comp = mysqli_fetch_assoc($complements)) { ?>
                            <option value="<?= $comp['id'] ?>"><?= $comp['nom_complement'] ?> (+<?= $comp['prix'] ?>Fcfa)</option>
                        <?php } ?>
                    </select>
                <?php } ?>

                <button type="submit" class="btn btn-success">Valider la commande</button>
            </form>
        <?php } else { ?>
            <p>Produit non trouvé.</p>
        <?php } ?>
    </div>
</body>
</html>
