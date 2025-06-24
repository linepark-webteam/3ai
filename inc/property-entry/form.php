<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function sanai_property_entry_form() {

	$post_id = isset( $_GET['post_id'] ) ? intval( $_GET['post_id'] ) : 0;
	$is_edit = $post_id > 0;

	if ( isset( $_GET['saved'] ) && 'true' === $_GET['saved'] ) {
		echo '<div class="notice notice-success is-dismissible"><p>'
		     . esc_html__( '物件を保存しました。', 'sanai-textdomain' )
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
	$existing_ids      = [];              // ギャラリー
	$thumb_id          = 0;               // サムネイル

	if ( $is_edit && get_post_type( $post_id ) === 'property' ) {
		$defaults['property_title']   = get_post_meta( $post_id, 'property_title',   true );
		$defaults['property_price']   = get_post_meta( $post_id, 'price',            true );
		$defaults['property_address'] = get_post_meta( $post_id, 'address',          true );
		$defaults['property_access']  = get_post_meta( $post_id, 'access',           true );
		$existing_ids                 = (array) get_post_meta( $post_id, 'property_images', true );
		$thumb_id                     = get_post_thumbnail_id( $post_id );

		foreach ( get_post_meta( $post_id ) as $k => $v ) {
			if ( str_starts_with( $k, 'ov_' ) ) {
				$overview_defaults[ substr( $k, 3 ) ] = $v[0];
			}
		}
	}

	$img_note = sprintf( __( '※ ギャラリーは最大 %d 枚', 'sanai-textdomain' ), 10 );
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline"><?php echo $is_edit ? esc_html__( '物件を編集', 'sanai-textdomain' ) : esc_html__( '物件登録', 'sanai-textdomain' ); ?></h1>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
			<?php wp_nonce_field( 'sanai_property_entry', 'sanai_property_nonce' ); ?>
			<input type="hidden" name="action" value="sanai_save_property">
			<?php if ( $is_edit ) : ?>
				<input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
			<?php endif; ?>

			<table class="form-table">
				<tr>
					<th><label for="property_title"><?php esc_html_e( '物件タイトル', 'sanai-textdomain' ); ?></label></th>
					<td><textarea id="property_title" name="property_title" rows="3" class="large-text" required><?php echo esc_textarea( $defaults['property_title'] ); ?></textarea></td>
				</tr>

				<!-- サムネイル -->
				<tr>
					<th><label for="property_thumbnail"><?php esc_html_e( 'サムネイル画像(1枚)', 'sanai-textdomain' ); ?></label></th>
					<td>
						<input type="file" id="property_thumbnail" name="property_thumbnail" accept="image/*">
						<div id="thumb_preview" style="margin-top:.75rem;display:flex;gap:.5rem;"></div>
						<?php if ( $thumb_id ) : ?>
							<?php echo wp_get_attachment_image( $thumb_id, 'thumbnail', false, [ 'id'=>'existing_thumb', 'style'=>'border-radius:4px;' ] ); ?>
						<?php endif; ?>
						<p class="description"><?php esc_html_e( 'クリックで削除できます', 'sanai-textdomain' ); ?></p>
					</td>
				</tr>

				<!-- ギャラリー：既存 + 新規(追加) リストを分離 -->
				<tr>
					<th><label for="property_images"><?php esc_html_e( 'ギャラリー画像', 'sanai-textdomain' ); ?></label></th>
					<td>
						<input type="file" id="property_images" name="property_images[]" accept="image/*" data-max="10" multiple>
						<ul id="existing_images" class="sortable-list" style="display:flex;flex-wrap:wrap;gap:.5rem;margin:0;padding:0;list-style:none;">
						<?php foreach ( $existing_ids as $eid ) : ?>
							<li data-id="<?php echo esc_attr( $eid ); ?>" class="sortable-item" style="position:relative;">
								<?php echo wp_get_attachment_image( $eid, 'thumbnail', false, [ 'style'=>'border-radius:4px;' ] ); ?>
								<button type="button" class="del-btn" style="position:absolute;top:2px;right:2px;background:#d00;color:#fff;border:none;width:20px;height:20px;border-radius:50%;line-height:18px;text-align:center;cursor:pointer;">×</button>
								<input type="hidden" name="order_ids[]" value="<?php echo esc_attr( $eid ); ?>">
							</li>
						<?php endforeach; ?>
						</ul>

						<ul id="new_images" class="sortable-list" style="display:flex;flex-wrap:wrap;gap:.5rem;margin:0;padding:0;list-style:none;"></ul>
						<p class="description"><?php echo esc_html( $img_note ); ?></p>
					</td>
				</tr>

				<tr><th><label for="property_price"><?php esc_html_e( '価格', 'sanai-textdomain' ); ?></label></th>
					<td><textarea id="property_price" name="property_price" rows="2" class="large-text"><?php echo esc_textarea( $defaults['property_price'] ); ?></textarea></td></tr>

				<tr><th><label for="property_address"><?php esc_html_e( '所在地', 'sanai-textdomain' ); ?></label></th>
					<td><textarea id="property_address" name="property_address" rows="2" class="large-text"><?php echo esc_textarea( $defaults['property_address'] ); ?></textarea></td></tr>

				<tr><th><label for="property_access"><?php esc_html_e( 'アクセス', 'sanai-textdomain' ); ?></label></th>
					<td><textarea id="property_access" name="property_access" rows="2" class="large-text"><?php echo esc_textarea( $defaults['property_access'] ); ?></textarea></td></tr>
			</table>

			<h2><?php esc_html_e( '物件概要', 'sanai-textdomain' ); ?></h2>
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
			foreach ( $overview_fields as $key => $label ) :
				$val = $overview_defaults[ $key ] ?? '';
				?>
				<tr>
					<th><label for="ov_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
					<td><textarea id="ov_<?php echo esc_attr( $key ); ?>" name="overview[<?php echo esc_attr( $key ); ?>]" rows="2" class="large-text"><?php echo esc_textarea( $val ); ?></textarea></td>
				</tr>
			<?php endforeach; ?>
			</table>

			<?php submit_button( $is_edit ? __( '物件を更新', 'sanai-textdomain' ) : __( '物件を登録', 'sanai-textdomain' ) ); ?>
		</form>
	</div>
<?php
}