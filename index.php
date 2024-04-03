<?php 
  require_once './config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compress Images</title>
  <link rel="stylesheet" href="style.css">
  <script defer src="script.js"></script>
  <link rel="shortcut icon" href="./assets/img/picture.png" type="image/x-icon">
  <!-- https://codepen.io/luizomf/pen/YzaKqEB -->
</head>
<body>
  <h1>Image Optimizer</h1>
  <form action="./compress" method="POST" enctype="multipart/form-data">
    <label for="imgToCompress" class="preview-label">
      <img src="" alt="Preview" aria-hidden="true" class="preview-img">
    </label>
    <label class="picture" for="imgToCompress">
      <img class="icon" src="./assets/img/picture.png" alt="" aria-hidden="true">
      <p>Drop images here or <em>browse</em></p>
    </label>
    <input type="file" name="imgToCompress" id="imgToCompress">
    <input type="hidden" name="referrer" value="<?= $_SERVER['REQUEST_URI'] ?>">
    <div class="user-inputs">
      <div class="dimensions">
        <div>
          <span class="description">Max Width</span>
          <input type="number" value="<?= DEFAULT_MAX_WIDTH; ?>" name="max-width">
        </div>
        <div>
          <span class="description">Max Height</span>
          <input type="number" value="<?= DEFAULT_MAX_HEIGHT; ?>" name="max-height">
        </div>
        <div>
          <span class="description">Format</span>
          <select name="format" id="">
            <?php foreach (OUTPUT_FORMATS as $format) {?>
              <option value="<?= $format ?>" <?= ($format===DEFAULT_FORMAT) ? 'selected':''?>><?= $format?></option>
            <?php } ?>

          </select>
        </div>
      </div>
      <button type="submit">Compress</button>
    </div>
  </form>
  <footer>
    <a  href="https://www.flaticon.com/free-icons/picture" title="picture icons">Picture icons created by Freepik - Flaticon</a>
    <a href="https://agbere.com/impressum">Imprint</a>
  </footer>
</body>
</html>