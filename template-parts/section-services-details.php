<?php

/**
 * template-parts/section-services-details.php
 * 事業内容 各事業詳細 テンプレートパーツ
 *
 * @package Sanai_WP_Theme
 * @since 1.0.0
*/
// ─────────────────────────────────────────
// 事業データ（必要に応じて追加・編集）
// ─────────────────────────────────────────
$services = [
    [
        'jp'    => '賃貸管理・賃貸仲介',
        'image' => 'services-01.webp',
    ],
    [
        'jp'    => '駐車場管理・運営',
        'image' => 'services-02.webp',
    ],
    [
        'jp'    => '売買仲介営業',
        'image' => 'services-03.webp',
    ],
    [
        'jp'    => '不動産査定・買取提案',
        'image' => 'services-04.webp',
    ],
    [
        'jp'    => '資産コンサルティング',
        'image' => 'services-05.webp',
    ],
    [
        'jp'    => 'リフォーム提案',
        'image' => 'services-06.webp',
    ],
];
?>

<?php foreach ( $services as $index => $service ) : ?>
    <?php
        $num      = $index + 1;                                           // 1-based 番号
        $id       = 'service' . $num;                                     // id="service1" など
        $reverse  = ( $num % 2 === 0 ) ? ' services__detail--reverse' : '';
        $slugged  = sprintf( 'Service %02d', $num );                      // “Service 01”
        $img_src  = esc_url( get_template_directory_uri() . '/assets/img/' . $service['image'] );
        $title_jp = esc_html__( $service['jp'], 'sanai-textdomain' );
    ?>

    <!-- ▼ <?php echo esc_html( $slugged ); ?> -->
    <section id="<?php echo esc_attr( $id ); ?>" class="services__detail section container<?php echo esc_attr( $reverse ); ?>">
        <div class="services__detail-body">
            <h3 class="services__detail-number">
                <?php echo esc_html( $slugged ); ?>
            </h3>
            <h4 class="services__detail-title services__detail-title--jp">
                <?php echo $title_jp; ?>
            </h4>
        </div>

        <figure class="services__detail-image">
            <img
                src="<?php echo $img_src; ?>"
                alt="<?php echo esc_attr( $title_jp ); ?>"
            >
        </figure>
    </section>
<?php endforeach; ?>
