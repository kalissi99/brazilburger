<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "brazil_burger");
if (!$connexion) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Traitement de la suppression
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM commande_detail WHERE id = $delete_id";
    if (mysqli_query($connexion, $delete_sql)) {
        // Redirection sans paramètre pour éviter la resoumission
        header("Location: index.php?action=listCommande".(!empty($search) ? '&search='.urlencode($search) : '').(!empty($status_filter) ? '&status_filter='.urlencode($status_filter) : ''));
exit();
        exit();
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la suppression : ".mysqli_error($connexion)."</div>";
    }
}

// Traitement de la modification du statut
if (isset($_POST['update_status'])) {
    $commande_id = intval($_POST['commande_id']);
    $new_status = mysqli_real_escape_string($connexion, $_POST['new_status']);
    $update_sql = "UPDATE commande SET statut = '$new_status' WHERE id = $commande_id";
    if (mysqli_query($connexion, $update_sql)) {
        header("Location: index.php?action=listCommande".(!empty($search) ? '&search='.urlencode($search) : '').(!empty($status_filter) ? '&status_filter='.urlencode($status_filter) : ''));
        exit();
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la mise à jour : ".mysqli_error($connexion)."</div>";
    }
}

// Récupération des paramètres de recherche/filtre
$search = $_GET['search'] ?? '';
$status_filter = $_GET['status_filter'] ?? '';

// Construction de la requête principale avec filtres
$sql = "SELECT 
            cd.id,
            cd.commande_id,
            CONCAT(u.prenom, ' ', u.nom) AS client,
            co.date_commande,
            co.statut,
            IFNULL(b.nom_burger, '---') AS burger,
            IFNULL(m.nom_menu, '---') AS menu,
            cd.quantite,
            cd.prix_unitaire,
            IFNULL(c.nom_complement, '---') AS complement,
            (cd.quantite * cd.prix_unitaire) AS total_ligne
        FROM commande_detail cd
        JOIN commande co ON cd.commande_id = co.id
        JOIN user u ON co.user_id = u.id
        LEFT JOIN burger b ON cd.burger_id = b.id
        LEFT JOIN menu m ON cd.menu_id = m.id
        LEFT JOIN complement c ON cd.complement_id = c.id
        WHERE 1=1";

// Ajout des conditions de filtre
if (!empty($search)) {
    $search_term = mysqli_real_escape_string($connexion, $search);
    $sql .= " AND (CONCAT(u.prenom, ' ', u.nom) LIKE '%$search_term%' 
              OR b.nom_burger LIKE '%$search_term%' 
              OR m.nom_menu LIKE '%$search_term%')";
}

if (!empty($status_filter) && $status_filter != 'tous') {
    $status_filter = mysqli_real_escape_string($connexion, $status_filter);
    $sql .= " AND co.statut = '$status_filter'";
}

$sql .= " ORDER BY co.date_commande DESC";

