<?php
    $sql="SELECT * FROM burger";
    $burgers = mysqli_query($connexion,$sql);
?>

<div class="container">
    <a class="btn btn-success mt-5" href="?action=addBurger">Nouveau</a>
    <div class="row mt-4">
        <?php while($row = mysqli_fetch_assoc($burgers)){ ?>
            <div class="col-md-4">
                <div class="card burger-card">
                    <img src="<?= $row['image'] ?>" class="card-img-top" alt="Image du burger">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['nom_burger'] ?></h5>
                        <p class="card-text"><strong>Prix :</strong> <?= $row['prix'] ?> €</p>
                        <a class="btn btn-primary" href="?action=editBurger&&id=<?= $row['id'] ?>">Modifier</a>
                        <a class="btn btn-danger" href="?action=deleteBurger&&id=<?= $row['id'] ?>">Supprimer</a>
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
