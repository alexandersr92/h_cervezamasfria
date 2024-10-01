<?php
$mainImage = get_field('main_image');
$parnerLogos = get_field('partner_logos');
$floatElements = get_field('float_elements');
$promo = get_field('promo');
$loginLink = get_field('login_link');
$registerLink = get_field('register_link');

$particeTitle = get_field('practice_title');
$steps = get_field('steps');
$participeLink = get_field('participe_link');

?>
<section class="overflow-hidden ">
  <div class="supperBackground  relative z-10 py-24 md:py-20">

    <div class="container">
      <div class="flex flex-col items-center justify-center gap-8">
        <img src="<?php echo $mainImage['url']; ?>" alt="<?php echo $mainImage['alt']; ?>">

      </div>
      <div class="flex flex-col items-center justify-center gap-6">
        <p class="text-white font-extrabold text-center text-2xl">¿Aún no estás registrado?</p>
        <a class="btn-secondary" href="<?= $registerLink['url']; ?>"><?= $registerLink['title']; ?></a>
        <p class="text-white font-extrabold text-center text-2xl">¿Ya estás registrado?</p>
        <a class="btn-primary" href="<?= $loginLink['url']; ?>"><?= $loginLink['title']; ?></a>

      </div>

    </div>

  </div>

  <div id="como_participar " class="py-20 pb-60 md:pb-20 bg-[#FF671D] relative">
    <div class="container  ">

      <h3 class="text-white font-extrabold text-center text-[52px] "><?= $particeTitle ?></h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-20 mt-20 md:w-[1000px] mx-auto items-start ">
        <img class="absolute w-[80px] md:w-[250px] -rotate-12 right-0 -bottom-10 md:left-2 md:top-[22rem]" src="<?= $floatElements[1]['image']['url'] ?>" alt="">
        <img class="absolute h-[270px] md:h-[623px] rotate-12 left-0 -bottom-14 md:left-[88%] md:top-48" src="<?= $floatElements[0]['image']['url'] ?>" alt="">

        <?php
        if ($steps) {

          foreach ($steps as $key => $step) {
        ?>
            <div class="w-full  flex flex-col items-center justify-center gap-6">
              <div class="w-[120px] h-[120px] rounded-full bg-[#FF671D] border-8 border-black flex flex-row items-center justify-center ">
                <p class="text-[#FEBE26] text-[52px] font-extrabold text-outline "><?= $key + 1 ?></p>
              </div>
              <p class="text-white font-extrabold text-center text-xl"><?= $step['text'] ?></p>

            </div>
        <?php

          }
        }

        ?>
      </div>
      <div class="flex flex-row justify-center mt-20">
        <a class="btn-primary" href="<?= $participeLink['url'] ?>"><?= $participeLink['title'] ?></a>
      </div>
    </div>

  </div>
</section>