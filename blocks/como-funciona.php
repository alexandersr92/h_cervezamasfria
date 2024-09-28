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
  <div class="container py-[60px] grid grid-cols-1 md:grid-cols-2 gap-20 ">
    <div class="flex justify-center md:justify-end">
      <img class="w-[260px] h-[260px] md:w-[390px] md:h-[390px] aspect-square" src="<?= $image['url'] ?>" alt="<?= $image['alt'] ?>">
    </div>
    <div>
      <h2 class="font-semibold text-[#233660] text-center text-[32px]  md:text-[52px] leading-9 md:leading-[62px] mb-5"><?= $title ?></h2>
      <p class="text-[#233660] text-center text-xl font-semibold mb-5"><?= $description ?></p>
      <div class="p-8 border-4 bg-[#FF671D] border-black rounded-[10px]">
        <p class="text-white text-center text-[26px] font-semibold leading-8"><?= $validez ?></p>
      </div>
    </div>
  </div>
</section>