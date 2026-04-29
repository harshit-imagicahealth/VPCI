function showAlert(message, type = "success") {
  let alertBox = $("#floatingAlert");

  alertBox.removeClass("d-none success error").addClass(type).text(message);

  // Show animation
  setTimeout(() => {
    alertBox.addClass("show");
  }, 10);

  // Auto hide after 3 sec
  setTimeout(() => {
    alertBox.removeClass("show");

    setTimeout(() => {
      alertBox.addClass("d-none");
    }, 400);
  }, 3000);
}

$(document).ready(function () {
  const goTopBtn = document.getElementById("goTopBtn");
  if (goTopBtn) {
    goTopBtn.addEventListener("click", function () {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  }
  const navbar = document.getElementById("mainNavbar");

  function handleScroll() {
    if (window.scrollY > 50) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  }

  // ✅ Run on scroll
  window.addEventListener("scroll", handleScroll);

  // ✅ Run on page load (IMPORTANT FIX)
  handleScroll();
});
