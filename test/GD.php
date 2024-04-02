<?php
ini_set('memory_limit', -1);

class ImageWithGd {
  // accept image from terminal and save it to a file and also resize using gd
  public function handle(array $request) {

    $data = $this->parse_argv($request);

    $destination = __DIR__ . '/uploads/';

    // get image from test-image folder
    $image = __DIR__ . '/test-image/<image_file_name>';

    $imageName = basename($image);

    // move image to uploads folder
    $uploaded = copy($image, $destination . 'original_' . $imageName);

    if ($uploaded) {
      return print_r($this->compressImage($image, intval($data[0]), $destination, $imageName));
    } else {
      echo 'An error occurred!';
    }

    ini_restore('memory_limit');
  }

  private function parse_argv(array $argv): array {
    $request = [];
    foreach ($argv as $i => $a) {
      if (!$i) continue;
      if (preg_match('/^-*(.+?)=(.+)$/', $a, $matches)) {
        $request[$matches[1]] = $matches[2];
      } else {
        $request[$i] = $a;
      }
    }
    return array_values($request);
  }

  function compressImage($image, $outputQuality, $destination, $imageName) {
    $result = [];

    $imageInfo = getimagesize($image);

    $result['oldSize'] = filesize($image) / 1024 . 'KB';
    $result['mime'] = $imageInfo['mime'];


    if ($imageInfo['mime'] == 'image/gif') {

      $imageLayer = imagecreatefromgif($image);
    } elseif ($imageInfo['mime'] == 'image/jpeg') {

      $imageLayer = imagecreatefromjpeg($image);
    } elseif ($imageInfo['mime'] == 'image/png') {

      $imageLayer = imagecreatefrompng($image);
    }

    $compressedImage = imagejpeg($imageLayer, $destination . 'compress_' . $imageName, $outputQuality);

    if ($compressedImage) {
      $result['newSize'] = filesize($destination . 'compress_' . $imageName) / 1024 . 'KB';

      return $result;
      exit;
    } 
    return 'An error occured!';
    exit;
  }
}

$compress = new ImageWithGd();
$compress->handle($argv);
