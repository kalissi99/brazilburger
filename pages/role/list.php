<?php
    $sql="SELECT * FROM role";
    $roles = mysqli_query($connexion,$sql);
?>

<div class="container">
    <a class="btn btn-success mt-5" href="?action=addRole">Nouveau</a>
    <div class="row mt-4">
        <?php while($row = mysqli_fetch_assoc($roles)){ ?>
            <div class="col-md-4">
                <div class="card role-card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['nom_role'] ?></h5>
                        <p class="card-text"><strong>ID :</strong> <?= $row['id'] ?></p>
                        <a class="btn btn-primary" href="?action=editRole&&id=<?= $row['id'] ?>">Modifier</a>
                        <a class="btn btn-danger" href="?action=deleteRole&&id=<?= $row['id'] ?>">Supprimer</a>
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
    .role-card {
        background-color: #222;
        color: #ffc107;
        border: 2px solid #ffc107;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(255, 193, 7, 0.5);
        margin-bottom: 20px;
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
