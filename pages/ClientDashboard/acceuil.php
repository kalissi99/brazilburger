<?php
    $sqlBurger="SELECT * FROM burger";
    $burgers = mysqli_query($connexion,$sqlBurger);
    $sqlMenu="SELECT m.id,m.nom_menu,m.prix,m.image,m.description,b.nom_burger,c.nom_complement
    FROM menu m ,burger b ,complement c
    WHERE b.id=m.id_burger 
    AND c.id =m.id_complement";
    
$menu = mysqli_query($connexion,$sqlMenu);
$sqlComplement="SELECT * FROM complement";
$complement = mysqli_query($connexion,$sqlComplement);
?>

<div class="container">
    <div><h1>Nos burgers</h1></div>
    <div class="row mt-4">
        <?php while($row = mysqli_fetch_assoc($burgers)){ ?>
            <div class="col-md-4">
                <div class="card burger-card">
                    <img src="<?= $row['image'] ?>" class="card-img-top" alt="Image du burger">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['nom_burger'] ?></h5>
                       
                        <p class="card-text"><strong>Prix :</strong> <?= $row['prix'] ?> €</p>
                        <p class="card-text"><strong>Description :</strong> <?= $row['description'] ?></p>
                        <a class="btn btn-primary" href="index.php?action=commande&type=burger&id=<?= $row['id'] ?>">
    <i class="bi bi-cart-plus"></i> 
</a>
  </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="container">
    <div><h1>Nos menus</h1></div>
    <div class="row mt-4">
        <?php while($row = mysqli_fetch_assoc($menu)){ ?>
            <div class="col-md-4">
                <div class="card menu-card">
                    <img src="<?= $row['image'] ?>" class="card-img-top" alt="Image du menu">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['nom_menu'] ?></h5>
                        <p class="card-text"><strong>Prix :</strong> <?= $row['prix'] ?> €</p>
                        <p class="card-text"><strong>Burger :</strong> <?= $row['nom_burger'] ?></p>
                        <p class="card-text"><strong>Complément :</strong> <?= $row['nom_complement'] ?></p>
                        <p class="card-text"><strong>Description :</strong> <?= $row['description'] ?></p>
                        <a class="btn btn-primary" href="index.php?action=commande&type=menu&id=<?= $row['id'] ?>">
    <i class="bi bi-cart-plus"></i> 
</a>
 </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<style>
    body {
        background-color: #000;
        color: #fff;
    }
    .burger-card {
        background-color: #222;
        color: #ffc107;
        border: 2px solid #ffc107;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(255, 193, 7, 0.5);
        margin-bottom: 20px;
    }
    .burger-card .card-img-top {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .burger-card .card-body {
        text-align: center;
    }
    .btn-success {
        background-color: #28a745;
        border: none;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
</style>
        