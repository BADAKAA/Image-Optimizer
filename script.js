const inputFile = document.querySelector("#imgToCompress");
const previewImage = document.querySelector(".preview-img");

inputFile.addEventListener("change", function (e) {
  const inputTarget = e.target;
  const file = inputTarget.files[0];

  if (!file) return;
  const reader = new FileReader();
  reader.addEventListener("load", function (e) {
    const readerTarget = e.target;
    previewImage.src = readerTarget.result;
    document.body.classList.toggle("has-preview",true);
  });
  reader.readAsDataURL(file);
});
