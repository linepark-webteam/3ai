<?php

/**
 * お問い合わせフォーム（STEP 1：入力画面）
 * Template Name: Contact Form
 *
 * 1. 入力       … /contact/index.php （このファイル）
 * 2. 確認       … /contact/contact_confirm.php
 * 3. 送信完了   … /contact/thanks.php（contact_send.php 経由）
 */
session_start();                    // ★ 戻る時に値を復元
get_header();
?>

<main id="primary" class="site-main">

    <!-- サブヒーロー -->
    <?php get_template_part('template-parts/section', 'subhero'); ?>

    <section class="contact section container">

        <?php
        // 進捗ステップ
        get_template_part('template-parts/contact', 'progress', ['step' => 1]);
        ?>

        <!-- バリデーションエラー（サーバ側） -->
        <?php if (isset($_SESSION['contact_errors'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($_SESSION['contact_errors'] as $err) : ?>
                    <p class="mb-0"><?php echo esc_html($err); ?></p>
                <?php endforeach;
                unset($_SESSION['contact_errors']); ?>
            </div>
        <?php endif; ?>

        <!-- お問い合わせフォーム -->
        <form
            id="contactForm"
            class="contact-form"
            action="<?php echo esc_url(get_theme_file_uri('contact/contact_confirm.php')); ?>"
            method="post"
            novalidate>
            <?php wp_nonce_field('contact_submit', 'contact_nonce'); ?>

            <!-- 1. お問い合わせの種類 -->
            <div class="contact-form__group">
                <label class="contact-form__label d-block mb-2">
                    <?php esc_html_e('お問い合わせの種類', 'sanai-textdomain'); ?><span class="required">※</span>
                </label>

                <div class="contact-form__radios">
                    <?php
                    $types = [
                        'property' => '物件について',
                        'recruit'  => '求人について',
                        'others'   => 'その他',
                    ];
                    foreach ($types as $value => $label) :
                        $id = 'inquiryType_' . $value;
                    ?>
                        <div class="form-check form-check-inline me-3">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="inquiry_type"
                                id="<?php echo esc_attr($id); ?>"
                                value="<?php echo esc_attr($value); ?>"
                                <?php checked($_SESSION['contact_data']['inquiry_type'] ?? '', $value); ?>
                                required>
                            <label class="form-check-label" for="<?php echo esc_attr($id); ?>">
                                <?php echo esc_html($label); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- 2. 社名（任意） -->
            <div class="contact-form__group">
                <label class="contact-form__label" for="companyName">
                    <?php esc_html_e('社名（法人の場合）', 'sanai-textdomain'); ?>
                </label>
                <input
                    type="text"
                    id="companyName"
                    name="company_name"
                    class="form-control"
                    maxlength="100"
                    value="<?php echo esc_attr($_SESSION['contact_data']['company_name'] ?? ''); ?>">
            </div>

            <!-- 3. 氏名 -->
            <div class="contact-form__group">
                <label class="contact-form__label" for="userName">
                    <?php esc_html_e('氏名', 'sanai-textdomain'); ?><span class="required">※</span>
                </label>
                <input
                    type="text"
                    id="userName"
                    name="user_name"
                    class="form-control"
                    maxlength="100"
                    value="<?php echo esc_attr($_SESSION['contact_data']['user_name'] ?? ''); ?>"
                    required>
            </div>

            <!-- 4. 電話番号 -->
            <div class="contact-form__group">
                <label class="contact-form__label" for="tel">
                    <?php esc_html_e('電話番号', 'sanai-textdomain'); ?><span class="required">※</span>
                </label>
                <input
                    type="tel"
                    id="tel"
                    name="tel"
                    class="form-control"
                    inputmode="tel"
                    pattern="[0-9\-]+"
                    maxlength="20"
                    value="<?php echo esc_attr($_SESSION['contact_data']['tel'] ?? ''); ?>"
                    required>
            </div>

            <!-- 5. メールアドレス -->
            <div class="contact-form__group">
                <label class="contact-form__label" for="email">
                    <?php esc_html_e('メールアドレス', 'sanai-textdomain'); ?><span class="required">※</span>
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    maxlength="100"
                    value="<?php echo esc_attr($_SESSION['contact_data']['email'] ?? ''); ?>"
                    required>
            </div>

            <!-- 6. 返信方法 -->
            <div class="contact-form__group">
                <label class="contact-form__label d-block mb-2">
                    <?php esc_html_e('返信方法のご希望', 'sanai-textdomain'); ?><span class="required">※</span>
                </label>

                <div class="contact-form__radios" id="replyType">
                    <?php
                    $reply_types = [
                        'email' => 'メールでの返信',
                        'tel'   => '電話での返信',
                        'any'   => 'どちらでも可',
                    ];
                    foreach ($reply_types as $value => $label) :
                        $id = 'replyType_' . $value;
                    ?>
                        <div class="form-check form-check-inline me-3">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="reply_type"
                                id="<?php echo esc_attr($id); ?>"
                                value="<?php echo esc_attr($value); ?>"
                                <?php checked($_SESSION['contact_data']['reply_type'] ?? '', $value); ?>
                                required>
                            <label class="form-check-label" for="<?php echo esc_attr($id); ?>">
                                <?php echo esc_html($label); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- 7. お問い合わせ内容 -->
            <div class="contact-form__group">
                <label class="contact-form__label" for="message">
                    <?php esc_html_e('お問い合わせ内容', 'sanai-textdomain'); ?><span class="required">※</span>
                </label>

                <textarea
                    id="message"
                    name="message"
                    class="form-control"
                    rows="6"
                    maxlength="2000"
                    data-max="2000"
                    required><?php echo esc_textarea($_SESSION['contact_data']['message'] ?? ''); ?></textarea>

                <!-- 残り文字数 -->
                <small id="messageCounter" class="form-text mt-1">
                    あと 2000 文字
                </small>
            </div>

            <!-- 8. プライバシーポリシー同意 -->
            <div class="contact-form__group form-check mb-4">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="agree"
                    id="agree"
                    value="1"
                    <?php checked($_SESSION['contact_data']['agree'] ?? '', '1'); ?>
                    required>
                <label class="form-check-label" for="agree">
                    <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" target="_blank" style="text-decoration: underline;">
                        <?php esc_html_e('プライバシーポリシー', 'sanai-textdomain'); ?>
                    </a>
                    <?php esc_html_e('に同意する', 'sanai-textdomain'); ?><span class="required">※</span>
                </label>
            </div>

            <!-- ハニーポット -->
            <div style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;">
                <label for="contactHp">Leave this field blank</label>
                <input type="text" id="contactHp" name="contact_hp" tabindex="-1" autocomplete="off">
            </div>

            <!-- 送信ボタン -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    <?php esc_html_e('内容確認へ', 'sanai-textdomain'); ?>
                </button>
            </div>
        </form>
    </section>
</main>

<?php get_footer(); ?>