<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        die("Erreur : L'utilisateur n'est pas connecté.");
    }

    // Connexion à la base de données
    $connexion = mysqli_connect("localhost", "root", "", "brazil_burger");
    if (!$connexion) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }

    // Récupérer l'ID utilisateur directement depuis la session
    $user_id = $_SESSION['user_id'];

    // Vérifier que cet utilisateur existe bien dans la base
    $query = "SELECT id FROM user WHERE id= $user_id";
    $result = mysqli_query($connexion, $query);

    if (mysqli_num_rows($result) == 0) {
        die("Erreur : Utilisateur non trouvé.");
    }

    // Récupérer les données du formulaire
    $type = $_POST['type'];
    $produit_id = $_POST['produit_id'];
    $quantite = $_POST['quantite'];
    $prix_unitaire = $_POST['prix_unitaire'];
    $complement_id = !empty($_POST['complement_id']) ? $_POST['complement_id'] : "NULL";

    // Insérer la commande principale
    $sqlCommande = "INSERT INTO commande (user_id, date_commande, total, statut) 
                    VALUES ($user_id, NOW(), 0, 'en attente')";
    if (!mysqli_query($connexion, $sqlCommande)) {
        die("Erreur dans la requête SQL pour la commande : " . mysqli_error($connexion));
    }
    $commande_id = mysqli_insert_id($connexion);

    // Insérer le détail de la commande
    $sqlDetail = "INSERT INTO commande_detail (commande_id, burger_id, menu_id, quantite, prix_unitaire, complement_id) 
                  VALUES ($commande_id, " . ($type === 'burger' ? $produit_id : "NULL") . ", 
                                  " . ($type === 'menu' ? $produit_id : "NULL") . ", 
                                  $quantite, $prix_unitaire, " . ($complement_id !== "NULL" ? $complement_id : "NULL") . ")";

    if (!mysqli_query($connexion, $sqlDetail)) {
        die("Erreur dans la requête SQL pour le détail de la commande : " . mysqli_error($connexion));
    }

    // Calculer le total de la commande
    $total = $quantite * $prix_unitaire;
    
    // Ajouter le prix du complément s'il existe
    if ($complement_id !== "NULL") {
        $resultComp = mysqli_query($connexion, "SELECT prix FROM complement WHERE id = $complement_id");
        if ($comp = mysqli_fetch_assoc($resultComp)) {
            $total += $comp['prix'];
        }
    }

    // Mettre à jour le total de la commande
    $sqlUpdateTotal = "UPDATE commande SET total = $total WHERE id = $commande_id";
    if (!mysqli_query($connexion, $sqlUpdateTotal)) {
        die("Erreur dans la requête SQL pour la mise à jour du total : " . mysqli_error($connexion));
    }

    // Redirection vers la page de confirmation
    header("Location: confirmation.php?commande_id=$commande_id");
    exit();
}
?>
