<?php

/**
 * inc/property-entry.php
 * 独自投稿画面：物件登録
 * @package Sanai_WP_Theme
 */
if (! defined('ABSPATH')) {
    exit;
}

/*──────────────────────────
 * 1) メニュー追加
 *─────────────────────────*/
function sanai_property_entry_menu()
{
    add_menu_page(
        __('物件登録', 'sanai-textdomain'),     // メニュータイトル
        __('物件登録', 'sanai-textdomain'),     // サイドバー表示名
        'edit_posts',                            // 権限
        'sanai_property_entry',                  // slug
        'sanai_property_entry_form',             // コールバック
        'dashicons-building',                    // アイコン
        6                                        // 表示位置
    );
}
add_action('admin_menu', 'sanai_property_entry_menu');

/*──────────────────────────
 * 2) 入力フォーム表示
 *─────────────────────────*/
function sanai_property_entry_form()
{

    // 送信後の完了メッセージ
    if (isset($_GET['saved']) && $_GET['saved'] === 'true') {
        echo '<div class="notice notice-success is-dismissible"><p>'
            . esc_html__('物件を登録しました。', 'sanai-textdomain')
            . '</p></div>';
    }

    // ノンス生成
    $nonce_field = wp_nonce_field('sanai_property_entry', 'sanai_property_nonce', true, false);
?>

    <div class="wrap">
        <h1 class="wp-heading-inline"><?php esc_html_e('物件登録', 'sanai-textdomain'); ?></h1>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="sanai-property-form">
            <?php echo $nonce_field; ?>
            <input type="hidden" name="action" value="sanai_save_property">

            <table class="form-table">
                <tr>
                    <th><label for="property_title"><?php esc_html_e('タイトル', 'sanai-textdomain'); ?></label></th>
                    <td><input type="text" id="property_title" name="property_title" class="regular-text" required></td>
                </tr>
                <tr>
                    <th><label for="property_price"><?php esc_html_e('価格（万円）', 'sanai-textdomain'); ?></label></th>
                    <td><input type="number" id="property_price" name="property_price" class="small-text"></td>
                </tr>
                <tr>
                    <th><label for="property_address"><?php esc_html_e('所在地', 'sanai-textdomain'); ?></label></th>
                    <td><input type="text" id="property_address" name="property_address" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="property_access"><?php esc_html_e('アクセス', 'sanai-textdomain'); ?></label></th>
                    <td><input type="text" id="property_access" name="property_access" class="regular-text"></td>
                </tr>
            </table>

            <?php submit_button(__('物件を登録', 'sanai-textdomain')); ?>
        </form>
    </div>
<?php
}

/*──────────────────────────
 * 3) 保存処理
 *─────────────────────────*/
function sanai_save_property()
{

    /* ── ノンス & 権限 ── */
    if (
        ! isset($_POST['sanai_property_nonce'])
        || ! wp_verify_nonce($_POST['sanai_property_nonce'], 'sanai_property_entry')
        || ! current_user_can('edit_posts')
    ) {
        wp_die(__('権限がありません。', 'sanai-textdomain'));
    }

    /* ── 投稿生成 ── */
    $post_id = wp_insert_post([
        'post_title'   => sanitize_text_field($_POST['property_title']),
        'post_type'    => 'property',
        'post_status'  => 'publish',
    ], true);

    if (is_wp_error($post_id)) {
        wp_die($post_id->get_error_message());
    }

    /* ── メタ保存 ── */
    $meta_map = [
        'property_price'   => 'price',
        'property_address' => 'address',
        'property_access'  => 'access',
    ];
    foreach ($meta_map as $form_key => $meta_key) {
        if (isset($_POST[$form_key])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$form_key]));
        }
    }

    /* ── 完了リダイレクト ── */
    wp_safe_redirect(add_query_arg('saved', 'true', menu_page_url('sanai_property_entry', false)));
    exit;
}
add_action('admin_post_sanai_save_property', 'sanai_save_property');
