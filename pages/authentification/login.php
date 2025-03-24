<?php

require_once 'database.php';

 if(isset($_POST['seConnecter'])){
    extract($_POST);
        if (empty($login) || empty($password)) {
            $error="Tous les champs sont obligatoires.";
        }
        
        $sql = "SELECT u.*, r.id,r.nom_role FROM user u ,role r where login='$login' AND password ='$password' 
        AND r.id = u.id_r ";
        $result = mysqli_query($connexion , $sql);
        if(mysqli_num_rows($result)>0){
            $user = mysqli_fetch_assoc($result);
            /*if (password_verify($password,$user['password']){*/

                if($password == $user['password']){
                    $_SESSION['image'] = $user['image'];
                    $_SESSION['role'] = $user['nom_role'];
                    $_SESSION['user'] = $user['login'];
                    $_session['nom']= $user['nom'];
                    $_session['prenom']=$user['prenom'];
                    $_SESSION['user_id'] = $user['id'];
                   if ($user['status'] == 0){
                    
                    header('Location: index.php?action=changingPassword');
                }else{
                   
                    header('Location: index.php?action=listUser');
                    exit();
                }
             
            }
            
          } else {
            $error= "Login ou mot de passe incorrect";
            }
 }
 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brasil Burger Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .card {
            background-color: #000;
            border: 2px solid #ffc107;
            border-radius: 15px;
            padding: 20px;
            width: 400px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 100%;
            max-width: 150px;
            height: auto;
        }
        .welcome {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            margin-top: 20px;
            color: #ffc107;
        }
        .input-group-text {
            background-color: #ffc107;
            color: #000;
            border: none;
        }
        .form-control {
            background-color: #333;
            border: 1px solid #ffc107;
            color: #fff;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #ffc107;
        }
        .btn-custom {
            background-color: #ffc107;
            color: #000;
            border: none;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <div class="card text-center">
        <div class="logo">
            <img src="logo.png" alt="Brasil Burger Logo">
        </div>
        <form action="#" method="POST">
        <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= ($error) ?></div>
                <?php endif; ?>

            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="text" name="login" class="form-control" id="" placeholder="Email ou numéro de téléphone">
                </div>
            </div>
            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe">
                </div>
            </div>
            <button type="submit" name="seConnecter" class="btn btn-custom w-100">Se connecter</button>
        </form>
        <div class="welcome">BIENVENUE !</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
