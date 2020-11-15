<?php
const AVAILABLE_IMAGE_TYPES = [
    'image/jpeg',
    'image/png',
    'image/gif',
];
const MAX_IMAGE_SIZE = 10 * 1024 * 1024;
const IMAGE_DIR1 = 'images';
const IMAGE_DIR = IMAGE_DIR1 . DIRECTORY_SEPARATOR . 'gallery' . DIRECTORY_SEPARATOR;
if (!file_exists(IMAGE_DIR)) {
    mkdir(IMAGE_DIR1);
    mkdir(IMAGE_DIR);
}
$message = "";
$image = $_FILES['image'];

if ($image['error'] != 0) {
    $message = "An error happened with file " . $image['name'];
} else if (!in_array($image['type'], AVAILABLE_IMAGE_TYPES)) {
    $message = "unavailable file " . $image['name'] . " type";
} else if ($image['size'] >= MAX_IMAGE_SIZE) {
    $message = "file " . $image['name'] . " is too large";
} else {
    $extension = pathinfo($image['name'])['extension'];
    $fileName = pathinfo($image['name'])['filename'] . uniqid() . '.' . $extension;
    $filePath = IMAGE_DIR . $fileName;

    if (move_uploaded_file($image['tmp_name'], $filePath)) {
        $watermark = imagecreatefrompng('watermark.png');
        $destination = 'destination';

        $marginLeft = 20;
        $marginBottom = 20;

        $sx = imagesx($watermark);
        $sy = imagesy($watermark);

        $img = imagecreatefromjpeg($filePath);
        imagecopy($img, $watermark, $marginLeft, imagesy($img) - $sy - $marginBottom, 0, 0, $sx, $sy);
        unlink($filePath);
        $i = imagejpeg($img, $filePath, 100);
        imagedestroy($img);

        $message = "file " . $image['name'] . " has been uploaded";
    } else {
        $message = "Couldn't move file " . $image['name'] . " to the directory";
    }
}
$images = scandir(IMAGE_DIR);
$images = array_values(array_filter($images, function ($file) {
    if (strstr($file, ".") === ".jpg" || strstr($file, ".") === ".png" || strstr($file, ".") === ".gif") {
        return $file;
    }
}));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Merriweather&family=Roboto+Mono:ital@1&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="js/main.js"></script>
</head>
<body>
<header>
    <h1>Gallery</h1>
</header>
<main>
    <form method="post" enctype="multipart/form-data" name="image">
        <div class="example-2">
            <div class="form-group">
                <input type="file" id="file" name="image" class="input-file" accept="image/*">
                <label for="file" class="btn btn-tertiary js-labelFile">
                    <i class="icon fa fa-check"></i>
                    <span class="js-fileName">Upload file</span>
                </label>
            </div>
        </div>
        <input type="submit" value="Upload">
    </form>
    <p class="max-size">Max image size: <?= MAX_IMAGE_SIZE / 1024 / 1024 ?> MB</p>
    <div class="container">
        <?php foreach ($images as $key => $file) : ?>
            <div class="image-container" value="<?= $key ?>">
                <div class="image">
                    <i class="fas fa-arrow-left invisible"></i>
                    <i class="fas fa-times invisible"></i>
                    <img src="<?= IMAGE_DIR . $file ?>" alt="<?= $file ?>">
                    <i class="fas fa-arrow-right invisible"></i>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <form method="post" enctype="multipart/form-data" name="image">
        <div class="example-2">
            <div class="form-group">
                <input type="file" id="file" name="image" class="input-file" accept="image/*">
                <label for="file" class="btn btn-tertiary js-labelFile">
                    <i class="icon fa fa-check"></i>
                    <span class="js-fileName">Upload file</span>
                </label>
            </div>
        </div>
    </form>
    <p class="max-size">Max image size: <?= MAX_IMAGE_SIZE / 1024 / 1024 ?> MB</p>
</main>
<footer>
    <p>&copy; junstudio 2020</p>
</footer>
<script>
    window.onload = function () {
        if ("<?= $message ?>" && "<?= $image['name'] ?>") {
            alert("<?= $message ?>");
        }
    }
</script>
</body>
</html>