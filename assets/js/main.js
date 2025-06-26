/* assets/js/main.js
 * ───────────────────────────────────────────
 * 1) ハンバーガーメニュー（全ページ共通）
 * 2) 現在ページのメニューに .is-current 付与
 *    ─ TOP 専用アニメ（Hero / Service など）は
 *      assets/js/top.js に分離済み
 * -------------------------------------------------- */

/* ===================================================
 * 1. ハンバーガーメニュー（PC/SP 共通 Drawer）
 *   - SP(〜1023px)   : 全画面ドロワー＋bodyスクロール固定
 *   - PC(1024px〜)   : 右サイドドロワー＋オーバーレイ
 *   ※ overlay 要素  <div id="drawerOverlay" class="drawer-overlay" hidden></div>
 *===================================================*/
document.addEventListener('DOMContentLoaded', () => {
  const hamburger   = document.getElementById('hamburgerBtn');
  const drawerNav   = document.getElementById('drawerNav');
  const overlay     = document.getElementById('drawerOverlay'); // 追加
  const label       = document.getElementById('menuLabel');
  const menuToggle  = document.querySelector('.menu-toggle');
  const MQ_PC       = window.matchMedia('(min-width: 1024px)');
  const ANIM_MS     = 450;

  if (!hamburger || !drawerNav) return;

  /* ---------- OPEN ---------- */
  const openMenu = () => {
    drawerNav.classList.remove('is-closing');
    drawerNav.classList.add('is-open');
    hamburger.classList.add('is-active');
    hamburger.setAttribute('aria-expanded', 'true');
    label.textContent = 'Close';

    if (MQ_PC.matches) {                     // PC：サイドドロワー
      if (overlay) {
        overlay.hidden = false;
        overlay.classList.add('is-active');
      }
    } else {                                 // SP：全画面ドロワー
      document.body.classList.add('nav-open');
    }
  };

  /* ---------- CLOSE ---------- */
  const closeMenu = () => {
    hamburger.classList.remove('is-active');
    drawerNav.classList.add('is-closing');
    label.textContent = 'Menu';
    hamburger.setAttribute('aria-expanded', 'false');

    // アニメーション終了後に完全クローズ
    setTimeout(() => {
      drawerNav.classList.remove('is-open', 'is-closing');

      if (MQ_PC.matches) {
        if (overlay) {
          overlay.classList.remove('is-active');
          overlay.hidden = true;
        }
      } else {
        document.body.classList.remove('nav-open');
      }
    }, ANIM_MS);
  };

  /* ---------- TOGGLE ---------- */
  const toggleMenu = () =>
    hamburger.classList.contains('is-active') ? closeMenu() : openMenu();

  /* ① ボタンまたはラベルクリック */
  menuToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleMenu();
  });

  /* ② キーボード操作（Enter / Space） */
  menuToggle.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      toggleMenu();
    }
  });

  /* ③ オーバーレイ／メニュー外クリックで閉じる（PC時のみ有効） */
  if (overlay) {
    overlay.addEventListener('click', closeMenu);
  }
  drawerNav.addEventListener('click', (e) => {
    if (e.target === drawerNav && !MQ_PC.matches) closeMenu(); // SP時の背景クリック
  });

  /* ④ ESC キーで閉じる */
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && hamburger.classList.contains('is-active')) {
      closeMenu();
    }
  });

  /* ⑤ リサイズ時リセット */
  window.addEventListener('resize', () => {
    // ブレイクポイントを跨いだ場合はメニューを強制的に閉じる
    if (!drawerNav.classList.contains('is-open')) return;
    closeMenu();
  });
});

/* ==================================================
 * 2. 現在ページに .is-current を付与
 *==================================================*/
(() => {
  const LINKS = document.querySelectorAll(
    '.global-nav__item > a, .drawer-nav__item > a'
  );
  if (!LINKS.length) return;

  // 現在のパス（末尾スラッシュを統一）
  const currentPath = location.pathname.replace(/\/$/, '');

  LINKS.forEach((link) => {
    const linkPath = link.pathname.replace(/\/$/, '');
    // ホーム（"/"）は完全一致のみ、それ以外は親階層でもマッチ
    const isCurrent =
      linkPath === ''
        ? currentPath === ''
        : currentPath === linkPath || currentPath.startsWith(linkPath + '/');

    if (isCurrent) link.parentElement.classList.add('is-current');
  });
})();


/* ===================================================
 * Back-to-Top Button
 *===================================================*/
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('backToTop');
  if (!btn) return;

  /* ① スクロール位置に応じて表示／非表示 */
  const toggleVisibility = () => {
    const scrolled = window.scrollY || document.documentElement.scrollTop;
    btn.classList.toggle('is-visible', scrolled > 400); // 400px 以上スクロールしたら表示
  };
  toggleVisibility();            // 1回目の判定
  window.addEventListener('scroll', toggleVisibility, { passive: true });

  /* ② クリックでスムーズに TOP へ */
  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
});
