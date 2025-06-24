/* assets/js/property-single.js
 * クリックでメイン画像をフェード切替 + 最上部へスムーズスクロール
 * ---------------------------------------------------------------- */
document.addEventListener('DOMContentLoaded', () => {
  const mainImg = document.getElementById('propertyMainImg');
  const gallery = document.getElementById('propertyGallery');
  if (!mainImg || !gallery) return;

  gallery.addEventListener('click', (e) => {
    const thumb = e.target.closest('img');
    if (!thumb || !thumb.dataset.full) return;

    const newSrc = thumb.dataset.full;
    if (mainImg.src === newSrc) return;          // 同じ画像なら何もしない

    /* 1. ページをメイン画像の最上部へスムーズスクロール */
    mainImg.scrollIntoView({ behavior: 'smooth', block: 'start' });

    /* 2. フェードアウト → src 差替え → フェードイン */
    mainImg.style.opacity = 0;                   // フェードアウト開始

    mainImg.addEventListener('transitionend', function handler() {
      mainImg.removeEventListener('transitionend', handler);

      /* src を切り替え、読み込み完了後フェードイン */
      mainImg.src = newSrc;
      if (mainImg.complete) {
        requestAnimationFrame(() => { mainImg.style.opacity = 1; });
      } else {
        mainImg.addEventListener('load', () => {
          mainImg.style.opacity = 1;
        }, { once: true });
      }
    });
  });
});
