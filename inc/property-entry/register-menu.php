<?php
/**
 * inc/property-entry/register-menu.php
 */
if (! defined('ABSPATH')) {
	exit;
}

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

// 「投稿一覧→編集」,「新規追加」を独自フォームへ転送
add_filter('get_edit_post_link', function ($l, $pid) {
	return get_post_type($pid) === 'property'
		? admin_url('admin.php?page=sanai_property_entry&post_id=' . $pid)
		: $l;
}, 10, 2);

add_action('load-post-new.php', function () {
	$sc = get_current_screen();
	if ($sc && $sc->post_type === 'property') {
		wp_safe_redirect(admin_url('admin.php?page=sanai_property_entry'), 302);
		exit;
	}
});
