<?php

use App\Services\ImageService;

require_once './Services/ImageService.php';

const ALLOWED_FORMATS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

const MAX_FILE_SIZE_MB = 1000;
const KEEP_ORIGINAL = false;

$message = '';

function validateUpload(): array {

  if (!isset($_FILES["imgToCompress"]) || !$_FILES["imgToCompress"]['name']) {
    header("Location: " . $_POST['referrer'] ?? '/');
    exit();
  }

  $FILE = $_FILES["imgToCompress"];

  $tmpPath = $FILE["tmp_name"];
  $originalName = basename($FILE["name"]);
  $imageFileType = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

  if (!getimagesize($tmpPath)) throw new Exception("File is not an image.", 418);

  // if (file_exists($targetPath)) throw new Exception("Sorry, this file already exists.",409);

  if ($FILE["size"] > MAX_FILE_SIZE_MB * 1000000) throw new Exception("Sorry, your file is too large.", 413);

  if (!in_array($imageFileType, ALLOWED_FORMATS)) throw new Exception("Sorry, only the following formats are allowed:" . implode(', ', ALLOWED_FORMATS), 415);

  if (KEEP_ORIGINAL) {
    $target_dir = "uploads/";
    $targetPath = $target_dir . $originalName;
    if (!move_uploaded_file($tmpPath, $targetPath)) throw new Exception("Sorry, there has been an error.", 500);
  }
  return [$tmpPath, $originalName];
}


function downloadFile() {
  try {
    [$uncompressedPath, $displayName] = validateUpload();
    $compressedPath = ImageService::resize_image($uncompressedPath, 800, 800, 'jpg', './compressed/' . time());
    $fileSize = filesize($compressedPath);
    // Output headers.
    header("Cache-Control: private");
    header("Content-Type: application/stream");
    header("Content-Length: " . $fileSize);
    header("Content-Disposition: attachment; filename=" . $displayName);

    readfile($compressedPath);
    unlink($compressedPath);
    exit();
  } catch (Exception $e) {
    global $message;
    $message = $e->getMessage();
  }
}
downloadFile();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1><?= $message ?></h1>
</body>

</html>