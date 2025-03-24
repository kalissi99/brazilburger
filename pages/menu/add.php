<?php
    
    $sql_burger = "SELECT * FROM burger";
    $burgers = mysqli_query($connexion, $sql_burger);
    $sql_complement = "SELECT * FROM complement";
    $complements = mysqli_query($connexion, $sql_complement);

    if (!empty($_POST)) {
        $nom_menu = $_POST['nom_menu'];
        $prix = $_POST['prix'];
        $id_burger = $_POST['id_burger'];
        $id_complement = $_POST['id_complement'];
        $description = $_POST['description'];
        // Définir une variable pour stocker l'image
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
        $sql = "INSERT INTO menu (nom_menu, prix, image, id_burger, id_complement, description) 
                VALUES ('$nom_menu', '$prix', '$imagePath', '$id_burger', '$id_complement', '$description')";

        if (mysqli_query($connexion, $sql)) {
            header('location:index.php?action=listMenu');
            exit;
        } else {
            die("Erreur MySQL : " . mysqli_error($connexion));
        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Créer un Menu</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
        <style>
            .form-container {
                border: 2px solid #ffc107; /* Bordure jaune */
                padding: 30px;
                border-radius: 10px; /* Coins arrondis */
                background-color: #333; /* Fond gris foncé */
                color: #fff;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .form-container label {
                font-weight: bold;
                color: #ffc107;
            }
            .form-container input,
            .form-container select {
                background-color: #444;
                color: #fff;
                border: 1px solid #555;
            }
            .form-container input:focus,
            .form-container select:focus {
                border-color: #ffc107;
            }
        </style>
    </head>
    <body style="background-color: #000; color: #fff;">
        <header>
            <!-- Place navbar here -->
        </header>
        <main>
            <div class="container">
                <h2 class="mt-5 text-center" style="color: #ffc107;">Créer un Nouveau Menu</h2>
                <div class="form-container mt-4">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nom_menu" class="form-label">Nom du menu</label>
                            <input type="text" name="nom_menu" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="prix" class="form-label">Prix</label>
                            <input type="text" name="prix" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_burger" class="form-label">Burger</label>
                            <select class="form-control" name="id_burger" required>
                                <?php while ($row = mysqli_fetch_assoc($burgers)) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['nom_burger'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_complement" class="form-label">Complément</label>
                            <select class="form-control" name="id_complement" required>
                                <?php while ($row = mysqli_fetch_assoc($complements)) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['nom_complement'] ?></option>
                                <?php } ?>
                            </select>

                        </div>
                        <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-success">Valider</button>
                            <button type="reset" class="btn btn-danger">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <footer>
            <!-- Place footer here -->
        </footer>
        <!-- Bootstrap JS Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    </body>
</html>
