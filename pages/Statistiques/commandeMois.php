<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "brazil_burger");
if (!$connexion) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Requête pour compter les commandes par mois
$sql = "SELECT 
            MONTH(date_commande) as mois, 
            COUNT(*) as nombre_commandes 
        FROM commande 
        GROUP BY MONTH(date_commande) 
        ORDER BY mois";

$result = mysqli_query($connexion, $sql);

// Préparation des données pour le graphique
$mois_labels = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
$commandes_par_mois = array_fill(0, 12, 0); // Initialise tous les mois à 0

while ($row = mysqli_fetch_assoc($result)) {
    $mois_index = $row['mois'] - 1; // Convertit le mois (1-12) en index (0-11)
    $commandes_par_mois[$mois_index] = $row['nombre_commandes'];
}
?>

<div style="width: 90%; max-width: 900px; margin: 20px auto;">
  <canvas id="commandesChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Données préparées depuis PHP
  const commandesData = {
    labels: <?php echo json_encode($mois_labels); ?>,
    datasets: [{
      label: 'Nombre de commandes',
      data: <?php echo json_encode($commandes_par_mois); ?>,
      backgroundColor: 'rgba(255, 193, 7, 0.7)',
      borderColor: 'rgba(255, 159, 64, 1)',
      borderWidth: 2,
      borderRadius: 5,
      hoverBackgroundColor: 'rgba(255, 159, 64, 0.9)'
    }]
  };

  const ctx = document.getElementById('commandesChart').getContext('2d');
  
  new Chart(ctx, {
    type: 'bar',
    data: commandesData,
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Statistiques des commandes par mois',
          font: {
            size: 18
          }
        },
        legend: {
          display: false
        },
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
            text: 'Mois de l\'année',
            font: {
              weight: 'bold'
            }
          }
        }
      },
      animation: {
        duration: 1000
      }
    }
  });
</script>