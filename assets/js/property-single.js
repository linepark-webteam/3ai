/*==================================================
  assets/js/property-single.js
  -----------------------------------------------
  - レターボックス（propertyMainWrap）横ドラッグ/スワイプ で画像切替
  - レターボックス クリック/タップ でライトボックス表示
  - サムネイルクリック・前後ボタン・キーボード ← → も対応
==================================================*/
document.addEventListener("DOMContentLoaded", () => {
  /* ---------- 要素取得 ---------- */
  const mainWrap = document.getElementById("propertyMainWrap");
  const mainImg = document.getElementById("propertyMainImg");
  const gallery = document.getElementById("propertyGallery");
  const prevBtn = document.getElementById("imgPrev");
  const nextBtn = document.getElementById("imgNext");
  const lb = document.getElementById("imgLightbox");
  const lbImg = document.getElementById("lbImg");
  const lbClose = document.querySelector(".lb-close");
  if (!mainImg || !gallery || !mainWrap) return;

  /* ---------- データ ---------- */
  const thumbs = [...gallery.querySelectorAll("img")];
  const sources = thumbs.map((img) => img.dataset.full || img.src);
  let current = sources.indexOf(mainImg.src);
  if (current === -1) current = 0;

  /* ---------- ヘルパー ---------- */
  const scrollThumbIntoView = (i) =>
    thumbs[i]?.scrollIntoView({
      behavior: "smooth",
      block: "nearest",
      inline: "center",
    });

  const setActiveThumb = (i) => {
    thumbs.forEach((t) => t.classList.remove("is-active"));
    thumbs[i]?.classList.add("is-active");
    scrollThumbIntoView(i);
  };
  setActiveThumb(current);

  const switchImage = (i) => {
    if (i === current) return;
    current = (i + sources.length) % sources.length;
    setActiveThumb(current);

    mainImg.style.opacity = 0;
    mainImg.addEventListener("transitionend", function h() {
      mainImg.removeEventListener("transitionend", h);
      mainImg.src = sources[current];
      if (mainImg.complete) {
        requestAnimationFrame(() => (mainImg.style.opacity = 1));
      } else {
        mainImg.addEventListener("load", () => (mainImg.style.opacity = 1), {
          once: true,
        });
      }
    });
  };

  /* ---------- 1. サムネイルクリック ---------- */
  gallery.addEventListener("click", (e) => {
    const img = e.target.closest("img");
    if (!img) return;
    const idx = thumbs.indexOf(img);
    if (idx !== -1) switchImage(idx);
  });

  /* ---------- 2. 前後ボタン ---------- */
  prevBtn?.addEventListener("click", () => switchImage(current - 1));
  nextBtn?.addEventListener("click", () => switchImage(current + 1));

  /* ---------- 3. キーボード ← / → ---------- */
  document.addEventListener("keydown", (e) => {
    if (sources.length < 2) return;
    if (e.key === "ArrowLeft") switchImage(current - 1);
    if (e.key === "ArrowRight") switchImage(current + 1);
  });

  /* ---------- 4. レターボックス横ドラッグ/スワイプ ---------- */
  const THRESHOLD = 40; // スワイプ判定距離
  let isDown = false;
  let startX = 0;
  let didSwipe = false; // ★ クリックとの二重発火を防ぐフラグ

  const pointerDown = (e) => {
    if (e.target.closest(".property-nav")) return; // 矢印上は除外
    isDown = true;
    startX = e.pageX || e.touches[0].pageX;
    didSwipe = false;
    e.preventDefault();
  };
  const pointerUp = (e) => {
    if (!isDown) return;
    isDown = false;
    const endX =
      e.pageX || (e.changedTouches && e.changedTouches[0].pageX) || startX;
    const diff = endX - startX;
    if (Math.abs(diff) > THRESHOLD) {
      didSwipe = true;
      if (diff > 0) switchImage(current - 1); // 右へ払う → 前
      else switchImage(current + 1); // 左へ払う → 次
    }
  };

  mainWrap.addEventListener("mousedown", pointerDown);
  document.addEventListener("mouseup", pointerUp);
  mainWrap.addEventListener("touchstart", pointerDown, { passive: false });
  mainWrap.addEventListener("touchend", pointerUp);

  /* ---------- 5. ライトボックス ---------- */
  const openLB = () => {
    lbImg.src = sources[current];
    lb.removeAttribute("hidden");
  };
  const closeLB = () => lb.setAttribute("hidden", "");

  // レターボックスクリック（矢印以外）
  mainWrap.addEventListener("click", (e) => {
    if (didSwipe) {
      // 直前にスワイプしていたら無視
      didSwipe = false;
      return;
    }
    if (!e.target.closest(".property-nav")) openLB();
  });

  // ライトボックスを閉じる
  lb.addEventListener("click", (e) => {
    if (e.target === lb) closeLB();
  });
  lbClose?.addEventListener("click", closeLB);
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeLB();
  });
});
