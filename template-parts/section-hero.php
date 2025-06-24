<?php
/**
 * template-parts/section-hero.php
 * 複数背景＋Ken Burns + GSAP テキスト
 */
?>
<section id="hero" class="hero">
  <!-- 背景レイヤー -->
  <div class="hero__bg hero__bg--1"></div>
  <div class="hero__bg hero__bg--2"></div>
  <div class="hero__bg hero__bg--3"></div>

  <!-- オーバーレイ -->
  <div class="hero__overlay"></div>

  <!-- テキスト -->
  <div class="hero__inner container text-center">
    <h1 class="hero__title"><?php bloginfo('name'); ?></h1>
    <p class="hero__subtitle"><?php bloginfo('description'); ?></p>
  </div>
</section>
