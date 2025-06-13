<?php
/**
 * template-parts/section-company-info.php
 * 会社概要 会社情報テーブル 用テンプレートパーツ
 *
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
?>

<section class="company-info section container">
  <h2 class="section-title">
    <?php esc_html_e( '会社情報', 'sanai-textdomain' ); ?>
  </h2>
  <table class="company-info__table">
    <tbody>
      <tr>
        <th><?php esc_html_e( '会社名', 'sanai-textdomain' ); ?></th>
        <td><?php esc_html_e( '三愛不動産管理', 'sanai-textdomain' ); ?></td>
      </tr>
      <tr>
        <th><?php esc_html_e( '設立', 'sanai-textdomain' ); ?></th>
        <td><?php esc_html_e( 'YYYY年M月D日', 'sanai-textdomain' ); ?></td>
      </tr>
      <tr>
        <th><?php esc_html_e( '資本金', 'sanai-textdomain' ); ?></th>
        <td><?php esc_html_e( 'X,XXX万円', 'sanai-textdomain' ); ?></td>
      </tr>
      <tr>
        <th><?php esc_html_e( '免許番号', 'sanai-textdomain' ); ?></th>
        <td><?php esc_html_e( '神奈川県知事（7）第21620号', 'sanai-textdomain' ); ?></td>
      </tr>
      <tr>
        <th><?php esc_html_e( '所在地', 'sanai-textdomain' ); ?></th>
        <td><?php esc_html_e( '横浜市旭区鶴ヶ峰2丁目2-3', 'sanai-textdomain' ); ?></td>
      </tr>
      <tr>
        <th><?php esc_html_e( '主要取引銀行', 'sanai-textdomain' ); ?></th>
        <td><?php esc_html_e( '〇〇銀行、△△銀行', 'sanai-textdomain' ); ?></td>
      </tr>
    </tbody>
  </table>
</section>

