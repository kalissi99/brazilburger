<?php
    $sql = "SELECT * FROM role";
    $roles = mysqli_query($connexion, $sql);

    if (!empty($_POST)) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $id_r = $_POST['id_r'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];
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
            $imagePath = "uploads/jibi.png"; // Image par défaut
        }

        // Vérifier avant l'insertion
        if (empty($imagePath)) {
            die("Erreur : Aucun chemin d'image défini.");
        }

        $sql = "INSERT INTO user (nom, prenom, id_r, login, email, password, image) 
                VALUES ('$nom', '$prenom', $id_r, '$login', '$email', '$password', '$imagePath')";
        if (mysqli_query($connexion, $sql)) {
            
            header('location:index.php?action=listUser');
          
        }
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Ajouter un Utilisateur</title>
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
            .form-container input {
                background-color: #444;
                color: #fff;
                border: 1px solid #555;
            }
            .form-container input:focus {
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
                <h2 class="mt-5 text-center" style="color: #ffc107;">Ajouter un Utilisateur</h2>
                <div class="form-container mt-4">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="login" class="form-label">Login</label>
                            <input type="text" name="login" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_r" class="form-label">Rôle</label>
                            <select class="form-control" name="id_r" id="" required>
                                <?php while ($row = mysqli_fetch_assoc($roles)) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['nom_role'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mt-5 text-center">
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
