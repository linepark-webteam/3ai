/* ------------------------------------------------------------------
 * property-entry.js  – 1リスト + 番号ラベル + Drag & Drop + メディアライブラリ
 * ------------------------------------------------------------------ */

document.addEventListener("DOMContentLoaded", () => {
  initThumbnail(); // サムネイルプレビュー
  initGalleryUnified(); // ギャラリー管理
  initThumbnailDragDrop(); // サムネイル DnD
  initGalleryDragDrop(); // ギャラリー DnD
});

/* ================================================================
 * サムネイル用 Drag & Drop
 * ================================================================ */
function initThumbnailDragDrop() {
  const dropZone = document.getElementById("thumb_preview");
  const input = document.getElementById("property_thumbnail_input");
  if (!dropZone || !input) return;

  ["dragenter", "dragover"].forEach((ev) =>
    dropZone.addEventListener(ev, (e) => {
      e.preventDefault();
      dropZone.classList.add("is-dragover");
    })
  );
  ["dragleave", "dragend", "drop"].forEach((ev) =>
    dropZone.addEventListener(ev, (e) => {
      e.preventDefault();
      dropZone.classList.remove("is-dragover");
    })
  );

  dropZone.addEventListener("drop", (e) => {
    const file = [...e.dataTransfer.files].find((f) =>
      f.type.startsWith("image/")
    );
    if (!file) return;
    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
    input.dispatchEvent(new Event("change"));
  });
}

/* ================================================================
 * ギャラリー用 Drag & Drop
 * ================================================================ */
function initGalleryDragDrop() {
  const list = document.getElementById("gallery_list");
  const galInput = document.getElementById("property_images_input");
  if (!list || !galInput) return;

  const MAX = parseInt(galInput.dataset.max, 10) || 10;

  ["dragenter", "dragover"].forEach((ev) =>
    list.addEventListener(ev, (e) => {
      e.preventDefault();
      list.classList.add("is-dragover");
    })
  );
  ["dragleave", "dragend", "drop"].forEach((ev) =>
    list.addEventListener(ev, (e) => {
      e.preventDefault();
      list.classList.remove("is-dragover");
    })
  );

  list.addEventListener("drop", (e) => {
    const files = [...e.dataTransfer.files].filter((f) =>
      f.type.startsWith("image/")
    );
    if (!files.length) return;
    if (list.children.length + files.length > MAX) {
      alert(`最大 ${MAX} 枚まで選択できます。`);
      return;
    }
    addFiles(files);
  });
}

/* ================================================================
 * サムネイルプレビュー
 * ================================================================ */
function initThumbnail() {
  const input = document.getElementById("property_thumbnail_input");
  const preview = document.getElementById("thumb_preview");
  if (!input || !preview) return;

  function removeThumb() {
    input.value = "";
    const hid = document.getElementById("property_thumbnail_id");
    if (hid) hid.value = "";
    preview.innerHTML = "";
    document.getElementById("existing_thumb")?.remove();
  }

  input.addEventListener("change", () => {
    preview.innerHTML = "";
    if (input.files[0]?.type.startsWith("image/")) {
      const url = URL.createObjectURL(input.files[0]);
      const img = document.createElement("img");
      img.src = url;
      img.title = "クリックで削除";
      img.style.cursor = "pointer";
      img.onclick = removeThumb;
      preview.appendChild(img);
    }
    document.getElementById("existing_thumb")?.remove();
  });

  document
    .querySelector('label[for="property_thumbnail_input"]')
    ?.addEventListener("click", () => input.click());
}

/* ================================================================
 * ギャラリー管理
 * ================================================================ */
