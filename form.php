<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data = array_map('trim',$_POST );
    $data = array_map('htmlentities', $data);
    $uploadDir = 'public/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    $maxFileSize = 1000000;

    $errors = [];
    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png ou webp !';
    }

    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 1M !";
    }
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
        $uploadFile;
    }
}

?>

<body>
    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="name">Nom</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="firtname">Prénom</label>
            <input type="text" id="firstname" name="firstanme">
        </div>
        <div>
            <label for="age">Age</label>
            <input type="number" id="age" name="age">
        </div>
        <label for="imageUpload">Upload an profile image</label>
        <input type="file" name="avatar" id="imageUpload" />
        <button name="send">Send</button>
    </form>

    <ul>
        <?php if (!empty($errors))
            foreach ($errors as $error) : ?>
            <li> <?= $error ?> </li>
        <?php endforeach ?>

    </ul>
    <div>
        <?php if (empty($errors)) : ?>
            <img src="public/uploads/<?= $uploadFile . '.' . $extension ?>" />
            <ul>
                <li><? $data['name'] ?></li>
                <li> <? $data['firstname'] ?></li>
                <li> <? $data['age'] ?></li>

            </ul>
        <?php endif; ?>
    </div>
</body>

</html>