<?php

/**
 * inc/property-entry.php – 物件登録／編集フォーム
 * @package Sanai_WP_Theme
 */
if (! defined('ABSPATH')) {
    exit;
}

/*──────────────────────────
 * 1) メニュー
 *─────────────────────────*/
function sanai_property_entry_menu()
{
    add_menu_page(
        __('物件登録', 'sanai-textdomain'),
        __('物件登録', 'sanai-textdomain'),
        'edit_posts',
        'sanai_property_entry',
        'sanai_property_entry_form',
        'dashicons-building',
        6
    );
    add_submenu_page(
        'sanai_property_entry',
        __('物件一覧', 'sanai-textdomain'),
        __('物件一覧', 'sanai-textdomain'),
        'edit_posts',
        'edit.php?post_type=property'
    );
}
add_action('admin_menu', 'sanai_property_entry_menu');

/*──────────────────────────
 * 2) 入力フォーム
 *─────────────────────────*/
function sanai_property_entry_form()
{

    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    $is_edit = $post_id > 0;

    /* 完了メッセージ */
    if (isset($_GET['saved']) && 'true' === $_GET['saved']) {
        echo '<div class="notice notice-success is-dismissible"><p>'
            . esc_html__('物件を保存しました。', 'sanai-textdomain')
            . '</p></div>';
    }

    /* 既存値 */
    $defaults = [
        'property_title'   => '',
        'property_price'   => '',
        'property_address' => '',
        'property_access'  => '',
    ];
    $overview_defaults = [];
    $existing_ids      = [];

    if ($is_edit && get_post_type($post_id) === 'property') {
        $defaults['property_title']   = get_post_meta($post_id, 'property_title',   true);
        $defaults['property_price']   = get_post_meta($post_id, 'price',            true);
        $defaults['property_address'] = get_post_meta($post_id, 'address',          true);
        $defaults['property_access']  = get_post_meta($post_id, 'access',           true);
        $existing_ids                 = (array) get_post_meta($post_id, 'property_images', true);

        foreach (get_post_meta($post_id) as $k => $v) {
            if (str_starts_with($k, 'ov_')) {
                $overview_defaults[substr($k, 3)] = $v[0];
            }
        }
    }

    $img_note = sprintf(__('※ 最大 %d 枚まで選択できます', 'sanai-textdomain'), 10);
?>
    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?php echo $is_edit ? esc_html__('物件を編集', 'sanai-textdomain')
                : esc_html__('物件登録', 'sanai-textdomain'); ?>
        </h1>

        <form method="post"
            action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
            enctype="multipart/form-data">
            <?php wp_nonce_field('sanai_property_entry', 'sanai_property_nonce'); ?>
            <input type="hidden" name="action" value="sanai_save_property">
            <?php if ($is_edit) : ?>
                <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
            <?php endif; ?>

            <table class="form-table">
                <tr>
                    <th><label for="property_title"><?php esc_html_e('物件タイトル', 'sanai-textdomain'); ?></label></th>
                    <td><textarea id="property_title" name="property_title" rows="3" class="large-text" required><?php
                                                                                                                    echo esc_textarea($defaults['property_title']);
                                                                                                                    ?></textarea></td>
                </tr>

                <tr>
                    <th><label for="property_images"><?php esc_html_e('物件画像', 'sanai-textdomain'); ?></label></th>
                    <td>
                        <input type="file" id="property_images"
                            name="property_images[]"
                            accept="image/*"
                            data-max="10"
                            multiple>
                        <div id="property_images_preview"
                            style="margin-top:.75rem;display:flex;flex-wrap:wrap;gap:.5rem;"></div>
                        <p class="description"><?php echo esc_html($img_note); ?></p>
                    </td>
                </tr>

                <?php /* 既存画像 (編集時のみ) */ ?>
                <?php if ($existing_ids) : ?>
                    <tr>
                        <th><?php esc_html_e('登録済み画像', 'sanai-textdomain'); ?></th>
                        <td>
                            <ul id="existing_images"
                                style="display:flex;flex-wrap:wrap;gap:.5rem;margin:0;padding:0;list-style:none;">
                                <?php foreach ($existing_ids as $eid) : ?>
                                    <li data-id="<?php echo esc_attr($eid); ?>"
                                        style="position:relative;">
                                        <?php echo wp_get_attachment_image(
                                            $eid,
                                            'thumbnail',
                                            false,
                                            ['style' => 'border-radius:4px;']
                                        ); ?>
                                        <button type="button" class="del-btn"
                                            style="position:absolute;top:2px;right:2px;
										       background:#d00;color:#fff;border:none;
											   width:20px;height:20px;border-radius:50%;
											   line-height:18px;text-align:center;cursor:pointer;">×</button>
                                        <input type="hidden" name="order_ids[]" value="<?php echo esc_attr($eid); ?>">
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <th><label for="property_price"><?php esc_html_e('価格', 'sanai-textdomain'); ?></label></th>
                    <td><textarea id="property_price" name="property_price" rows="2" class="large-text"><?php
                                                                                                        echo esc_textarea($defaults['property_price']);
                                                                                                        ?></textarea></td>
                </tr>

                <tr>
                    <th><label for="property_address"><?php esc_html_e('所在地', 'sanai-textdomain'); ?></label></th>
                    <td><textarea id="property_address" name="property_address" rows="2" class="large-text"><?php
                                                                                                            echo esc_textarea($defaults['property_address']);
                                                                                                            ?></textarea></td>
                </tr>

                <tr>
                    <th><label for="property_access"><?php esc_html_e('アクセス', 'sanai-textdomain'); ?></label></th>
                    <td><textarea id="property_access" name="property_access" rows="2" class="large-text"><?php
                                                                                                            echo esc_textarea($defaults['property_access']);
                                                                                                            ?></textarea></td>
                </tr>
            </table>

            <h2><?php esc_html_e('物件概要', 'sanai-textdomain'); ?></h2>
            <table class="form-table">
                <?php
                $overview_fields = [
                    'name'            => '物件名称',
                    'land_right'      => '土地権利',
                    'type'            => '物件種別',
                    'land_size'       => '土地面積',
                    'units'           => '販売棟数',
                    'floor_size'      => '物件（専有）面積',
                    'layout'          => '間取',
                    'structure'       => '建物構造',
                    'completion'      => '完成',
                    'parking'         => '駐車場',
                    'transaction'     => '取引態様',
                    'road'            => '接道状況',
                    'zone'            => '用途地域',
                    'coverage'        => '建ぺい率',
                    'floor_area'      => '容積率',
                    'management_cmp'  => '管理会社',
                    'management_form' => '管理形態',
                    'fee'             => 'マンション管理費',
                    'repair'          => '修繕費関係',
                    'note'            => '備考',
                ];

                foreach ($overview_fields as $key => $label) :
                    $value = $overview_defaults[$key] ?? '';
                ?>
                    <tr>
                        <th><label for="ov_<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label></th>
                        <td><textarea id="ov_<?php echo esc_attr($key); ?>"
                                name="overview[<?php echo esc_attr($key); ?>]"
                                rows="2" class="large-text"><?php echo esc_textarea($value); ?></textarea></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <?php submit_button($is_edit ? __('物件を更新', 'sanai-textdomain')
                : __('物件を登録', 'sanai-textdomain')); ?>
        </form>
    </div>

    <script>
        /* 新規画像プレビュー＋クリック削除 */
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('property_images');
            const preview = document.getElementById('property_images_preview');
            if (!input || !preview) return;

            const max = parseInt(input.dataset.max, 10) || 10;

            input.addEventListener('change', () => {
                if (input.files.length > max) {
                    alert(`最大 ${max} 枚まで選択できます。選択し直してください。`);
                    input.value = '';
                    preview.innerHTML = '';
                    return;
                }
                preview.innerHTML = '';
                Array.from(input.files).forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    const url = URL.createObjectURL(file);
                    const img = document.createElement('img');
                    img.src = url;
                    img.alt = file.name;
                    img.style.cssText = 'width:96px;height:96px;object-fit:cover;border-radius:4px;';
                    img.loading = 'lazy';
                    img.title = 'クリックで削除';
                    img.addEventListener('click', () => {
                        const dt = new DataTransfer();
                        Array.from(input.files).forEach(f => {
                            if (f !== file) dt.items.add(f);
                        });
                        input.files = dt.files;
                        img.remove();
                    });
                    preview.appendChild(img);
                });
            });

            /* 既存画像の削除ボタン */
            document.querySelectorAll('#existing_images .del-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const li = btn.parentElement;
                    const id = li.dataset.id;
                    /* 削除IDを hidden で追加 */
                    const h = document.createElement('input');
                    h.type = 'hidden';
                    h.name = 'delete_ids[]';
                    h.value = id;
                    document.querySelector('form').appendChild(h);
                    li.remove();
                });
            });
        });
    </script>
