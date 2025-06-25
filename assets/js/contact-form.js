/* ==============================================
 * Contact form helper – length counter & validate
 * ============================================*/
(() => {
  // 1) 残文字数カウンター
  const textareas = document.querySelectorAll("textarea[data-max]");
  textareas.forEach((area) => {
    const max = parseInt(area.dataset.max, 10);
    const counter = document.getElementById(`${area.id}Counter`);

    const update = () => {
      const remain = max - area.value.length;
      if (counter) {
        counter.textContent = `あと ${remain} 文字`;
        counter.classList.toggle("text-danger", remain < 0);
      }
    };
    area.addEventListener("input", update);
    update();
  });

  // 2) 必須 & 文字数チェック
  const form = document.getElementById("contactForm");
  if (!form) return;

  form.addEventListener("submit", (e) => {
    let firstError = null;

    // 必須
    form.querySelectorAll("[required]").forEach((el) => {
      const invalid = el.type === "checkbox" ? !el.checked : !el.value.trim();
      if (invalid) {
        el.classList.add("is-invalid");
        if (!firstError) firstError = el;
      } else {
        el.classList.remove("is-invalid");
      }
    });

    // 文字数オーバー
    const msg = document.getElementById("message");
    if (msg && msg.value.length > parseInt(msg.dataset.max, 10)) {
      msg.classList.add("is-invalid");
      if (!firstError) firstError = msg;
    }

    if (firstError) {
      e.preventDefault();
      firstError.focus({ preventScroll: true });
      window.scrollTo({
        top: firstError.getBoundingClientRect().top + window.scrollY - 80,
        behavior: "smooth",
      });
    }
  });
})();
