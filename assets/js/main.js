(() => {
  /* ────────────────────────────────────────────
   *  1. Hero パララックス
   * ─────────────────────────────────────────── */
  const hero = document.querySelector(".hero");
  if (hero) {
    const speed = 0.25; // 0.15〜0.35 で調整
    const updateHeroParallax = () =>
      hero.style.setProperty("--heroY", `${window.scrollY * speed}px`);

    updateHeroParallax();
    window.addEventListener("scroll", updateHeroParallax, { passive: true });
    window.addEventListener("resize", updateHeroParallax);
  }

  /* ─────────────────────────────────
   *  ハンバーガーメニュー
   * ───────────────────────────────── */
  const hamburger = document.querySelector("#hamburger-btn");
  const mobileNav = document.querySelector(".mobile-nav");
  if (!hamburger || !mobileNav) return;

  const ANIM = 450; // ms  ↔  CSS transition と同値に

  /* ------- OPEN ------- */
  const openMenu = () => {
    hamburger.classList.add("is-active");
    mobileNav.classList.remove("is-closing"); // 念のため
    mobileNav.classList.add("is-open"); // opacity 0→1, translateY 動作
    hamburger.setAttribute("aria-expanded", "true");
    document.body.classList.add("nav-open");
  };

  /* ------- CLOSE ------- */
  const closeMenu = () => {
    hamburger.classList.remove("is-active");
    mobileNav.classList.add("is-closing"); // 逆方向へアニメ
    hamburger.setAttribute("aria-expanded", "false");

    setTimeout(() => {
      // アニメ完了後に完全リセット
      mobileNav.classList.remove("is-open", "is-closing");
      document.body.classList.remove("nav-open");
    }, ANIM);
  };

  /* トグル */
  const toggle = () =>
    hamburger.classList.contains("is-active") ? closeMenu() : openMenu();

  hamburger.addEventListener("click", toggle);

  /* メニュー内リンクで自動クローズ */
  mobileNav.addEventListener("click", (e) => {
    if (e.target.closest("a")) closeMenu();
  });

  /* 769px 以上にリサイズしたら強制閉じ */
  window.addEventListener("resize", () => {
    if (window.matchMedia("(min-width: 769px)").matches) {
      hamburger.classList.remove("is-active");
      mobileNav.classList.remove("is-open", "is-closing");
      hamburger.setAttribute("aria-expanded", "false");
      document.body.classList.remove("nav-open");
    }
  });
})();
