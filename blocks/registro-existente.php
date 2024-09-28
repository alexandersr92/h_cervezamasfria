<?php
$mainImage = get_field('main_image');


if ($_POST) {

  include_once(get_template_directory() . '/blocks/register/save.php');
}

?>
<section class="overflow-hidden supperBackground pb-[250px]">

  <div class="  relative z-10 py-24 md:py-20">

    <div class="container">
      <div class="flex flex-col items-center justify-center mb-[40px] md:mb-[60px]">
        <img src="<?php echo $mainImage['url']; ?>" alt="<?php echo $mainImage['alt']; ?>">

      </div>
      <?php


      if (isset($_GET['ph'])) {

        global $wpdb;
        $ph = $_GET['ph'];
        $table_name = $wpdb->prefix . 'super_express_participantes';
        $results = $wpdb->get_results("SELECT * FROM $table_name WHERE phone =$ph LIMIT 1 ");

        $count = count($results);
        if ($count > 0) {
          $status = $results[0]->status;
          if ($status === 'Ganador') {
            include_once(get_template_directory() . '/blocks/existente/isWinner.php');
          } else {

            include_once(get_template_directory() . '/blocks/existente/form_logged.php');
          }
        } else {
          $error_phone = true;
          include_once(get_template_directory() . '/blocks/existente/form_login.php');
        }
      } else {
        include_once(get_template_directory() . '/blocks/existente/form_login.php');
      }

      ?>
    </div>


  </div>

  </div>
</section>