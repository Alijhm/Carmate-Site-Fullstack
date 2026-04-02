var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function () {
  var slideprint = this.value * 5;
  if (this.value < 100) {
    output.innerHTML = slideprint;
  } else {
    output.innerHTML = "500+";
  }
};

function afficherFormulaire() {
  document.getElementById("cadreFormulaire").style.display = "flex";
}
