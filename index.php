<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compress Images</title>
  <link rel="stylesheet" href="style.css">
  <script defer src="script.js"></script>
  <!-- https://codepen.io/luizomf/pen/YzaKqEB -->
</head>
<body>
  <h1>Image Optimizer</h1>
  <form action="./compress" method="POST" enctype="multipart/form-data">
    <img src="" alt="Preview" aria-hidden="true" class="preview-img">
    <label class="picture" for="imgToCompress">
      <img class="icon" src="./assets/img/picture.png" alt="" aria-hidden="true">
      <p>Drop images here or <em>browse</em></p>
    </label>
    <input type="file" name="imgToCompress" id="imgToCompress">
    <input type="hidden" name="referrer" value="<?= $_SERVER['REQUEST_URI'] ?>">
    <button type="submit">Compress</button>
  </form>
  <footer>
    <a  href="https://www.flaticon.com/free-icons/picture" title="picture icons">Picture icons created by Freepik - Flaticon</a>
    <a href="https://agbere.com/impressum">Imprint</a>
  </footer>
</body>
</html>