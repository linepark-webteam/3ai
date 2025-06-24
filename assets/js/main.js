/* assets/js/main.js
 * ───────────────────────────────────────────
 * 1) ハンバーガーメニュー（全ページ共通）
 * 2) 現在ページのメニューに .is-current 付与
 *    ─ TOP 専用アニメ（Hero / Service など）は
 *      assets/js/top.js に分離済み
 * -------------------------------------------------- */

/* ==================================================
 * 1. ハンバーガーメニュー
 * ================================================== */
document.addEventListener('DOMContentLoaded', () => {
  const hamburger = document.querySelector('#hamburger-btn');
  const mobileNav = document.querySelector('.mobile-nav');
  if (!hamburger || !mobileNav) return;

  const ANIM_MS   = 450;
  const label     = document.getElementById('menu-label');
  const menuToggle = document.querySelector('.menu-toggle');

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
    }, ANIM_MS);
  };

  /* ------- TOGGLE ------- */
  const toggle = () =>
    hamburger.classList.contains('is-active') ? closeMenu() : openMenu();

  /* ① ボタンクリック */
  hamburger.addEventListener('click', (e) => {
    e.stopPropagation();
    toggle();
  });

  /* ② ラベルや余白クリック */
  menuToggle.addEventListener('click', toggle);

  /* ③ キーボード操作 */
  menuToggle.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      toggle();
    }
  });

  /* ④ 769px 以上でリセット */
  window.addEventListener('resize', () => {
    if (window.matchMedia('(min-width: 769px)').matches) {
      hamburger.classList.remove('is-active');
      mobileNav.classList.remove('is-open', 'is-closing');
      hamburger.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('nav-open');
    }
  });
});


/* ==================================================
 * 2. 現在ページに .is-current を付与
 * ================================================== */
(() => {
  const LINKS = document.querySelectorAll(
    '.global-nav__item > a, .mobile-nav__item > a'
  );
  if (!LINKS.length) return;

  const currentPath = location.pathname.replace(/\/$/, ''); // 末尾スラッシュ統一

  LINKS.forEach((link) => {
    const linkPath = link.pathname.replace(/\/$/, '');
    // 完全一致 or 親ディレクトリ一致
    if (currentPath === linkPath || currentPath.startsWith(linkPath + '/')) {
      link.parentElement.classList.add('is-current');
    }
  });
})();
