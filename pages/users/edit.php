<div class="container">
    <form action="?action=updateUser" method="POST">
        <input type="text"name="id" value="<?=  $user['id']  ?>" hidden>
        <label for="">Nom</label>
        <input type="text" name="nom" class="form-control" value="<?=  $user['nom']  ?>">
        <label for="">Prénom</label>
        <input type="text" name="prenom" class="form-control"  value="<?=  $user['prenom']  ?>">
        <label for="">Login</label>
        <input type="text" name="login" class="form-control"  value="<?=  $user['login']  ?>">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>">
       <label for="">Image</label>
        <input type="file" name="image" class="form-control" accept="image/*" value="<?= $user['image'] ?>" required>
        <label for="Role">Role</label>
        <select class="form-control" name="id_r" id="">
            <?php while($row = mysqli_fetch_assoc($role)){ ?>
                    <option value="<?= $row['id'] ?>"><?= $row['nom_role'] ?></option>
            <?php } ?>
        </select>
        <div class="mt-5">
            <button type="submit" class="btn btn-primary">Modifier</button>
            <button type="reset" class="btn btn-danger">Annuler</button>
        </div>
    </form>
</div>