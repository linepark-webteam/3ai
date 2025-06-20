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

/* ─────────────────────────────────────────
 *  3. 現在ページに .is-current を付与
 * ───────────────────────────────────────── */
(() => {
  const LINKS = document.querySelectorAll(
    '.global-nav__item > a, .mobile-nav__item > a'
  );
  if (!LINKS.length) return;

  const currentPath = location.pathname.replace(/\/$/, ''); // 末尾スラッシュ統一

  LINKS.forEach(link => {
    const linkPath = link.pathname.replace(/\/$/, '');
    // 完全一致 or 末尾一致（親メニューをハイライトしたい場合）
    if (currentPath === linkPath || currentPath.startsWith(linkPath + '/')) {
      link.parentElement.classList.add('is-current');
    }
  });
})();


/*------------TOPページ Service section reveal ------------*/
document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.service__item');
  const io = new IntersectionObserver(
    entries => entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        io.unobserve(entry.target);
      }
    }),
    { threshold: 0.2, rootMargin: '0px 0px -10% 0px' }
  );
  cards.forEach(card => io.observe(card));
});
