<?php
// ★ ここで $args['step'] を取り出す
$step = isset( $args['step'] ) ? intval( $args['step'] ) : 1;
?>
<ol class="contact-steps" aria-label="<?php esc_attr_e( 'お問い合わせ手順', 'sanai-textdomain' ); ?>">
  <?php
  $labels = [
    1 => __( 'フォーム入力', 'sanai-textdomain' ),
    2 => __( '内容確認',   'sanai-textdomain' ),
    3 => __( '送信完了',   'sanai-textdomain' ),
  ];
  foreach ( $labels as $num => $label ) : ?>
    <li class="contact-step <?php echo $step === $num ? 'is-current' : ''; ?>">
      <span class="contact-step__index"><?php echo sprintf( '%02d', $num ); ?></span>
      <span class="contact-step__title"><?php echo esc_html( $label ); ?></span>
    </li>
  <?php endforeach; ?>
</ol>
