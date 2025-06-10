<?php
/**
 * template-parts/page-recruit.php
 * 採用ページテンプレート
 * 
 */
get_header();
?>

<main>
  <section id="recruit" class="recruit section container">
    <header class="recruit__header">
      <h1 class="recruit__title"><?php the_title(); ?></h1>
    </header>
    <div class="recruit__content">
      <?php
      if ( have_posts() ) :
        while ( have_posts() ) : the_post();
          the_content();  // 管理画面で入力された本文を出力
        endwhile;
      endif;
      ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
