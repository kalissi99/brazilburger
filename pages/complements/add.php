<?php

if (!empty($_POST)) {
    $nom_complement = $_POST['nom_complement'];
    $prix = $_POST['prix'];
    $imagePath = "";

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";

        // Créer le dossier s'il n'existe pas
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Générer un nom de fichier unique
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;

        // Vérifier l'extension du fichier
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtensions)) {
            // Déplacer l'image et stocker le chemin
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = $targetFile; // ✅ Chemin correct
            } else {
                die("Erreur lors de l'upload de l'image.");
            }
        } else {
            die("Extension non autorisée. Utilisez JPG, JPEG, PNG ou GIF.");
        }
    } else {
        $imagePath = "uploads/default.png"; // Image par défaut
    }

    // Vérifier avant l'insertion
    if (empty($imagePath)) {
        die("Erreur : Aucun chemin d'image défini.");
    }

    // Insérer les données dans la base
    $sql = "INSERT INTO complement (nom_complement, prix, image) 
            VALUES ('$nom_complement', '$prix', '$imagePath')";

    if (mysqli_query($connexion, $sql)) {
        header('location:index.php?action=listComplement');
        exit;
    } else {
        die("Erreur MySQL : " . mysqli_error($connexion));
    }
}

?>

<div class="container">
    <div class="card form-card">
        <div class="card-body">
            <h3 class="card-title text-center">Ajouter un Complément</h3>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Nom du complément</label>
                    <input type="text" name="nom_complement" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Prix</label>
                    <input type="text" name="prix" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-success">Valider</button>
                    <button type="reset" class="btn btn-danger">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #000;
        color: #fff;
    }
    .form-card {
        background-color: #222;
        color: #ffc107;
        border: 2px solid #ffc107;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(255, 193, 7, 0.5);
        padding: 20px;
        width: 50%;
        margin: 50px auto;
    }
    .form-group label {
        font-weight: bold;
        color: #ffc107;
    }
    .form-control {
        background-color: #333;
        color: #fff;
        border: 1px solid #ffc107;
    }
    .form-control:focus {
        background-color: #444;
        color: #fff;
        border: 1px solid #ffc107;
        box-shadow: none;
    }
    .btn-success {
        background-color: #28a745;
        border: none;
    }
    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
</style>
