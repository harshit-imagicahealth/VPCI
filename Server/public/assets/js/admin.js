document.addEventListener("DOMContentLoaded", () => {
  // login page script
  let valid = true;
  const togglePass = (id, eye) => {
    const inp = document.getElementById(id);
    if (inp.type === "password") {
      inp.type = "text";
      eye.classList.replace("fa-eye", "fa-eye-slash");
    } else {
      inp.type = "password";
      eye.classList.replace("fa-eye-slash", "fa-eye");
    }
  };
  $("#togglePass").click(function () {
    togglePass("loginPass", this);
  });
  const error = (id, msg) => {
    const inp = document.getElementById(id);
    inp.classList.add("is-invalid");
    document.getElementById("error-" + id).innerHTML = msg;
  };
  $("#loginForm").submit(function (e) {
    e.preventDefault();
    let loginEmail = $("#loginEmail").val();
    let loginPass = $("#loginPass").val();
    if (!loginEmail || loginEmail == "") {
      error("loginEmail", "Enter email address");
      valid = false;
    }
    if (!loginPass || loginPass == "") {
      console.log(loginPass, "password");
      $("#error-password").text("Enter password");
      valid = false;
    }
    if (valid) {
      this.submit();
    }
  });

  // main script start
  /* ── Sidebar toggle ── */
  const $menu = $("#userMenu");
  const $dropdown = $("#userDropdown");

  // Toggle dropdown on click anywhere in user menu
  $menu.on("click", function (e) {
    e.stopPropagation();

    $menu.toggleClass("active");
    $dropdown.toggleClass("show");
  });

  // Close when clicking outside
  $(document).on("click", function () {
    $menu.removeClass("active");
    $dropdown.removeClass("show");
  });

  //   /* ── Nav dropdown ── */
  //   $(".dropdownManu").on("click", function (e) {
  //     e.preventDefault();
  //     $(".dropdownManu").removeClass("active");
  //     if (!$(this).hasClass("active")) {
  //       $(this).addClass("active");
  //     } else {
  //       $(this).removeClass("active");
  //     }

  //     const targetId = $(this).data("target");
  //     const $dropdown = $("#" + targetId);
  //     const $arrow = $(this).find(".nav-arrow");

  //     const isOpen = $dropdown.hasClass("open");

  //     // 🔴 Close all dropdowns
  //     $(".nav-dropdown").removeClass("open");
  //     $(".nav-arrow").css("transform", "rotate(0deg)");

  //     // 🟢 Open current
  //     if (!isOpen) {
  //       $dropdown.addClass("open");
  //       $arrow.css("transform", "rotate(180deg)");
  //     }
  //   });
});

function toggleSidebar() {
  const sb = document.getElementById("sidebar");
  const mw = document.getElementById("mainWrapper");
  const isMobile = window.innerWidth <= 768;
  if (isMobile) {
    sb.classList.toggle("mob-open");
  } else {
    sb.classList.toggle("collapsed");
    mw.classList.toggle("expanded");
  }
}

$(document).ready(function () {
  // const loader = $("#pageLoader");
  // loader.removeClass("d-none");
  // setTimeout(() => {
  //     loader.addClass("d-none");
  // }, 1000);
});

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