function initGalleryUnified() {
  const form = document.querySelector("form");
  const galInput = document.getElementById("property_images_input");
  const list = document.getElementById("gallery_list");
  if (!form || !galInput || !list) return;

  const MAX = parseInt(galInput.dataset.max, 10) || 10;
  let galFiles = [];

  function addFiles(files) {
    files.forEach((file) => {
      if (!file.type.startsWith("image/")) return;
      const idx = galFiles.push(file) - 1;
      const url = URL.createObjectURL(file);
      const li = document.createElement("li");
      li.className = "sortable-item";
      li.dataset.idx = String(idx);
      li.style.position = "relative";
      li.innerHTML = `
        <span class="img-label"></span>
        <img src="${url}">
        <button type="button" class="del-btn"
          style="position:absolute;top:2px;right:2px;background:#d00;color:#fff;
                 border:none;width:24px;height:24px;border-radius:50%;
                 line-height:22px;cursor:pointer;">×</button>`;
      list.appendChild(li);
    });
    syncInputFiles();
    renumberLabels();
  }

  galInput.addEventListener("change", () => {
    const selects = [...galInput.files];
    if (list.children.length + selects.length > MAX) {
      alert(`最大 ${MAX} 枚まで選択できます。`);
      galInput.value = "";
      return;
    }
    addFiles(selects);
    galInput.value = "";
  });

  form.addEventListener("click", (e) => {
    const btn = e.target.closest(".del-btn");
    if (!btn) return;
    const li = btn.closest("li");
    if (li.dataset.id) {
      form.insertAdjacentHTML(
        "beforeend",
        `<input type="hidden" name="delete_ids[]" value="${li.dataset.id}">`
      );
      li.remove();
      refreshOrderIds();
    } else {
      const idx = Number(li.dataset.idx);
      galFiles.splice(idx, 1);
      li.remove();
      reindexNewLis();
      syncInputFiles();
    }
    renumberLabels();
  });

  new Sortable(list, {
    animation: 150,
    onEnd: () => {
      reorderGalFilesByList();
      syncInputFiles();
      refreshOrderIds();
      renumberLabels();
    },
  });

  function reorderGalFilesByList() {
    const order = [...list.querySelectorAll("li")]
      .filter((li) => li.dataset.idx !== undefined)
      .map((li) => Number(li.dataset.idx));
    galFiles = order.map((i) => galFiles[i]);
    reindexNewLis();
  }
  function reindexNewLis() {
    let i = 0;
    list.querySelectorAll("li").forEach((li) => {
      if (li.dataset.idx !== undefined) li.dataset.idx = String(i++);
    });
  }
  function syncInputFiles() {
    const dt = new DataTransfer();
    galFiles.forEach((f) => dt.items.add(f));
    galInput.files = dt.files;
  }
  function refreshOrderIds() {
    form
      .querySelectorAll('input[name="order_ids[]"]')
      .forEach((el) => el.remove());
    list.querySelectorAll("li[data-id]").forEach((li) => {
      form.insertAdjacentHTML(
        "beforeend",
        `<input type="hidden" name="order_ids[]" value="${li.dataset.id}">`
      );
    });
  }
  function renumberLabels() {
    let num = 1;
    list.querySelectorAll("li").forEach((li) => {
      li.querySelector(".img-label").textContent = `${num++}枚目`;
    });
  }

  renumberLabels();
  refreshOrderIds();

  window.addFiles = addFiles;
}

/* ================================================================
 * メディアライブラリ統合（jQuery）
 * ================================================================ */
jQuery(document).ready(function ($) {
  /* ---------- サムネイル（単一選択） ---------- */
  $("#media_thumb_btn").on("click", function (e) {
    e.preventDefault();
    const frame = wp.media({
      title: "サムネイルを選択",
      button: { text: "選択" },
      multiple: false,
    });
    frame.on("select", function () {
      const att = frame.state().get("selection").first().toJSON();
      const thumbUrl = att.sizes?.thumbnail?.url || att.url;
      $("#thumb_preview").html(
        `<img src="${thumbUrl}" style="width:96px;height:96px;object-fit:cover;border-radius:4px;cursor:pointer;">`
      );
      $("#existing_thumb").remove();
      $("#property_thumbnail_input").val("");
      $("#property_thumbnail_id").val(att.id);
    });
    frame.open();
  });

  /* ---------- ギャラリー：メディアライブラリ選択 ---------- */
  $("#media_gallery_btn").on("click", function (e) {
    e.preventDefault();
    const frame = wp.media({
      title: "ギャラリー画像を選択",
      button: { text: "追加" },
      library: { type: "image" },
      multiple: true,
    });
    frame.on("select", function () {
      const selection = frame.state().get("selection").toJSON();
      const $ul = $("#gallery_list");
      // 既存IDリスト
      const existing = $ul
        .find("li[data-id]")
        .map((_, li) => parseInt(li.dataset.id, 10))
        .get();
      selection.forEach((att) => {
        if (existing.includes(att.id)) return;
        const thumbUrl = att.sizes?.thumbnail?.url || att.url;
        const $li = $(
          `<li class="sortable-item" data-id="${att.id}" style="position:relative;"><span class="img-label"></span><img src="${thumbUrl}"><button type="button" class="del-btn" style="position:absolute;top:2px;right:2px;background:#d00;color:#fff;border:none;width:24px;height:24px;border-radius:50%;line-height:22px;cursor:pointer;">×</button><input type="hidden" name="order_ids[]" value="${att.id}"></li>`
        );
        $ul.append($li);
      });
      if (typeof renumberLabels === "function") renumberLabels();
    });
    frame.open();
  });
});