<?php
}

/*──────────────────────────
 * 3) 保存処理
 *─────────────────────────*/
function sanai_save_property()
{

    if (
        ! isset($_POST['sanai_property_nonce'])
        || ! wp_verify_nonce($_POST['sanai_property_nonce'], 'sanai_property_entry')
        || ! current_user_can('edit_posts')
    ) {
        wp_die(__('権限がありません。', 'sanai-textdomain'));
    }

    $post_id   = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $is_update = $post_id > 0;

    $title_raw  = wp_kses_post($_POST['property_title'] ?? '');
    $title_flat = trim(preg_replace('/\s+/', ' ', $title_raw));

    if ($is_update) {
        wp_update_post([
            'ID'         => $post_id,
            'post_title' => $title_flat ?: __('無題物件', 'sanai-textdomain'),
        ]);
    } else {
        $post_id = wp_insert_post([
            'post_title'  => $title_flat ?: __('無題物件', 'sanai-textdomain'),
            'post_type'   => 'property',
            'post_status' => 'publish',
        ], true);
        if (is_wp_error($post_id)) wp_die($post_id->get_error_message());
    }

    /* 基本メタ */
    foreach (
        [
            'property_title'   => 'property_title',
            'property_price'   => 'price',
            'property_address' => 'address',
            'property_access'  => 'access',
        ] as $f => $m
    ) {
        update_post_meta($post_id, $m, wp_kses_post($_POST[$f] ?? ''));
    }

    /* 物件概要メタ */
    if (isset($_POST['overview']) && is_array($_POST['overview'])) {
        foreach ($_POST['overview'] as $k => $v) {
            update_post_meta($post_id, 'ov_' . sanitize_key($k), wp_kses_post($v));
        }
    }

    /*------------ 既存画像の削除 -------------*/
    $delete_ids = array_map('intval', $_POST['delete_ids'] ?? []);
    foreach ($delete_ids as $did) {
        wp_delete_attachment($did, true);
    }

    /*------------ 既存画像の順序 -------------*/
    $order_ids = array_values(array_map('intval', $_POST['order_ids'] ?? []));
    /* 削除された ID を除外 */
    $order_ids = array_diff($order_ids, $delete_ids);

    /*------------ 新規画像アップロード -------------*/
    $new_ids = [];
    if (! empty($_FILES['property_images']['name'][0])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $files = [];
        foreach ($_FILES['property_images'] as $k => $arr) {
            foreach ($arr as $i => $v) $files[$i][$k] = $v;
        }
        foreach ($files as $f) {
            if ($f['error'] !== UPLOAD_ERR_OK) continue;
            $att = media_handle_sideload($f, $post_id);
            if (! is_wp_error($att)) $new_ids[] = $att;
        }
    }

    /*------------ 最終 ID 配列を保存 (最大 10) -------------*/
    $all_ids = array_slice(array_merge($order_ids, $new_ids), 0, 10);
    update_post_meta($post_id, 'property_images', $all_ids);

    if ($all_ids && ! has_post_thumbnail($post_id)) {
        set_post_thumbnail($post_id, $all_ids[0]);
    }

    wp_safe_redirect(
        admin_url('admin.php?page=sanai_property_entry&post_id=' . $post_id . '&saved=true'),
        303
    );
    exit;
}

/*──────────────────────────
 * 4) フック
 *─────────────────────────*/
add_action('admin_post_sanai_save_property',        'sanai_save_property');
add_action('admin_post_nopriv_sanai_save_property', 'sanai_save_property');

/* 一覧→編集リンクを自作フォームへ */
add_filter('get_edit_post_link', function ($l, $pid) {
    return get_post_type($pid) === 'property'
        ? admin_url('admin.php?page=sanai_property_entry&post_id=' . $pid)
        : $l;
}, 10, 2);

/* 標準「新規物件を追加」を転送 */
add_action('load-post-new.php', function () {
    $sc = get_current_screen();
    if ($sc && $sc->post_type === 'property') {
        wp_safe_redirect(admin_url('admin.php?page=sanai_property_entry'), 302);
        exit;
    }
});
