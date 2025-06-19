/* ────────────────────────────────────────────
 *  assets/js/main.js
 * ─────────────────────────────────────────── */

(() => {
  /* ─────────── 1. Hero パララックス ─────────── */
  const hero = document.querySelector('.hero');
  if (hero) {
    const speed = 0.25;
    const updateHeroParallax = () =>
      hero.style.setProperty('--heroY', `${window.scrollY * speed}px`);

    updateHeroParallax();
    window.addEventListener('scroll',  updateHeroParallax, { passive: true });
    window.addEventListener('resize', updateHeroParallax);
  }

  /* ─────────── 2. ハンバーガーメニュー ─────────── */
  const hamburger   = document.querySelector('#hamburger-btn');
  const mobileNav   = document.querySelector('.mobile-nav');
  if (!hamburger || !mobileNav) return;

  const ANIM        = 450;                           // ms
  const label       = document.getElementById('menu-label');
  const menuToggle  = document.querySelector('.menu-toggle');

  /* ------- OPEN ------- */
  const openMenu = () => {
    mobileNav.classList.remove('is-closing');
    hamburger.classList.add('is-active');
    mobileNav.classList.add('is-open');
    label.textContent = 'Close';
    hamburger.setAttribute('aria-expanded', 'true');
    document.body.classList.add('nav-open');
  };

  /* ------- CLOSE ------- */
  const closeMenu = () => {
    hamburger.classList.remove('is-active');
    mobileNav.classList.add('is-closing');
    label.textContent = 'Menu';
    hamburger.setAttribute('aria-expanded', 'false');

    setTimeout(() => {
      mobileNav.classList.remove('is-open', 'is-closing');
      document.body.classList.remove('nav-open');
    }, ANIM);
  };

  /* トグル */
  const toggle = () =>
    hamburger.classList.contains('is-active') ? closeMenu() : openMenu();

  /* --------- イベント登録 --------- */
  // ① ボタン自身：トグル後にバブリング停止（★変更）
  hamburger.addEventListener('click', e => {
    e.stopPropagation();          // ← 追加
    toggle();
  });

  // ② ラベルや余白クリック
  menuToggle.addEventListener('click', toggle);

  // ③ キーボード（Enter / Space）
  menuToggle.addEventListener('keydown', e => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      toggle();
    }
  });

  /* 769px 以上でリセット */
  window.addEventListener('resize', () => {
    if (window.matchMedia('(min-width: 769px)').matches) {
      hamburger.classList.remove('is-active');
      mobileNav.classList.remove('is-open', 'is-closing');
      hamburger.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('nav-open');
    }
  });
})();
