/* ============================================================
   FORM COMPONENTS JS
   File: public/assets/admin/js/form-components.js

   Dependencies (load before this file):
     - jQuery
     - Select2
     - Bootstrap Datepicker
   ============================================================ */

(function () {
  "use strict";

  /* ── Select2 init ──────────────────────────────────────── */
  function initSelect2() {
    document.querySelectorAll(".fc-select2").forEach(function (el) {
      var $el = $(el);
      var ajaxUrl = el.dataset.ajaxUrl;

      var config = {
        placeholder: el.dataset.placeholder || "Select...",
        allowClear: false,
        width: "resolve",
        dropdownParent: $("body"),
        width: "100%",
      };

      if (ajaxUrl) {
        config.ajax = {
          url: ajaxUrl,
          dataType: "json",
          delay: 300,
          data: function (params) {
            return { search: params.term, page: params.page || 1 };
          },
          processResults: function (data) {
            return {
              results: data.results,
              pagination: { more: data.more },
            };
          },
          cache: true,
        };
      }

      $el.select2(config);
    });
  }

  /* ── Bootstrap Datepicker init ─────────────────────────── */
  function initDatepicker() {
    $(".fc-datepicker").each(function () {
      // var $wrap = $(this).closest(".input-group.date");
      // if (!$wrap.length) $wrap = $(this).parent();

      $(this)
        .datepicker({
          format: {
            toDisplay: function (date, format, language) {
              let d = new Date(date);
              let day = ("0" + d.getDate()).slice(-2);
              let month = ("0" + (d.getMonth() + 1)).slice(-2);
              let year = d.getFullYear();
              return day + "/" + month + "/" + year; // UI
            },
            toValue: function (date, format, language) {
              let parts = date.split("/");
              return new Date(parts[2], parts[1] - 1, parts[0]); // convert back
            },
          },
          autoclose: true,
          todayHighlight: true,
          startDate: $(this).data("dateStartDate") || null,
          endDate: $(this).data("dateEndDate") || null,
          orientation: "bottom auto",
          container: "body",
          templates: {
            leftArrow: '<i class="fa fa-chevron-left"></i>',
            rightArrow: '<i class="fa fa-chevron-right"></i>',
          },
        })
        .on("changeDate", function (e) {
          let d = e.date;

          let day = ("0" + d.getDate()).slice(-2);
          let month = ("0" + (d.getMonth() + 1)).slice(-2);
          let year = d.getFullYear();

          let formatted = `${year}-${month}-${day}`;
          let name = $(this).attr("data-field-name");
          $("#" + name).val(formatted); // ✅ this goes to backend
          console.log($("#" + name).val(), name);
        });
      $("#datepicker").datepicker("setDate", "now");
    });
  }

  /* ── File preview ──────────────────────────────────────── */
  function initFilePreview() {
    document.addEventListener("change", function (e) {
      var input = e.target;
      if (!input.classList.contains("fc-file-input")) return;

      var previewId = input.dataset.preview;
      var isMulti = input.dataset.multiple === "true";
      var wrap = document.getElementById(previewId);
      if (!wrap) return;

      wrap.innerHTML = "";
      var files = Array.from(input.files);
      if (!isMulti) files = files.slice(0, 1);

      files.forEach(function (file) {
        if (!file.type.startsWith("image/")) return;
        var reader = new FileReader();
        reader.onload = function (ev) {
          var img = document.createElement("img");
          img.src = ev.target.result;
          img.title = file.name;
          wrap.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
    });
  }

  /* ── Init all on DOM ready ─────────────────────────────── */
  document.addEventListener("DOMContentLoaded", function () {
    if (typeof $ === "undefined") {
      console.warn("form-components.js: jQuery not found.");
      return;
    }

    if ($.fn.select2) initSelect2();
    if ($.fn.datepicker) initDatepicker();
    initFilePreview();
  });

  // Toggle switch component js
  document
    .querySelectorAll('.fc-toggle-switch input[type="checkbox"]')
    .forEach(function (cb) {
      cb.addEventListener("change", function () {
        const label =
          this.closest(".fc-toggle-wrap").querySelector(".fc-toggle-label");
        if (label) label.textContent = this.checked ? "Enabled" : "Disabled";
      });
    });
})();
