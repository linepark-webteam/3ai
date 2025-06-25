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

  /* ---------- 2. Hero 文字アニメーション ---------- */
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

/* ---------- 3. Service 見出しアニメ ---------- */
(() => {
  const head = document.querySelector("#service .section-head");
  if (!head) return;

  /* タイトル（左→右へスライド＋フェード） */
  gsap.from("#service .section-title", {
    x: -80,
    opacity: 0,
    duration: 0.9,
    ease: "power3.out",
    scrollTrigger: {
      trigger: head,
      start: "top 85%",
      toggleActions: "play none none none",
    },
  });

  /* サブタイトル（下→上フェード／少し遅延） */
  gsap.from("#service .section-subtitle", {
    x: -80,
    opacity: 0,
    duration: 0.7,
    delay: 0.5,
    ease: "power3.out",
    scrollTrigger: {
      trigger: head,
      start: "top 85%",
      toggleActions: "play none none none",
    },
  });
})();

/* ---------- 4. Service カードのスライドアップ ---------- */
(() => {
  const cards = gsap.utils.toArray(".service__item"); // ← NodeList を配列化

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
        ease: "power3.out",
        delay: i * 0.15, // 下からスタガー
        scrollTrigger: {
          trigger: card,
          start: "top 80%", // 80% ビューポートに入ったら
          toggleActions: "play none none none",
        },
      }
    );
  });
})();

/* ---------- 5. Property Highlights アニメ ---------- */
(() => {
  const section = document.querySelector("#property");
  const slider = document.querySelector(".property__slider");
  const cards = gsap.utils.toArray(".property__card");
  if (!section || !slider || !cards.length) return;

  /* 5-1 タイトル（左→右） */
  gsap.from("#property .section-title", {
    x: -80,
    opacity: 0,
    duration: 0.9,
    ease: "power3.out",
    scrollTrigger: {
      trigger: section,
      start: "top 80%",
      toggleActions: "play none none none",
    },
  });

  /* 5-2 スライダー全体（フェードアップ） */
  gsap.to(slider, {
    opacity: 1,
    y: 0,
    duration: 0.8,
    ease: "power3.out",
    scrollTrigger: {
      trigger: slider,
      start: "top 85%",
      toggleActions: "play none none none",
    },
  });

  /* 5-3 各カードをスタガーでフェード＆スケール */
  gsap.to(cards, {
    opacity: 1,
    y: 0,
    scale: 1,
    duration: 0.7,
    ease: "power3.out",
    stagger: 0.12,
    delay: 0.1,
    scrollTrigger: {
      trigger: slider,
      start: "top 85%",
      toggleActions: "play none none none",
    },
  });
})();

/* ---------- 7. Notice セクション ---------- */
(() => {
  const section = document.querySelector("#notice");
  if (!section) return;

  /* 7-1 タイトル：左→右スライド */
  gsap.from("#notice .section-title", {
    x: -80,
    opacity: 0,
    duration: 0.9,
    ease: "power3.out",
    scrollTrigger: {
      trigger: section,
      start: "top 85%",
      toggleActions: "play none none none",
    },
  });

  /* 7-2 CTA ボタン：同じループ効果を再利用 */
  const noticeLink = document.querySelector(".notice__more-link");
  if (noticeLink) {
    ScrollTrigger.create({
      trigger: noticeLink,
      start: "top 90%",
      onEnter: () =>
        gsap.to(noticeLink.querySelector(".notice__more-icon"), {
          keyframes: [
            { opacity: 1, x: 8, duration: 0.35 },
            { opacity: 1, x: 0, duration: 0.35 },
            { opacity: 0, x: -8, duration: 0.35, delay: 0.6 },
          ],
          repeat: -1,
          ease: "power1.inOut",
        }),
      onLeave: () =>
        gsap.killTweensOf(noticeLink.querySelector(".notice__more-icon")),
      onEnterBack(self) {
        self.vars.onEnter();
      },
      onLeaveBack(self) {
        self.vars.onLeave();
      },
    });
  }

  /* 7-3 個別お知らせ：1 枚ずつフェードアップ＋スタガー */
  const items = gsap.utils.toArray(".notice__item");
  gsap.to(items, {
    opacity: 1,
    y: 0,
    duration: 0.7,
    ease: "power3.out",
    stagger: 0.1,
    scrollTrigger: {
      trigger: section,
      start: "top 88%",
      toggleActions: "play none none none",
    },
  });
})();
