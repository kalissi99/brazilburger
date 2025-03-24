<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Pointage IIBS</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    
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
    </style>
</head>
<body>
    <header>
    



        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid my-5">
                <img class="rounded-circle border" width="50" height="50" src="logo.png" alt="Brasil Burger Logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="?action=pageAcceuil">Acceuil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=listCommande" >Ma commande</a>
                        </li>
                       <li class="nav-item">
                            <a class="nav-link" href="?action=listMenu" >Les menus</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=listBurger" >Les burgers</a>
                    </ul>
                    <div class="d-flex align-items-center">
                        <img src="<?= ($_SESSION['image'])  ?>" class="profile-pic me-2" alt="Photo de profil">
                        <button class="btn btn-custom rounded-circle"> <?= $_SESSION['user'] ?> </button>
                        <a type="button" class="btn btn-warning position-relative ms-3" href="?action=viewCart">
           <i class="bi bi-cart"></i> Panier
        <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            0
        </span>
    </a>
                        <a type="button" class="btn btn-danger ms-2" href="?action=seDeconnecter">Déconnexion</a>
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
