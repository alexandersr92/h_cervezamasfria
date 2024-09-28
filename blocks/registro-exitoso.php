<?php
$mainImage = get_field('main_image');

$link = get_field('link');
if (!isset($_GET['ph'])) {
  header('Location: /');
  exit;
}
$count = $_GET['count'];
$ph = $_GET['ph'];




?>
<section class="overflow-hidden supperBackground pb-[250px]">

  <div class="  relative z-10 py-24 md:py-20">

    <div class="container flex flex-col md:flex-row gap-14 items-end">
      <div class="w-full md:w-1/2">
        <div class="formWrapper">
          <div class="w-full md:w-[390px]">
            <img class="w-[150px] mx-auto" src="<?= get_template_directory_uri() . '/assets/img/ok.gif' ?>" alt="">
            <p>¡Gracias por participar!</p>
            <h3>Llevas <?= $count ?> registro<?= $count !== '1' ? 's' : '' ?></h3>
            <p class="p_small">Recordá que entre más facturas subás, más oportunidades tendrás de ganar 1 año de Cerveza Toña GRATIS.<br><br>

              ¡Vos podés ser uno de los <b>4 ganadores!</b></p>
            <div class="flex flex-row justify-center">

              <a class="btn-primary" href="<?= $link['url'] ?>/?ph=<?= $ph ?>"><?= $link['title'] ?></a>
            </div>
          </div>

        </div>
      </div>
      <div class="flex flex-col items-center justify-center gap-7 w-full md:w-1/2">
        <img src="<?= $mainImage['url']; ?>" alt="<?= $mainImage['alt']; ?>">

      </div>

    </div>


  </div>

  </div>
</section>