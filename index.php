<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php
require_once 'database.php';
session_start();
if (isset($_GET['action']) && !empty($_SESSION)) {
    // Si le rôle est "client" et l'action n'est pas autorisée, rediriger vers "pageAccueil"
    if ($_SESSION['role'] == 'client' && !in_array($_GET['action'], ['changingPassword', 'listMenu', 'listCommande', 'listBurger', 'pageAccueil', 'maCommande','commande'])) {
        header('Location: index.php?action=pageAccueil');
        exit;
    }

    // Inclure la barre de navigation uniquement si l'action n'est pas "changingPassword"
    if ($_GET['action'] != "changingPassword") {
        if ($_SESSION['role'] != 'client') {
            require_once './shared/navbar.php';
        } else {
            require_once './shared/navbar2.php';
        }
    }

    if ($_GET['action'] == "pageAccueil") {
        // Si le rôle est "client", charger la page spécifique
        if ($_SESSION['role'] == 'client') {
            require_once './pages/ClientDashboard/acceuil.php';
        }

    }
    if ($_GET['action'] == "process_commande") {
        // Si le rôle est "client", charger la page spécifique
        if ($_SESSION['role'] == 'client') {
            require_once './pages/ClientDashboard/process_commande.php';
        }
        
    }
    if ($_GET['action'] == "maCommande") {
        // Si le rôle est "client", charger la page spécifique
        if ($_SESSION['role'] == 'client') {
         require_once './pages/ClientDashboard/commande.php';
}
        }
        if ($_GET['action'] == "commande") {
            // Si le rôle est "client", charger la page spécifique
            if ($_SESSION['role'] == 'client') {
             require_once './pages/ClientDashboard/commande.php';
    }
            }
    

    /*if ($_GET['action'] == "Commander") {
        // Si le rôle est "client", charger la page spécifique
        if ($_SESSION['role'] == 'client') {
            require_once './pages/ClientDashboard/maCommande.php';
        }
    }*/

    // Gestion des actions
    if ($_GET['action'] == "listCommande") {
        // Si le rôle est "client", charger la page spécifique
        if ($_SESSION['role'] == 'client') {
            require_once './pages/ClientDashboard/listCommande.php';
        } else {
            require_once './pages/commande/list.php';
        }
    }

    if ($_GET['action'] == "listRole") {
        require_once './pages/role/list.php';
    }

    if ($_GET['action'] == "listUser") {
        require_once './pages/users/list.php';
    }

    if ($_GET['action'] == "listMenu") {
        // Si le rôle est "client", charger la page spécifique
        if ($_SESSION['role'] == 'client') {
            require_once './pages/ClientDashboard/listMenu.php';
        } else {
            require_once './pages/menu/list.php';
        }
    }

    if ($_GET['action'] == "listBurger") {
        // Si le rôle est "client", charger la page spécifique
        if ($_SESSION['role'] == 'client') {
            require_once './pages/ClientDashboard/listBurger.php';
        } else {
            require_once './pages/burger/list.php';
        }
    }

    if ($_GET['action'] == "listComplement") {
        require_once './pages/complements/list.php';
    }

    if ($_GET['action'] == "addRole") {
        require_once './pages/role/add.php';
    }

    if ($_GET['action'] == "addMenu") {
        require_once './pages/menu/add.php';
    }

    if ($_GET['action'] == "updateUser") {
        $id = $_GET['id'];
        $sql = "SELECT * FROM user where id=$id";
        $user = mysqli_fetch_assoc(mysqli_query($connexion, $sql));
        $sql = "SELECT * FROM role";
        $roles = mysqli_query($connexion, $sql);
        require_once './pages/users/edit.php';
    }

    if ($_GET['action'] == "addBurger") {
        require_once './pages/burger/add.php';
    }

    if ($_GET['action'] == "addUser") {
        require_once './pages/users/add.php';
    }

    if ($_GET['action'] == "addComplement") {
        require_once './pages/complements/add.php';
    }

    if ($_GET['action'] == "deleteUser") {
        $id = $_GET['id'];
        $sql = "DELETE FROM user where id = $id";
        mysqli_query($connexion, $sql);
        header('location:index.php?action=listUser');
    }

    if ($_GET['action'] == "deleteComplement") {
        $id = $_GET['id'];
        $sql = "DELETE FROM complement where id = $id";
        mysqli_query($connexion, $sql);
        header('location:index.php?action=listComplement');
    }

    if ($_GET['action'] == "deleteBurger") {
        $id = $_GET['id'];
        $sql = "DELETE FROM burger where id = $id";
        mysqli_query($connexion, $sql);
        header('location:index.php?action=listBurger');
    }

    if ($_GET['action'] == "deleteMenu") {
        $id = $_GET['id'];
        $sql = "DELETE FROM menu where id = $id";
        mysqli_query($connexion, $sql);
        header('location:index.php?action=listMenu');
    }

    if ($_GET['action'] == 'seDeconnecter') {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    if ($_GET['action'] == "changingPassword") {
        require_once 'pages/authentification/changingPassword.php';
    }
    


}

 else 
{
    require_once 'pages/authentification/login.php';
}
?>
    <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
</body>

</html>