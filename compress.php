<?php

use ImageService;

require_once './config.php';
require_once './ImageService.php';

$message = '';

function validateUpload(): array {

  if (!isset($_FILES["imgToCompress"]) || !$_FILES["imgToCompress"]['name']) {
    $redirectUrl = $_POST['referrer'] ?? '/';
    header("Location: " . $redirectUrl);
    exit();
  }
  $FILE = $_FILES["imgToCompress"];

  $tmpPath = $FILE["tmp_name"];
  $originalName = basename($FILE["name"]);
  $imageFileType = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

  if (!getimagesize($tmpPath)) throw new Exception("File is not an image.", 418);

  if ($FILE["size"] > MAX_FILE_SIZE_MB * 1000000) throw new Exception("Sorry, your file is too large.", 413);

  if (!in_array($imageFileType, ALLOWED_FORMATS)) throw new Exception("Sorry, only the following formats are allowed:" . implode(', ', ALLOWED_FORMATS), 415);

  if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR);
  $targetPath = UPLOAD_DIR . $originalName;
  if (!move_uploaded_file($tmpPath, $targetPath)) throw new Exception("Sorry, there has been an error.", 500);
  return [$targetPath, $originalName];
}

function getFileDimesions($path) {
  $imgsize = getimagesize($path);
  $width = $imgsize[0];
  $height = $imgsize[1];
  $maxWidth = max(1, $_POST['max-width'] ?? 1);  // prevent division by 0
  $maxHeight = max(1, $_POST['max-height'] ?? 1);

  $heightAdjustment = min(1, $maxHeight / $height);
  $widthAdjustment = min(1, $maxWidth / $width);
  $adjustment = min($widthAdjustment, $heightAdjustment);

  return [$width * $adjustment, $height * $adjustment];
}

function downloadFile() {
  if (!is_dir(OUTPUT_DIR)) mkdir(OUTPUT_DIR);
  try {
    [$uncompressedPath, $displayName] = validateUpload();
    [$width, $height] = getFileDimesions($uncompressedPath);
    $format = $_POST['format'] ?? DEFAULT_FORMAT;
    $compressedPath = ImageService::resize_image($uncompressedPath, $width, $height, $format, OUTPUT_DIR . '/' . time());
    $fileSize = filesize($compressedPath);

    header("Cache-Control: private");
    header("Content-Type: application/stream");
    header("Content-Length: " . $fileSize);
    header("Content-Disposition: attachment; filename=" . ImageService::replace_extension($displayName, $format));

    readfile($compressedPath);
    if (!KEEP_COMPRESSED) unlink($compressedPath);
    if (!KEEP_ORIGINAL) unlink($uncompressedPath);
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