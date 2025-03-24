<?php

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$id = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE id = $id";
$user = mysqli_fetch_assoc(mysqli_query($connexion, $sql));

if (!empty($_POST)) {
    $nouveau_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    $imagePath = "";

    if ($nouveau_pass === $confirm_pass) {
        // Gestion de l'upload de l'image
        if (!empty($_FILES['profile_picture']['name'])) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $imageName = time() . '_' . basename($_FILES['profile_picture']['name']);
            $targetFile = $targetDir . $imageName;
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (in_array($fileExtension, $allowedExtensions)) {
                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
                } else {
                    die("Erreur lors de l'upload de l'image.");
                }
            } else {
                die("Extension non autorisée. Utilisez JPG, JPEG, PNG ou GIF.");
            }
        } else {
            $imagePath = $user['image'] ?? "uploads/default.png";
        }

        $sql = "UPDATE user SET password = '$nouveau_pass', image = '$imagePath', status = 1 WHERE id = $id";
        if (mysqli_query($connexion, $sql)) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'sandbox.smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Username = '0e499fb77ceda9';
                $mail->Password = 'c96e52fb523b41';
                $mail->Port = 2525;
                $mail->setFrom('no-reply@example.com', 'Brazil Burger');
                $mail->addAddress('yayefatougueye2004@gmail.com');
                $mail->isHTML(true);
                $mail->Subject = 'Votre mot de passe a ete change';
                $mail->Body = "<h3>Bonjour {$_SESSION['user']} </h3><p>Votre mot de passe a ete change avec succes.</p>";
                $mail->send();
            } catch (Exception $e) {
                echo "<div class='alert alert-warning'>Le mot de passe a été changé, mais l'email de confirmation n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}</div>";
            }
            $_SESSION['image'] = $imagePath;
            header("Location: index.php?action=listMenu");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de la mise à jour du mot de passe.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Les mots de passe ne correspondent pas.</div>";
    }
}
?>

<div class="container iibs-login-container col-md-6">
    <div class="card iibs-login-card">
        <div class="card-header"></div>
        <div class="card-body">
            <form action="#" method="POST" enctype="multipart/form-data">
                <h1>Changer le mot de passe</h1>
                <div class="mb-3">
                    <label class="mt-2">Photo de profil</label>
                    <input type="file" name="profile_picture" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="mt-2">Ancien mot de passe</label>
                    <input type="password" name="old_password" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="mt-2">Nouveau mot de passe</label>
                    <input type="password" name="new_password" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="mt-2">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="confirm_password" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="iibs-login-card btn btn-success">Changer</button>
                </div>
            </form>
        </div>
    </div>
</div>
