/* ────────────────────────────────────────────
 *  assets/js/main.js
 * ─────────────────────────────────────────── */

(() => {
/*==================================================
 * 1. Hero – マルチ背景スライド & Ken Burns
 *==================================================*/
document.addEventListener('DOMContentLoaded', () => {
  /* ---------- 背景スライド ---------- */
  const bgs = gsap.utils.toArray('.hero__bg');
  if (bgs.length) {
    gsap.set(bgs[0], { opacity: 1 });   // 初期表示

    const displayTime = 5;   // 秒
    const fadeTime    = 0.5; // 秒
    const scaleFrom   = 1.5;
    const scaleTo     = 1.25;

    const tl = gsap.timeline({ repeat: -1 });

    bgs.forEach(bg => {
      tl.fromTo(
        bg,
        { opacity: 0, scale: scaleFrom },
        {
          opacity: 1,
          scale: scaleTo,
          duration: fadeTime,
          ease: 'power2.out',
          onStart() {
            bgs.forEach(el => (el.style.zIndex = 0));
            bg.style.zIndex = 1;
          },
        },
      )
        .to(bg, {
          scale: scaleTo * 0.98,              // 追加ズーム
          duration: displayTime,
          ease: 'none',
        })
        .to(
          bg,
          {
            opacity: 0,
            duration: fadeTime,
            ease: 'power2.in',
          },
          '+=0',
        );
    });
  }

  /*==================================================
   * 2. 文字アニメーション（1 文字ずつ左→右／下→上）
   *==================================================*/
  const animateChars = (selector, baseDelay = 0.3, stagger = 0.05) => {
    const el = document.querySelector(selector);
    if (!el) return;

    /* ① テキストを span.char に分割 */
    const text = el.textContent;
    el.innerHTML = ''; // 既存テキストをクリア
    text.split('').forEach(ch => {
      const span = document.createElement('span');
      span.classList.add('char');
      span.textContent = ch === ' ' ? '\u00A0' : ch; // スペース保持
      el.appendChild(span);
    });

    /* ② アニメーション */
    gsap.fromTo(
      el.querySelectorAll('.char'),
      { x: '0', y: '100%', opacity: 0 },
      {
        x: '0em',
        y: '0%',
        opacity: 1,
        duration: 0.8,
        ease: 'power3.out',
        stagger: stagger,
        delay: baseDelay,
      },
    );
  };

  animateChars('.hero__title', 0.2, 0.06);     // タイトル：少し早め
  animateChars('.hero__subtitle', 0.8, 0.05);  // サブタイトル：後から


  /*==================================================
   * 2. テキスト – フェード＆スライドイン（1度だけ）
   *==================================================*/
  gsap.timeline()
    .from('.hero__title', {
      yPercent: 30,
      opacity: 0,
      duration: 1.2,
      ease: 'power3.out',
    })
    .from('.hero__subtitle', {
      yPercent: 30,
      opacity: 0,
      duration: 1.0,
      ease: 'power3.out',
    }, '-=0.8');
});


  /* ─────────── 2. ハンバーガーメニュー ─────────── */
  const hamburger = document.querySelector("#hamburger-btn");
  const mobileNav = document.querySelector(".mobile-nav");
  if (!hamburger || !mobileNav) return;

  const ANIM = 450; // ms
  const label = document.getElementById("menu-label");
  const menuToggle = document.querySelector(".menu-toggle");

  /* ------- OPEN ------- */
  const openMenu = () => {
    mobileNav.classList.remove("is-closing");
    hamburger.classList.add("is-active");
    mobileNav.classList.add("is-open");
    label.textContent = "Close";
    hamburger.setAttribute("aria-expanded", "true");
    document.body.classList.add("nav-open");
  };

  /* ------- CLOSE ------- */
  const closeMenu = () => {
    hamburger.classList.remove("is-active");
    mobileNav.classList.add("is-closing");
    label.textContent = "Menu";
    hamburger.setAttribute("aria-expanded", "false");

    setTimeout(() => {
      mobileNav.classList.remove("is-open", "is-closing");
      document.body.classList.remove("nav-open");
    }, ANIM);
  };

  /* トグル */
  const toggle = () =>
    hamburger.classList.contains("is-active") ? closeMenu() : openMenu();

  /* --------- イベント登録 --------- */
  // ① ボタン自身：トグル後にバブリング停止（★変更）
  hamburger.addEventListener("click", (e) => {
    e.stopPropagation(); // ← 追加
    toggle();
  });

  // ② ラベルや余白クリック
  menuToggle.addEventListener("click", toggle);

  // ③ キーボード（Enter / Space）
  menuToggle.addEventListener("keydown", (e) => {
    if (e.key === "Enter" || e.key === " ") {
      e.preventDefault();
      toggle();
    }
  });

  /* 769px 以上でリセット */
  window.addEventListener("resize", () => {
    if (window.matchMedia("(min-width: 769px)").matches) {
      hamburger.classList.remove("is-active");
      mobileNav.classList.remove("is-open", "is-closing");
      hamburger.setAttribute("aria-expanded", "false");
      document.body.classList.remove("nav-open");
    }
  });
})();

/* ─────────────────────────────────────────
 *  3. 現在ページに .is-current を付与
 * ───────────────────────────────────────── */
(() => {
  const LINKS = document.querySelectorAll(
    ".global-nav__item > a, .mobile-nav__item > a"
  );
  if (!LINKS.length) return;

  const currentPath = location.pathname.replace(/\/$/, ""); // 末尾スラッシュ統一

  LINKS.forEach((link) => {
    const linkPath = link.pathname.replace(/\/$/, "");
    // 完全一致 or 末尾一致（親メニューをハイライトしたい場合）
    if (currentPath === linkPath || currentPath.startsWith(linkPath + "/")) {
      link.parentElement.classList.add("is-current");
    }
  });
})();

/*------------TOPページ Service section reveal ------------*/
document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".service__item");
  const io = new IntersectionObserver(
    (entries) =>
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          io.unobserve(entry.target);
        }
      }),
    { threshold: 0.2, rootMargin: "0px 0px -10% 0px" }
  );
  cards.forEach((card) => io.observe(card));
});
