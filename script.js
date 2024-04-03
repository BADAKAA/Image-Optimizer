const inputFile = document.querySelector("#imgToCompress");
const previewImage = document.querySelector(".preview-img");

function readFile(e) {
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
}


inputFile.addEventListener("change", readFile);

// https://codepen.io/tusharbandal/pen/YWadbB
inputFile.addEventListener('dragover', function(e) {
  e.preventDefault();
  e.stopPropagation();
  document.body.classList.toggle('dragover',true);
});
inputFile.addEventListener('dragleave', function(e) {
  e.preventDefault();
  e.stopPropagation();
  document.body.classList.toggle('dragover',false);
});

inputFile.addEventListener('drop', function(e) {
  document.body.classList.toggle('dragover',false);
});