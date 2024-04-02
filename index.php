<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Optimize Image</title>
  <link rel="stylesheet" href="style.css">
  <script defer src="script.js"></script>
  <!-- https://codepen.io/luizomf/pen/YzaKqEB -->
</head>
<body>
  <form action="./compress" method="POST" enctype="multipart/form-data">
    <label class="picture" for="imgToCompress">
      <span class="picture__image"></span>
    </label>
    <input type="file" name="imgToCompress" id="imgToCompress">
    <input type="hidden" name="referrer" value="<?= $_SERVER['REQUEST_URI'] ?>">

    <button type="submit">COMPRESS</button>
  </form>
</body>
</html>