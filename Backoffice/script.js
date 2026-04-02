function loadWelcome() {
  if (window.location.href === "https://carmate.site//Backoffice") {
    window.location.replace("https://carmate.site//Backoffice/#pagewelcome");
  } else if (
    window.location.href === "https://carmate.site//Backoffice/#pagewelcome"
  ) {
    showWelcome();
  } else {
    hideWelcome();
  }
}

function showWelcome() {
  document.getElementById("pagewelcome").style.display = "block";
}

function hideWelcome() {
  if (window.location.href !== "https://carmate.site//Backoffice") {
    document.getElementById("pagewelcome").style.display = "none";
  }
}
