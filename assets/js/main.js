(() => {
  /* ────────────────────────────────────────────
   *  Hero パララックス（既存）
   * ─────────────────────────────────────────── */
  const hero = document.querySelector('.hero');
  if (hero) {
    const speed = 0.25; // 0.15〜0.35 で調整
    const updateHeroParallax = () => {
      hero.style.setProperty('--heroY', `${window.scrollY * speed}px`);
    };
    updateHeroParallax();
    window.addEventListener('scroll',  updateHeroParallax, { passive: true });
    window.addEventListener('resize', updateHeroParallax);
  }

  /* ────────────────────────────────────────────
   *  ハンバーガーメニュー
   * ─────────────────────────────────────────── */
  const hamburger = document.querySelector('.hamburger');
  const mobileNav = document.querySelector('.mobile-nav');
  if (!hamburger || !mobileNav) return; // 要素が無ければ終了

  /** メニューの開閉をトグル */
  const toggleMenu = () => {
    const isOpen = hamburger.classList.toggle('is-active');
    mobileNav.classList.toggle('is-open', isOpen);
    hamburger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    document.body.classList.toggle('nav-open', isOpen); // スクロール固定用
  };

  hamburger.addEventListener('click', toggleMenu);

  /** モバイルメニュー内リンクを押したら自動で閉じる */
  mobileNav.addEventListener('click', (e) => {
    if (e.target.closest('a')) {
      hamburger.classList.remove('is-active');
      mobileNav.classList.remove('is-open');
      hamburger.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('nav-open');
    }
  });

  /** 画面を 769px 以上に広げたらリセット */
  window.addEventListener('resize', () => {
    if (window.matchMedia('(min-width: 769px)').matches) {
      hamburger.classList.remove('is-active');
      mobileNav.classList.remove('is-open');
      hamburger.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('nav-open');
    }
  });
})();
