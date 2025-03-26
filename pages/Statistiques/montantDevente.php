<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "brazil_burger");
if (!$connexion) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Requête pour récupérer le montant total des ventes par mois
$sql = "SELECT 
            MONTHNAME(date_commande) as mois,
            SUM(total) as montant_total
        FROM commande
        GROUP BY MONTH(date_commande)
        ORDER BY MONTH(date_commande)";

$result = mysqli_query($connexion, $sql);

$labels = [];
$data = [];
$backgroundColors = [
    'rgba(255, 99, 132, 0.7)',
    'rgba(54, 162, 235, 0.7)',
    'rgba(255, 206, 86, 0.7)',
    'rgba(75, 192, 192, 0.7)',
    'rgba(153, 102, 255, 0.7)',
    'rgba(255, 159, 64, 0.7)',
    'rgba(199, 199, 199, 0.7)',
    'rgba(83, 102, 255, 0.7)',
    'rgba(40, 159, 64, 0.7)',
    'rgba(210, 99, 132, 0.7)',
    'rgba(120, 162, 235, 0.7)',
    'rgba(255, 205, 86, 0.7)'
];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['mois'];
    $data[] = $row['montant_total'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventes par mois - Brazil Burger</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 80%;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <h2>Répartition des ventes par mois</h2>
        <canvas id="ventesChart"></canvas>
    </div>

    <script>
        const data = {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Montant des ventes (Fcfa)',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: <?php echo json_encode(array_slice($backgroundColors, 0, count($labels))); ?>,
                borderWidth: 1,
                hoverOffset: 15
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw.toLocaleString('fr-FR') + ' Fcfa';
                                return label;
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };

        new Chart(
            document.getElementById('ventesChart'),
            config
        );
    </script>
</body>
</html>

<?php
mysqli_close($connexion);
?>