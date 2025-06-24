/* global Sortable */

// ==== サムネイルプレビュー ====
function initThumbnail() {
  const input   = document.getElementById('property_thumbnail');
  const preview = document.getElementById('thumb_preview');
  if (!input) return;

  input.addEventListener('change', () => {
    preview.innerHTML = '';
    if (input.files[0] && input.files[0].type.startsWith('image/')) {
      const url = URL.createObjectURL(input.files[0]);
      const img = document.createElement('img');
      img.src   = url;
      img.style.cssText = 'width:96px;height:96px;object-fit:cover;border-radius:4px;cursor:pointer;';
      img.title  = 'クリックで削除';
      img.addEventListener('click', () => { input.value = ''; img.remove(); });
      preview.appendChild(img);
    }
    const old = document.getElementById('existing_thumb');
    if (old) old.remove();
    if (!input.files.length) return;
    document.querySelector('form').insertAdjacentHTML('beforeend', '<input type="hidden" name="delete_thumb" value="1">');
  });
}

// ==== ギャラリー (新規 + 既存) ====
function initGallery() {
  const galInput   = document.getElementById('property_images');
  const newList    = document.getElementById('new_images');
  const exList     = document.getElementById('existing_images');
  if (!galInput || !newList) return;

  const max = parseInt(galInput.dataset.max, 10) || 10;
  let galFiles = [];

  // 追加選択
  galInput.addEventListener('change', () => {
    const selects = Array.from(galInput.files);
    if (galFiles.length + selects.length > max) {
      alert(`最大 ${max} 枚まで選択できます。選択し直してください。`);
      galInput.value = '';
      return;
    }
    selects.forEach(f => {
      if (f.type.startsWith('image/')) galFiles.push(f);
    });
    galInput.value = '';
    renderNewList();
    syncInputFiles();
  });

  // プレビュー生成
  function renderNewList() {
    newList.innerHTML = '';
    galFiles.forEach((file, idx) => {
      const url  = URL.createObjectURL(file);
      const li   = document.createElement('li');
      li.className = 'sortable-item';
      li.dataset.idx = String(idx);
      li.style.position = 'relative';

      const img  = document.createElement('img');
      img.src = url;
      img.style.cssText = 'width:96px;height:96px;object-fit:cover;border-radius:4px;cursor:pointer;';
      img.title = 'クリックで削除';
      img.addEventListener('click', () => {
        galFiles.splice(idx, 1);
        renderNewList();
        syncInputFiles();
      });

      li.appendChild(img);
      newList.appendChild(li);
    });
  }

  // DataTransfer で input.files を作り直す
  function syncInputFiles() {
    const dt = new DataTransfer();
    galFiles.forEach(f => dt.items.add(f));
    galInput.files = dt.files;
  }

  // 既存画像の削除ボタン
  document.querySelectorAll('#existing_images .del-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const li = btn.parentElement;
      const id = li.dataset.id;
      document.querySelector('form').insertAdjacentHTML('beforeend', `<input type="hidden" name="delete_ids[]" value="${id}">`);
      li.remove();
      refreshOrderIds();
    });
  });

  // Sortable 共通オプション
  const sortOpts = {
    group: 'gallery',
    animation: 150,
    onEnd: () => {
      refreshOrderIds();
      syncAfterDrag();
    }
  };

  if (exList) new Sortable(exList, sortOpts);
  new Sortable(newList, sortOpts);

  // 並び順を hidden に書き出し
  function refreshOrderIds() {
    const form = document.querySelector('form');
    form.querySelectorAll('input[name="order_ids[]"]').forEach(e => e.remove());

    const allLis = [...document.querySelectorAll('#existing_images li, #new_images li')];
    allLis.forEach(li => {
      if (li.dataset.id) {
        form.insertAdjacentHTML('beforeend', `<input type="hidden" name="order_ids[]" value="${li.dataset.id}">`);
      }
    });
  }

  // galFiles をドラッグ結果と同期
  function syncAfterDrag() {
    const order = [...newList.querySelectorAll('li')].map(li => parseInt(li.dataset.idx, 10));
    galFiles = order.map(i => galFiles[i]);
    // dataset.idx を再採番
    [...newList.children].forEach((li, i) => { li.dataset.idx = String(i); });
    syncInputFiles();
  }
}

// ==== 初期化 ====
document.addEventListener('DOMContentLoaded', () => {
  initThumbnail();
  initGallery();
});