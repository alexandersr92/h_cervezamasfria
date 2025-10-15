<?php
$title = get_field('Title');
$description = get_field('description');
$validez = get_field('validez');
$image = get_field('imagen');
$background = get_field('background');
?>
<style>
  .bgComoFunciona {
    background: <?= $background; ?>;
  }
</style>
<section id="encontrar_codigo" class="bgComoFunciona pb-[250px]">
  <div class="container py-[60px] flex flex-col md:flex-row justify-center gap-20 ">
    <div class="w-full md:w-1/2">
      <h2 class="font-semibold text-[#233660] text-center text-[32px]  md:text-[52px] leading-9 md:leading-[62px] mb-5"><?= $title ?></h2>
      <p class="text-[#233660] text-center text-xl font-semibold mb-5"><?= $description ?></p>
      <div class="p-8  bg-[#0033A1]  rounded-[10px]">
        <p class="text-white text-center text-[26px] font-semibold leading-8"><?= $validez ?></p>
      </div>
    </div>
    <div class="flex justify-center md:justify-start">
      <img class="w-[188px]" src="<?= $image['url'] ?>" alt="<?= $image['alt'] ?>">
    </div>
  
  </div>
</section>