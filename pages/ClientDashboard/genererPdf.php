<?php
// Démarrer la session et inclure la configuration si nécessaire
// require_once "../../config/database.php";

// Vérifier si l'ID de commande est présent
if (!isset($_GET['commande_id'])) {
    die("ID de commande manquant.");
}

$commande_id = intval($_GET['commande_id']);

// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "brazil_burger");

// Récupérer les données de la commande
$sqlCommande = "SELECT c.*, u.nom, u.prenom 
                FROM commande c 
                JOIN `user` u ON c.user_id = u.id 
                WHERE c.id = $commande_id";
$commande = mysqli_fetch_assoc(mysqli_query($connexion, $sqlCommande));

// Récupérer les détails de la commande
$sqlDetails = "SELECT cd.quantite, cd.prix_unitaire, 
                      b.nom_burger, m.nom_menu, comp.nom_complement
               FROM commande_detail cd
               LEFT JOIN burger b ON cd.burger_id = b.id
               LEFT JOIN menu m ON cd.menu_id = m.id
               LEFT JOIN complement comp ON cd.complement_id = comp.id
               WHERE cd.commande_id = $commande_id";
$details = mysqli_query($connexion, $sqlDetails);

// Inclure FPDF
require_once "../../fpdf/fpdf.php";

// Créer un nouveau PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Entête du PDF
$pdf->Image('../../logo.png', 1, 10, 30);  // X réduit à 5 (au lieu de 10) pour déplacer à gauche
$pdf->Cell(0, 10, 'Brazil Burger - Commande #' . $commande_id, 0, 1, 'C');
//$pdf->Image('logo.png', 10, 10, 30);
$pdf->Ln(10);

// Informations client
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Client : ' . $commande['prenom'] . ' ' . $commande['nom'], 0, 1);
$pdf->Cell(0, 10, 'Date : ' . $commande['date_commande'], 0, 1);
$pdf->Cell(0, 10, 'Statut : ' . ucfirst($commande['statut']), 0, 1);
$pdf->Ln(10);

// Détails de la commande
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Details de la commande', 0, 1);
$pdf->SetFont('Arial', '', 12);

// En-tête du tableau
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(80, 10, 'Produit', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Quantite', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Prix Unitaire', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Complement', 1, 1, 'C', true);

// Remplissage du tableau
while ($row = mysqli_fetch_assoc($details)) {
    $produit = !empty($row['nom_burger']) ? $row['nom_burger'] : $row['nom_menu'];
    $pdf->Cell(80, 10, $produit, 1);
    $pdf->Cell(30, 10, $row['quantite'], 1, 0, 'C');
    $pdf->Cell(40, 10, number_format($row['prix_unitaire'], 2) . ' Fcfa', 1, 0, 'R');
    $pdf->Cell(40, 10, $row['nom_complement'] ?? '-', 1, 1);
}

// Total
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Total : ' . number_format($commande['total'], 2) . ' Fcfa', 0, 1, 'R');

// Pied de page
$pdf->SetY(-15);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Merci pour votre commande !', 0, 0, 'C');

// Générer le PDF
$pdf->Output('D', 'commande_' . $commande_id . '.pdf'); // 'D' pour forcer le téléchargement
?>