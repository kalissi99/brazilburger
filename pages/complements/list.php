<?php
    $sql="SELECT * FROM complement";
    $complements = mysqli_query($connexion,$sql);
?>
<div class="container">
    <a class="btn btn-success mt-5" href="?action=addComplement">Nouveau</a>
    <div class="row mt-5">
        <?php while($row = mysqli_fetch_assoc($complements)){ ?>
            <div class="col-md-4 mb-4">
                <div class="card" style="background-color: #222; color: #ffc107; border: 2px solid #ffc107;">
                    <img src="<?= $row['image'] ?>" class="card-img-top" alt="Image du complément" style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['nom_complement'] ?></h5>
                        <p class="card-text">Prix: <?= $row['prix'] ?>€</p>
                        <a href="?action=editComplement&&id=<?= $row['id'] ?>" class="btn btn-primary">Modifier</a>
                        <a href="?action=deleteComplement&&id=<?= $row['id'] ?>" class="btn btn-danger">Supprimer</a>
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
    .card {
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(255, 193, 7, 0.5);
    }
    .card-img-top {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .btn-danger:hover {
        background-color: #c82333;
    }
</style>
