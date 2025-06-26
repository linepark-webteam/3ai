/* assets/js/property-single.js
 * クリック・←→ボタンでメイン画像をフェード切替
 * ------------------------------------------------- */
document.addEventListener('DOMContentLoaded', () => {
  const mainImg   = document.getElementById('propertyMainImg');
  const gallery   = document.getElementById('propertyGallery');
  const prevBtn   = document.getElementById('imgPrev');
  const nextBtn   = document.getElementById('imgNext');
  if (!mainImg || !gallery) return;

  /* --- 1. ギャラリー画像リストを取得 --- */
  const thumbs = [...gallery.querySelectorAll('img')];
  const sources = thumbs.map(img => img.dataset.full || img.src);
  let current = sources.indexOf(mainImg.src);
  if (current === -1) current = 0;          // 念のため

  /* 共通：画像切替用関数 */
  const switchImage = index => {
    if (index === current) return;
    current = (index + sources.length) % sources.length;  // 巡回
    mainImg.scrollIntoView({ behavior: 'smooth', block: 'start' });
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

  /* --- 2. サムネイルクリック --- */
  gallery.addEventListener('click', e => {
    const img = e.target.closest('img');
    if (!img) return;
    const idx = thumbs.indexOf(img);
    if (idx !== -1) switchImage(idx);
  });

  /* --- 3. 前後ボタン --- */
  if (prevBtn && nextBtn) {
    prevBtn.addEventListener('click', () => switchImage(current - 1));
    nextBtn.addEventListener('click', () => switchImage(current + 1));
  }

  /* --- 4. キーボード ← / → にも対応（フォーカスは問わない） --- */
  document.addEventListener('keydown', e => {
    if (sources.length < 2) return;
    if (e.key === 'ArrowLeft')  switchImage(current - 1);
    if (e.key === 'ArrowRight') switchImage(current + 1);
  });
});
