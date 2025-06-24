<?php
if (! defined('ABSPATH')) {
    exit;
}

add_action('admin_post_sanai_save_property',        'sanai_save_property');
add_action('admin_post_nopriv_sanai_save_property', 'sanai_save_property');

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

    /* 物件概要 */
    if (isset($_POST['overview'])) {
        foreach ($_POST['overview'] as $k => $v) {
            update_post_meta($post_id, 'ov_' . sanitize_key($k), wp_kses_post($v));
        }
    }

    /*------------ サムネイル ------------*/
    if (isset($_POST['delete_thumb'])) {
        delete_post_thumbnail($post_id);
    }
    if (! empty($_FILES['property_thumbnail']['name'])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        if ($_FILES['property_thumbnail']['error'] === UPLOAD_ERR_OK) {
            $tid = media_handle_sideload($_FILES['property_thumbnail'], $post_id);
            if (! is_wp_error($tid)) {
                set_post_thumbnail($post_id, $tid);
            }
        }
    }

    /*------------ ギャラリー ------------*/
    $delete_ids = array_map('intval', $_POST['delete_ids'] ?? []);
    foreach ($delete_ids as $did) {
        wp_delete_attachment($did, true);
    }

    $order_ids = array_values(array_map('intval', $_POST['order_ids'] ?? []));
    $order_ids = array_diff($order_ids, $delete_ids);

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

    $all_ids = array_slice(array_merge($order_ids, $new_ids), 0, 10);
    update_post_meta($post_id, 'property_images', $all_ids);

    if (! has_post_thumbnail($post_id) && $all_ids) {
        set_post_thumbnail($post_id, $all_ids[0]);
    }

    wp_safe_redirect(
        admin_url('admin.php?page=sanai_property_entry&post_id=' . $post_id . '&saved=true'),
        303
    );
    exit;
}
