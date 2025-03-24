<?php
    $sql="SELECT m.id,m.nom_menu,m.prix,m.image,m.description,b.nom_burger,c.nom_complement
          FROM menu m ,burger b ,complement c
          WHERE b.id=m.id_burger 
          AND c.id =m.id_complement";
          
    $menu = mysqli_query($connexion,$sql);
?>

<div class="container">
    <a class="btn btn-success mt-5" href="?action=addMenu">Nouveau</a>
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
                        <a class="btn btn-primary" href="?action=editMenu&&id=<?= $row['id'] ?>">Modifier</a>
                        <a class="btn btn-danger" href="?action=deleteMenu&&id=<?= $row['id'] ?>">Supprimer</a>
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
    .menu-card {
        background-color: #222;
        color: #ffc107;
        border: 2px solid #ffc107;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(255, 193, 7, 0.5);
        margin-bottom: 20px;
    }
    .menu-card .card-img-top {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .menu-card .card-body {
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
