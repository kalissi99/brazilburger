<?php
    $sql="SELECT u.id,u.nom,u.prenom, r.nom_role, u.login ,u.email ,u.image FROM user u ,role r where r.id=u.id_r";
    $users = mysqli_query($connexion,$sql);
?>
<div class="container">
    <a class="btn btn-success mt-5" href="?action=addUser">Nouveau</a>
    <div class="row mt-4">
        <?php while($row = mysqli_fetch_assoc($users)){ ?>
            <div class="col-md-4">
                <div class="card user-card">
                    <img src="<?= $row['image'] ?>" class="card-img-top" alt="Image de l'utilisateur">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['nom'] . " " . $row['prenom'] ?></h5>
                        <p class="card-text"><strong>Login :</strong> <?= $row['login'] ?></p>
                        <p class="card-text"><strong>Email :</strong> <?= $row['email'] ?></p>
                        <p class="card-text"><strong>Rôle :</strong> <?= $row['nom_role'] ?></p>
                        <a class="btn btn-primary" href="?action=updateUser&&id=<?= $row['id'] ?>">Modifier</a>
                        <a class="btn btn-danger" href="?action=deleteUser&&id=<?= $row['id'] ?>">Supprimer</a>
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
    .user-card {
        background-color: #222;
        color: #ffc107; /* Couleur orange */
        border: 2px solid #ffc107;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(255, 193, 7, 0.5);
        margin-bottom: 20px;
    }
    .user-card .card-img-top {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .user-card .card-body {
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
