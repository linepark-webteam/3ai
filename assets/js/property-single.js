/*==================================================
  assets/js/property-single.js
  -----------------------------------------------
  ・クリック / ←→ ボタン / キーボード
  ・サムネイルクリック・横ドラッグ / スワイプ
  ・メイン画像横ドラッグ / スワイプ
  ですべて画像を切替え、ギャラリーを同期
==================================================*/

document.addEventListener('DOMContentLoaded', () => {
  /* ---------- 要素取得 ---------- */
  const mainImg = document.getElementById('propertyMainImg');
  const gallery = document.getElementById('propertyGallery');
  const prevBtn = document.getElementById('imgPrev');
  const nextBtn = document.getElementById('imgNext');
  if (!mainImg || !gallery) return;

  /* ---------- 初期データ ---------- */
  const thumbs  = [...gallery.querySelectorAll('img')];
  const sources = thumbs.map(img => img.dataset.full || img.src);
  let current   = sources.indexOf(mainImg.src);
  if (current === -1) current = 0;
  thumbs.forEach(img => img.setAttribute('draggable', 'false'));

  /* ---------- ヘルパー ---------- */
  const scrollThumbIntoView = idx => {
    thumbs[idx]?.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
  };
  const setActiveThumb = idx => {
    thumbs.forEach(t => t.classList.remove('is-active'));
    thumbs[idx]?.classList.add('is-active');
    scrollThumbIntoView(idx);
  };
  setActiveThumb(current);

  const switchImage = idx => {
    if (idx === current) return;
    current = (idx + sources.length) % sources.length;
    setActiveThumb(current);

    mainImg.style.opacity = 0;
    mainImg.addEventListener('transitionend', function handler () {
      mainImg.removeEventListener('transitionend', handler);
      mainImg.src = sources[current];
      if (mainImg.complete) {
        requestAnimationFrame(() => { mainImg.style.opacity = 1; });
      } else {
        mainImg.addEventListener('load', () => { mainImg.style.opacity = 1; }, { once: true });
      }
    });
  };

  /* ---------- 1. サムネイルクリック ---------- */
  gallery.addEventListener('click', e => {
    const img = e.target.closest('img');
    if (!img) return;
    const idx = thumbs.indexOf(img);
    if (idx !== -1) switchImage(idx);
  });

  /* ---------- 2. 前後ボタン ---------- */
  prevBtn?.addEventListener('click', () => switchImage(current - 1));
  nextBtn?.addEventListener('click', () => switchImage(current + 1));

  /* ---------- 3. キーボード ← / → ---------- */
  document.addEventListener('keydown', e => {
    if (sources.length < 2) return;
    if (e.key === 'ArrowLeft')  switchImage(current - 1);
    if (e.key === 'ArrowRight') switchImage(current + 1);
  });

  /* ---------- 4. ギャラリー横ドラッグ（スクロールのみ） ---------- */
  (() => {
    let isDown = false, startX = 0, scrollStart = 0;
    const down = e => {
      isDown = true;
      gallery.classList.add('is-dragging');
      startX = (e.pageX || e.touches[0].pageX);
      scrollStart = gallery.scrollLeft;
    };
    const move = e => {
      if (!isDown) return;
      const x = (e.pageX || e.touches[0].pageX);
      gallery.scrollLeft = scrollStart - (x - startX);
    };
    const up = () => {
      isDown = false;
      gallery.classList.remove('is-dragging');
    };

    gallery.addEventListener('mousedown', down);
    gallery.addEventListener('mousemove', move);
    document.addEventListener('mouseup', up);

    gallery.addEventListener('touchstart', down,  { passive:false }); /* ★ 変更 */
    gallery.addEventListener('touchmove',  move,  { passive:true  });
    gallery.addEventListener('touchend',   up);
  })();

  /* ---------- 5. メイン画像横ドラッグ／スワイプ ---------- */
  (() => {
    let isDown = false, startX = 0;
    const TH = 40;
    const down = e => {
      isDown = true;
      startX = (e.pageX || e.touches[0].pageX);
      e.preventDefault();
    };
    const up = e => {
      if (!isDown) return;
      isDown = false;
      const endX = (e.pageX || (e.changedTouches && e.changedTouches[0].pageX) || startX);
      const diff = endX - startX;
      if (diff >  TH) switchImage(current - 1);
      if (diff < -TH) switchImage(current + 1);
    };

    mainImg.addEventListener('mousedown', down);
    document.addEventListener('mouseup',   up);

    mainImg.addEventListener('touchstart', down, { passive:false }); /* ★ 変更 */
    mainImg.addEventListener('touchend',   up);
  })();
});
