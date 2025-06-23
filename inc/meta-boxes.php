<?php
/**
 * Property Meta Boxes
 * @package Sanai_WP_Theme
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * メタボックス登録
 */
function sanai_add_property_metaboxes() {
    add_meta_box(
        'property_basic_meta',
        __( '物件基本情報', 'sanai-textdomain' ),
        'sanai_property_basic_fields',
        'property',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sanai_add_property_metaboxes' );

/**
 * 入力フィールド
 */
function sanai_property_basic_fields( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'sanai_property_nonce' );

$fields = [
    'price'       => __( '価格（万円）', 'sanai-textdomain' ),
    'address'     => __( '所在地', 'sanai-textdomain' ),
    'area'        => __( '専有面積（m²）', 'sanai-textdomain' ),
    'floor_plan'  => __( '間取り', 'sanai-textdomain' ),
    'access'      => __( 'アクセス', 'sanai-textdomain' ),
    'map_image'   => __( '地図サムネイル画像 URL', 'sanai-textdomain' ),
    'built_year'  => __( '築年', 'sanai-textdomain' ),
];


    echo '<table class="form-table">';
    foreach ( $fields as $key => $label ) {
        $value = get_post_meta( $post->ID, $key, true );
        printf(
            '<tr><th><label for="%1$s">%2$s</label></th><td><input type="text" id="%1$s" name="%1$s" value="%3$s" class="regular-text" /></td></tr>',
            esc_attr( $key ),
            esc_html( $label ),
            esc_attr( $value )
        );
    }
    echo '</table>';
}

/**
 * 保存処理
 */
function sanai_save_property_meta( $post_id ) {

    /* --- 権限・自動保存チェック --- */
    if ( ! isset( $_POST['sanai_property_nonce'] ) ||
         ! wp_verify_nonce( $_POST['sanai_property_nonce'], basename( __FILE__ ) ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
    if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

    /* --- 保存するキー --- */
    $meta_keys = [ 'price', 'address', 'area', 'floor_plan', 'access', 'map_image', 'built_year' ];


    foreach ( $meta_keys as $key ) {
        $new_value = isset( $_POST[ $key ] ) ? sanitize_text_field( $_POST[ $key ] ) : '';
        update_post_meta( $post_id, $key, $new_value );
    }
}
add_action( 'save_post_property', 'sanai_save_property_meta' );
