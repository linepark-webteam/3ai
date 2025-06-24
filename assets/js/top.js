/* assets/js/top.js
 * ───────────────────────────────────────────
 * 1) Hero セクション：背景スライド + Ken Burns
 * 2) 文字アニメーション (タイトル / サブタイトル)
 * 3) Service セクション：カードの Intersection Reveal
 * -------------------------------------------------- */
document.addEventListener("DOMContentLoaded", () => {
  /* ---------- 1. Hero 背景スライド ---------- */
  const bgs = gsap.utils.toArray(".hero__bg");
  if (bgs.length) {
    gsap.set(bgs[0], { opacity: 1 });

    const displayTime = 5;
    const fadeTime = 0.5;
    const scaleFrom = 1.5;
    const scaleTo = 1.25;

    const bgTL = gsap.timeline({ repeat: -1 });

    bgs.forEach((bg) => {
      bgTL
        .fromTo(
          bg,
          { opacity: 0, scale: scaleFrom },
          {
            opacity: 1,
            scale: scaleTo,
            duration: fadeTime,
            ease: "power2.out",
            onStart() {
              bgs.forEach((el) => (el.style.zIndex = 0));
              bg.style.zIndex = 1;
            },
          }
        )
        .to(bg, { scale: scaleTo * 0.98, duration: displayTime, ease: "none" })
        .to(bg, { opacity: 0, duration: fadeTime, ease: "power2.in" }, "+=0");
    });
  }

  /* ---------- 2. 文字アニメーション ---------- */
  const animateChars = (
    selector,
    startDelay = 0.3,
    stagger = 0.05,
    holdTime = 2,
    inDur = 0.8,
    outDur = 0.6
  ) => {
    const el = document.querySelector(selector);
    if (!el) return;

    /* ① 文字分割 (初回のみ) */
    if (!el.dataset.split) {
      const frag = document.createDocumentFragment();
      el.textContent.split("").forEach((ch) => {
        const span = document.createElement("span");
        span.className = "char";
        span.textContent = ch === " " ? "\u00A0" : ch;
        frag.appendChild(span);
      });
      el.innerHTML = "";
      el.appendChild(frag);
      el.dataset.split = "true";
    }
    const chars = el.querySelectorAll(".char");

    /* ② タイムライン */
    const tl = gsap.timeline({
      repeat: -1,
      delay: startDelay,
      defaults: { ease: "power3.out" },
    });

    tl.fromTo(
      chars,
      { y: "100%", opacity: 0 },
      { y: "0%", opacity: 1, duration: inDur, stagger: stagger }
    )
      .to({}, { duration: holdTime })
      .to(chars, {
        y: "-100%",
        opacity: 0,
        duration: outDur,
        stagger: stagger,
      });
  };

  animateChars(".hero__title", 0.2, 0.06, 2);
  animateChars(".hero__subtitle", 0.8, 0.05, 2);
});

/* ---------- 3. Service Reveal ---------- */
(() => {
  const cards = gsap.utils.toArray('.service__item');   // ← NodeList を配列化

  /* ▼ NEW : 1 枚ずつ ScrollTrigger でアニメ */
  cards.forEach((card, i) => {
    gsap.fromTo(
      card,
      { opacity: 0, y: 40, scale: 0.9 },
      {
        opacity: 1,
        y: 0,
        scale: 1,
        duration: 0.7,
        ease: 'power3.out',
        delay: i * 0.15,          // 下からスタガー
        scrollTrigger: {
          trigger: card,
          start: 'top 80%',       // 80% ビューポートに入ったら
          toggleActions: 'play none none none',
        },
      }
    );
  });
})();