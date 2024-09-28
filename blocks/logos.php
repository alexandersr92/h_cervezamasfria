<?php
$title = get_field('title');
$logos = get_field('logos');
$float = get_field('float');
$float_position = get_field('float_position');
$background = get_field('background');
//get unique id for this block
$id = 'logos-' . $block['id'];
?>
<style>
  .bgLogos<?= $id ?> {
    background: <?= $background; ?>;
  }
</style>
<section class="bgLogos<?= $id ?> relative">
  <?php

  if ($float_position === 'left') {
    echo '<img class="absolute z-0 -right-16 md:right-auto md:-left-24 -top-16 md:-top-28 rotate-12 w-[150px] md:w-[300px]" src="' . $float['url'] . '" alt="' . $float['alt'] . '">';
  } else {
    echo '<img class="absolute z-10 -left-10 md:left-auto md:-right-24 -top-12 md:-top-28 rotate-12 w-[150px] md:w-[300px]" src="' . $float['url'] . '" alt="' . $float['alt'] . '">';
  }

  ?>
  <div class="container py-[60px] flex flex-col items-center gap-10">
    <h2 class="font-semibold text-white text-center text-4xl"><?= $title ?></h2>
    <div class="flex flex-row items-center justify-center gap-[60px] flex-wrap">
      <?php
      foreach ($logos as $logo) {
        $logo = $logo['logo'];
      ?>
        <img classs="w-20" src="<?= $logo['url'] ?>" alt="<?= $logo['alt'] ?>">
      <?php
      }
      ?>
    </div>
  </div>
</section>