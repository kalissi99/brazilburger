<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "brazil_burger");
if (!$connexion) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Déterminer quelle statistique afficher
$stat_type = $_GET['stat'] ?? 'commandes'; // Par défaut, afficher les commandes

// Requêtes communes aux deux vues
$mois_labels = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

// Requête pour le nombre de commandes par mois
$sql_commandes = "SELECT 
                    MONTH(date_commande) as mois, 
                    COUNT(*) as nombre_commandes 
                  FROM commande 
                  GROUP BY MONTH(date_commande) 
                  ORDER BY mois";
$result_commandes = mysqli_query($connexion, $sql_commandes);
$commandes_par_mois = array_fill(0, 12, 0);

while ($row = mysqli_fetch_assoc($result_commandes)) {
    $mois_index = $row['mois'] - 1;
    $commandes_par_mois[$mois_index] = $row['nombre_commandes'];
}

// Requête pour le montant total par mois
$sql_montant = "SELECT 
                    MONTH(date_commande) as mois, 
                    SUM(total) as montant_total 
                FROM commande 
                GROUP BY MONTH(date_commande) 
                ORDER BY mois";
$result_montant = mysqli_query($connexion, $sql_montant);
$montant_par_mois = array_fill(0, 12, 0);

while ($row = mysqli_fetch_assoc($result_montant)) {
    $mois_index = $row['mois'] - 1;
    $montant_par_mois[$mois_index] = $row['montant_total'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - Brazil Burger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            display: flex;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
            position: sticky;
            top: 0;
            height: 100vh;
        }
        .main-content {
            flex: 1;
            padding: 30px;
        }
        .stat-btn {
            width: 100%;
            margin-bottom: 12px;
            text-align: left;
            padding: 12px 15px;
            border-radius: 6px;
            transition: all 0.3s ease;
            border: none;
        }
        .stat-btn i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        .stat-btn.active {
            background-color: #ffc107 !important;
            color: #000 !important;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .stat-btn:not(.active) {
            background-color: transparent;
            color: #adb5bd !important;
        }
        .stat-btn:not(.active):hover {
            background-color: #495057 !important;
            color: white !important;
        }
        .chart-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            border: 1px solid #eee;
        }
        .chart-title {
            color: #343a40;
            margin-bottom: 25px;
            font-weight: bold;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .chart-title i {
            margin-right: 10px;
            font-size: 1.4rem;
        }
        .chart-wrapper {
            height: 400px;
            position: relative;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="mb-4 d-flex align-items-center">
            <i class="bi bi-graph-up me-2"></i> Tableau de bord
        </h4>
        
        <div class="d-flex flex-column">
            <a href="?action=statCommande" class="stat-btn <?= $stat_type == 'commandes' ? 'active' : '' ?>">
                <i class="bi bi-cart-check"></i> Statistiques Commandes
            </a>
            
            <a href="?action=statMontant" class="stat-btn <?= $stat_type == 'montant' ? 'active' : '' ?>">
                <i class="bi bi-currency-euro"></i> Statistiques Ventes
            </a>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        <?php if ($stat_type == 'commandes'): ?>
            <!-- Statistiques des commandes -->
            <div class="chart-container">
                <h3 class="chart-title">
                    <i class="bi bi-cart-check"></i>
                    Nombre de commandes par mois
                </h3>
                <div class="chart-wrapper">
                    <canvas id="commandesChart"></canvas>
                </div>
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctxCommandes = document.getElementById('commandesChart');
                    new Chart(ctxCommandes, {
                        type: 'bar',
                        data: {
                            labels: <?= json_encode($mois_labels) ?>,
                            datasets: [{
                                label: 'Nombre de commandes',
                                data: <?= json_encode($commandes_par_mois) ?>,
                                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 1,
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.parsed.y + ' commande(s)';
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Nombre de commandes',
                                        font: {
                                            weight: 'bold'
                                        }
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        precision: 0
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Mois',
                                        font: {
                                            weight: 'bold'
                                        }
                                    },
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
            
        <?php elseif ($stat_type == 'montant'): ?>
            <!-- Statistiques du montant total -->
            <div class="chart-container">
                <h3 class="chart-title">
                    <i class="bi bi-currency-euro"></i>
                    Montant total des ventes par mois
                </h3>
                <div class="chart-wrapper">
                    <canvas id="montantChart"></canvas>
                </div>
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctxMontant = document.getElementById('montantChart');
                    new Chart(ctxMontant, {
                        type: 'line',
                        data: {
                            labels: <?= json_encode($mois_labels) ?>,
                            datasets: [{
                                label: 'Montant total (Fcfa)',
                                data: <?= json_encode($montant_par_mois) ?>,
                                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                                borderColor: 'rgba(40, 167, 69, 1)',
                                borderWidth: 3,
                                tension: 0.3,
                                fill: true,
                                pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                                pointRadius: 5,
                                pointHoverRadius: 7
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.parsed.y.toLocaleString('fr-FR') + ' Fcfa';
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Montant (Fcfa)',
                                        font: {
                                            weight: 'bold'
                                        }
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return value.toLocaleString('fr-FR');
                                        }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Mois',
                                        font: {
                                            weight: 'bold'
                                        }
                                    },
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($connexion);
?>