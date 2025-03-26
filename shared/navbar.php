<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Pointage IIBS</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        .navbar {
            background-color: #000;
            border-bottom: 2px solid #ffc107;
        }
        .navbar-brand, .nav-link, .btn {
            color: #ffc107 !important;
            font-weight: bold;
        }
        .nav-link:hover, .btn:hover {
            color: #e0a800 !important;
        }
        .btn-custom {
            background-color:rgb(213, 36, 36);
            color: #000;
            font-weight: bold;
            border: none;
        }
        .btn-custom:hover {
            background-color:rgb(13, 128, 59);
        }
        .profile-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffc107;
        }
        .dropdown-toggle::after {
            display: none;
        }
        .nav-item {
            margin-right: 10px;
        }
        .nav-link i {
            margin-right: 8px;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid my-3">
                <img class="rounded-circle border" width="50" height="50" src="logo.png" alt="Brasil Burger Logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="?action=listUser" <?= $_SESSION['role'] == 'gestionnaire de commande' || $_SESSION['role'] == 'gestionnaire de produit' ? 'hidden' : ''; ?>>
                                <i class="bi bi-people-fill"></i>Liste des users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=listRole" <?= $_SESSION['role'] == 'gestionnaire de commande' || $_SESSION['role'] == 'gestionnaire de produit' ? 'hidden' : ''; ?>>
                                <i class="bi bi-person-badge"></i>Liste des rôles
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="produitDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-collection"></i>Commande et produit
                            </a>
                            <ul class="dropdown-menu bg-dark" aria-labelledby="produitDropdown">
                                <li><a class="dropdown-item text-warning" href="?action=listMenu"><i class="bi bi-menu-button-wide"></i> Menus</a></li>
                                <li><a class="dropdown-item text-warning" href="?action=listBurger"><i class="bi bi-egg-fried"></i> Burgers</a></li>
                                <li><a class="dropdown-item text-warning" href="?action=listCommande"><i class="bi bi-cart-check"></i> Commandes</a></li>
                                <li><a class="dropdown-item text-warning" href="?action=listClient"><i class="bi bi-person-lines-fill"></i> Clients</a></li>
                                <li><a class="dropdown-item text-warning" href="?action=listComplement"><i class="bi bi-cup-straw"></i> Compléments</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=Statistique">
                                <i class="bi bi-graph-up"></i>Statistiques
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <img src="<?= ($_SESSION['image']) ?>" class="profile-pic me-2" alt="Photo de profil">
                        <button class="btn btn-custom rounded-circle">
                            <i class="bi bi-person-circle"></i> <?= $_SESSION['user'] ?>
                        </button>
                        <a type="button" class="btn btn-danger ms-2" href="?action=seDeconnecter">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <main></main>
    <footer></footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>