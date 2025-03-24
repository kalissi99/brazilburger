<?php
    if (!empty($_POST)) {
        $nom_role = $_POST['nom_role'];
        $sql = "INSERT INTO role (nom_role) values ('$nom_role')";
        mysqli_query($connexion, $sql);
        header('location:index.php?action=listRole');
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Ajouter un Rôle</title>
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
                <h2 class="mt-5 text-center" style="color: #ffc107;">Ajouter un Nouveau Rôle</h2>
                <div class="form-container mt-4">
                    <form action="#" method="POST">
                        <div class="mb-3">
                            <label for="nom_role" class="form-label">Nom du rôle</label>
                            <input type="text" name="nom_role" class="form-control" required>
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
