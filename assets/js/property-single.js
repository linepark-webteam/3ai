document.addEventListener('DOMContentLoaded', () => {
  const mainImg  = document.getElementById('propertyMainImg');
  const gallery  = document.getElementById('propertyGallery');
  if (!mainImg || !gallery) return;

  gallery.addEventListener('click', e => {
    const img = e.target.closest('img');
    if (!img) return;

    const newSrc   = img.dataset.full;
    const current  = mainImg.src;

    /* スワップ表示 */
    mainImg.src    = newSrc;
    img.dataset.full = current;
    img.src = current;             // サムネイルも切替え効果
  });
});
