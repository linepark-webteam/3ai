
/* ------------------------------------------------------------------
 * property-entry.js  –  1リスト + 番号ラベル + 擬似ファイルボタン対応版
 * ----------------------------------------------------------------- */

document.addEventListener('DOMContentLoaded', () => {
	initThumbnail();
	initGalleryUnified();
});

/* ================================================================
 * 1) サムネイルプレビュー（id="property_thumbnail_input"）
 * ================================================================ */
function initThumbnail() {
	const input   = document.getElementById('property_thumbnail_input');
	const preview = document.getElementById('thumb_preview');
	if (!input) return;

	/* ファイル選択でプレビュー表示 */
	input.addEventListener('change', () => {
		preview.innerHTML = '';

		if (input.files[0]?.type.startsWith('image/')) {
			const url = URL.createObjectURL(input.files[0]);
			const img = document.createElement('img');
			img.src   = url;
			img.style.cursor = 'pointer';
			img.title = 'クリックで削除';
			img.onclick = () => { input.value = ''; img.remove(); };

			preview.appendChild(img);
		}

		/* 既存サムネイルを消す */
		document.getElementById('existing_thumb')?.remove();

		/* 削除フラグ */
		if (input.files.length) {
			document.querySelector('form')
			        .insertAdjacentHTML('beforeend','<input type="hidden" name="delete_thumb" value="1">');
		}
	});

	/* 擬似ボタンのクリックで input を開く */
	document.querySelector('label[for="property_thumbnail_input"]')?.addEventListener('click', () => {
		input.click();
	});
}

/* ================================================================
 * 2) ギャラリー：既存 + 新規を 1 リスト (#gallery_list)
 *    - 追加・削除・並び替え
 * ================================================================ */
function initGalleryUnified() {

	const form     = document.querySelector('form');
	const galInput = document.getElementById('property_images_input');
	const list     = document.getElementById('gallery_list');
	if (!galInput || !list) return;

	const MAX       = parseInt(galInput.dataset.max, 10) || 10;
	let   galFiles  = [];   // 新規 File の配列

	/* ========== 2-1. ファイル追加 ========== */
	galInput.addEventListener('change', () => {

		const selects = [...galInput.files];

		if (list.children.length + selects.length > MAX) {
			alert(`最大 ${MAX} 枚まで選択できます。選択し直してください。`);
			galInput.value = '';
			return;
		}

		selects.forEach((file) => {
			if (!file.type.startsWith('image/')) return;

			const idx = galFiles.push(file) - 1;   // 追加後の index

			const url = URL.createObjectURL(file);
			const li  = document.createElement('li');
			li.className   = 'sortable-item';
			li.dataset.idx = String(idx);
			li.style.position = 'relative';

			li.innerHTML = `
				<span class="img-label"></span>
				<img src="${url}">
				<button type="button" class="del-btn"
				        style="position:absolute;top:2px;right:2px;background:#d00;color:#fff;border:none;width:24px;height:24px;border-radius:50%;line-height:22px;cursor:pointer;">×</button>`;
			list.appendChild(li);
		});

		galInput.value = '';   // 同じファイルを選び直せるようリセット
		syncInputFiles();
		renumberLabels();
	});

	/* ========== 2-2. 削除ボタン（イベント委譲） ========== */
	form.addEventListener('click', (e) => {
		const btn = e.target.closest('.del-btn');
		if (!btn) return;

		const li = btn.closest('li');

		/* --- 既存画像 --- */
		if (li.dataset.id) {
			form.insertAdjacentHTML(
				'beforeend',
				`<input type="hidden" name="delete_ids[]" value="${li.dataset.id}">`
			);
			li.remove();
			refreshOrderIds();
			renumberLabels();
			return;
		}

		/* --- 新規画像 --- */
		const idx = Number(li.dataset.idx);
		if (!isNaN(idx)) {
			galFiles.splice(idx, 1);
			li.remove();
			reindexNewLis();
			syncInputFiles();
			renumberLabels();
		}
	});

	/* ========== 2-3. Sortable で並び替え ========== */
	new Sortable(list, {
		animation: 150,
		onEnd: () => {
			reorderGalFilesByList();
			syncInputFiles();
			refreshOrderIds();
			renumberLabels();
		}
	});

	/* ----------------- Helper: galFiles をリスト順に並べ替え ----------------- */
	function reorderGalFilesByList() {
		const order = [...list.querySelectorAll('li')].filter(li => li.dataset.idx !== undefined)
		                 .map(li => Number(li.dataset.idx));
		galFiles = order.map(i => galFiles[i]);
		reindexNewLis();
	}

	/* ----------------- Helper: dataset.idx を振り直す ----------------- */
	function reindexNewLis() {
		let i = 0;
		list.querySelectorAll('li').forEach(li => {
			if (li.dataset.idx !== undefined) {
				li.dataset.idx = String(i++);
			}
		});
	}

	/* ----------------- Helper: input.files を DataTransfer で再構築 --------- */
	function syncInputFiles() {
		const dt = new DataTransfer();
		galFiles.forEach(f => dt.items.add(f));
		galInput.files = dt.files;
	}

	/* ----------------- Helper: hidden order_ids[] を生成 -------------------- */
	function refreshOrderIds() {
		form.querySelectorAll('input[name="order_ids[]"]').forEach(el => el.remove());
		list.querySelectorAll('li[data-id]').forEach(li => {
			form.insertAdjacentHTML(
				'beforeend',
				`<input type="hidden" name="order_ids[]" value="${li.dataset.id}">`
			);
		});
	}

	/* ----------------- Helper: ラベル採番 -------------------- */
	function renumberLabels() {
		let num = 1;
		list.querySelectorAll('li').forEach(li => {
			li.querySelector('.img-label').textContent = `${num++}枚目`;
		});
	}

	/* 初期ロード時のラベル付け・順序 hidden */
	renumberLabels();
	refreshOrderIds();

	/* 擬似ボタン → input.click() */
	document.querySelector('label[for="property_images_input"]')?.addEventListener('click', () => {
		galInput.click();
	});
}