$result = mysqli_query($connexion, $sql);
if (!$result) {
    die("Erreur de requête : " . mysqli_error($connexion));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails des Commandes - Brazil Burger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; background-color: #f8f9fa; }
        .header { background-color: #343a40; color: white; padding: 15px; margin-bottom: 20px; }
        .table-responsive { box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        th { background-color: #495057; color: white; }
        .badge-pending { background-color: #ffc107; color: #000; }
        .badge-delivered { background-color: #28a745; color: #fff; }
        .badge-cancelled { background-color: #dc3545; color: #fff; }
        .total-row { font-weight: bold; background-color: #e9ecef; }
        .action-buttons { white-space: nowrap; }
        .modal-header { background-color: #343a40; color: white; }
        .filter-section { background-color: #e9ecef; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="header rounded">
            <h1><i class="bi bi-list-check"></i> Détails des Commandes</h1>
            <p class="mb-0">Brazil Burger - Gestion des commandes</p>
        </div>
        
        <!-- Section Filtres et Recherche -->
        <div class="filter-section">
        <form action="index.php" method="GET" class="row g-3">
        <input type="hidden" name="action" value="listCommande">
                <div class="col-md-6">
                    <label for="search" class="form-label">Recherche :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" 
                               placeholder="Client, burger ou menu..." value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="status_filter" class="form-label">Filtrer par statut :</label>
                    <select class="form-select" id="status_filter" name="status_filter">
                        <option value="tous" <?= $status_filter == 'tous' ? 'selected' : '' ?>>Tous les statuts</option>
                        <option value="en attente" <?= $status_filter == 'en attente' ? 'selected' : '' ?>>En attente</option>
                        <option value="en cours" <?= $status_filter == 'en cours' ? 'selected' : '' ?>>En cours</option>
                        <option value="livrée" <?= $status_filter == 'livrée' ? 'selected' : '' ?>>Livrée</option>
                        <option value="annulée" <?= $status_filter == 'annulée' ? 'selected' : '' ?>>Annulée</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <?php if (!empty($search) || !empty($status_filter)) : ?>
                        <a href="index.php?action=listCommande" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Produit</th>
                        <th>Type</th>
                        <th>Qte</th>
                        <th>Prix Unitaire</th>
                        <th>Complément</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    if (mysqli_num_rows($result) > 0) :
                        while($row = mysqli_fetch_assoc($result)): 
                            $grand_total += $row['total_ligne'];
                            $status_class = match($row['statut']) {
                                'livrée' => 'badge-delivered',
                                'annulée' => 'badge-cancelled',
                                default => 'badge-pending'
                            };
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['client'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['date_commande'])) ?></td>
                        <td><span class="badge <?= $status_class ?>"><?= ucfirst($row['statut']) ?></span></td>
                        <td><?= !empty($row['burger']) ? $row['burger'] : $row['menu'] ?></td>
                        <td><?= !empty($row['burger']) ? 'Burger' : 'Menu' ?></td>
                        <td><?= $row['quantite'] ?></td>
                        <td><?= number_format($row['prix_unitaire'], 2) ?> Fcfa</td>
                        <td><?= $row['complement'] ?></td>
                        <td><?= number_format($row['total_ligne'], 2) ?> Fcfa</td>
                        <td class="action-buttons">
                            <!-- Bouton Modifier -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['commande_id'] ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            
                            <!-- Bouton Supprimer -->
                            <a href="index.php?action=listCommande&delete_id=<?= $row['id'] ?><?= !empty($search) ? '&search='.urlencode($search) : '' ?><?= !empty($status_filter) ? '&status_filter='.urlencode($status_filter) : '' ?>" 
                               class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette ligne ?')">
                                <i class="bi bi-trash"></i>
                            </a>
                            
                            <!-- Modal de modification -->
                            <div class="modal fade" id="editModal<?= $row['commande_id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modifier le statut</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="commande_id" value="<?= $row['commande_id'] ?>">
                                                <div class="mb-3">
                                                    <label class="form-label">Nouveau statut :</label>
                                                    <select name="new_status" class="form-select">
                                                        <option value="en attente" <?= $row['statut'] == 'en attente' ? 'selected' : '' ?>>En attente</option>
                                                        <option value="en cours" <?= $row['statut'] == 'en cours' ? 'selected' : '' ?>>En cours</option>
                                                        <option value="livrée" <?= $row['statut'] == 'livrée' ? 'selected' : '' ?>>Livrée</option>
                                                        <option value="annulée" <?= $row['statut'] == 'annulée' ? 'selected' : '' ?>>Annulée</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" name="update_status" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <tr class="total-row">
                        <td colspan="10" class="text-end"><strong>Total Général :</strong></td>
                        <td><strong><?= number_format($grand_total, 2) ?> Fcfa</strong></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">Aucune commande trouvée</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>

<?php
// Fermer la connexion
mysqli_close($connexion);
?>