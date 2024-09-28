<?php
$mainImage = get_field('main_image');
$parnerLogos = get_field('partner_logos');
$floatElements = get_field('float_elements');
$hasWinner = false;
$winner = [
  'name' => 'Nombre de Ganador',
  'phone' => '88888888',
  'factura' => '123-00-00000000',

];
function formateDate($date)
{
  $timestamp = strtotime($date);
  $fecha_formateada = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'EEEE, d \'de\' MMMM y');
  return ucfirst($fecha_formateada->format($timestamp));
}

if (isset($_POST['getWinner'])) {
  include_once get_template_directory() . '/blocks/tombola/getWinner.php';
  $ganador = getGanador();
  if ($ganador !== null) {
    $winner = $ganador;
    $hasWinner = $ganador !== null ? true : false;
  } else {
    echo "No hay ganador";
  }
}
if (isset($_POST['rejectWinner'])) {
  include_once get_template_directory() . '/blocks/tombola/rejectWinner.php';
  $idWinner = $_POST['idWinner'];
  rejectWinner($idWinner);
}
if (isset($_POST['addWinner'])) {
  include_once get_template_directory() . '/blocks/tombola/addWinner.php';

  addWinner($_POST['idWinner'], $_POST['sorteo'], $_POST['premio']);

  unset($_POST);
}
global $wpdb;
$table_name = $wpdb->prefix . 'super_express_sorteos';
$table_premios = $wpdb->prefix . 'super_express_premios';
$sorteos = $wpdb->get_results("SELECT * FROM $table_name WHERE status = 'Activo' LIMIT 1");
$hasSorteo = count($sorteos) > 0;

if ($hasSorteo) {
  $sorteo = $sorteos[0];
  $winList = $sorteo->winners;
  $idSorteo = $sorteo->id;


  $fecha_formateada = formateDate($sorteo->date);
  $tableWinners = [];
  $winnersList = explode(',', $sorteos[0]->winners);

  $proximosSorteos = $wpdb->get_results("SELECT date FROM $table_name WHERE status = 'Pendiente' AND id != $idSorteo ORDER BY date ASC LIMIT 1");
  $hasProxSorteo = count($proximosSorteos) > 0;
  $proxSorteoDate = '';
  if ($hasProxSorteo) {
    $proxSorteo = $proximosSorteos[0];
    $proxSorteoDate = formateDate($proxSorteo->date);
  }


  if ($winnersList[0] !== '') {
    foreach ($winnersList as $item) {

      $tableParticipantes = $wpdb->prefix . 'super_express_participantes';
      $tableGanadores = $wpdb->prefix . 'super_express_ganadores';
      $tablePremios = $wpdb->prefix . 'super_express_premios';

      $winDB = $wpdb->get_results("SELECT 
      $tableParticipantes.name as nombre, 
      $tableParticipantes.phone, 
      $tablePremios.name as premio 
        FROM 
        $tablePremios, 
        $tableParticipantes, 
        $tableGanadores  
        WHERE 
        $tableGanadores .id_premio = $tablePremios.id AND
        $tableParticipantes.id = $tableGanadores .id_participante AND
        $tableParticipantes.id =  $item");

      if (count($winDB) > 0) {

        $winDB = $winDB[0];
      }

      array_push($tableWinners, $winDB);
    }
  }
}

$premios = $wpdb->get_results("SELECT * FROM $table_premios WHERE quantity > 0 ORDER BY orderP ASC  LIMIT 1");
$hasPremio = count($premios) > 0;

?>
<section class="overflow-hidden supperBackground pb-[250px]">
  <div class=" w-screen h-screen absolute left-0 top-0 z-0"></div>
  <div class="  relative z-10 py-24 md:py-20">

    <div class="container">
      <div class="flex flex-col items-center justify-center mb-[40px] md:mb-[60px]">
        <img src="<?php echo $mainImage['url']; ?>" alt="<?php echo $mainImage['alt']; ?>">
      </div>
      <?php
      if ($hasSorteo) {
      ?>
        <div>
          <div class="mb-24">
            <?php
            if ($hasPremio) {
            ?>
              <form action="#" class="flex justify-center" method="POST">

                <button class="btn-primary" name="getWinner">Seleccionar Ganador</button>
              </form>
            <?php

            } else {
            ?>
              <div class="flex justify-center">
                <button id="getWinnerFk" class="btn-primary">Seleccionar Ganador</button>
              </div>
              <dialog class=" w-[500px] bg-transparent">
                <div class="formWrapper">

                  <p>No hay más premios para el sorteo del día de hoy.</p>
                  <?php
                  if ($proxSorteoDate !== '') {
                    echo '<h3>El próximo sorteo será el ' . $proxSorteoDate . '</h3>';
                  } else {
                    echo '<h3>No hay sorteos pendientes</h3>';
                  }

                  ?>
                  <div class="flex justify-center py-4">
                    <button id="closeModalFK" class="btn-primary">Salir</button>
                  </div>
                </div>

              </dialog>
            <?php
            }
            ?>

          </div>
          <div class=" grid grid-cols-2 gap-4">
            <div class="formWrapper self-baseline">
              <div class="w-full md:w-[550px] mb-6">
                <h3>Fecha de Sorteo: <?= $fecha_formateada ?></h3>
                <p>Información de Ganador</p>
                <div class="flex flex-col gap-4 mt-5">
                  <div class="winnerElementWrapp">
                    <h3 class="winnerElement"><?= $winner['name'] ?></h3>
                  </div>
                  <div class="winnerElementWrapp">
                    <h3 class="winnerElement"><?= $winner['phone'] ?></h3>
                  </div>
                  <div class="winnerElementWrapp">
                    <h3 class="winnerElement"><?= $winner['factura'] ?></h3>
                  </div>
                </div>
                <?php
                if ($hasWinner) {

                ?>
                  <div class="py-4">
                    <dialog id="modal_factura" class="p-5">
                      <div class="w-full h-[600px]">

                        <img class="h-[600px] w-full object-contain" src="<?= $winner['factura_imagen'] ?>" alt="">
                      </div>
                      <div class="flex flex-row justify-between">

                        <button onclick="closeModalFactura()" class="btn-secondary scale-75">Cerrar</button>
                        <a href="<?= $winner['factura_imagen'] ?>" class="btn-primary scale-75" download>Descargar</a>
                      </div>
                    </dialog>

                    <button onclick="showModalFactura()" class="text-white text-xl underline font-bold py-4">Ver Imagen de Factura</button>
                    <div class="flex flex-row items-center justify-between gap-4 py-10 px-6 border-4 border-accent-200 rounded-2xl">
                      <img class="h-40 w-40 object-contain" src="<?= $winner['premio']->image ?>" alt="">
                      <div class="frameWinner ">
                        <p class="text-white font-bold text-2xl text-left">Ha sido el ganador de un</p>
                        <h3 class="!text-[32px] leading-8 text-left"><?= $winner['premio']->name ?></h3>
                      </div>
                    </div>
                    <div class="flex flex-row justify-between gap-4 py-4 w-full">
                      <form class="" action="#" method="POST">
                        <input type="hidden" name="idWinner" value="<?= $winner['id'] ?>">
                        <button class="btn-secondary " style="max-width: 14rem" name="rejectWinner">Sacar Ganador</button>
                      </form>

                      <form class="flex justify-end" action="#" method="POST">
                        <input type="hidden" name="idWinner" value="<?= $winner['id'] ?>">
                        <input type="hidden" name="sorteo" value="<?= $idSorteo ?>">
                        <input type="hidden" name="premio" value="<?= $winner['premio']->id ?>">
                        <button class="btn-primary " style="max-width: 14rem" name="addWinner">Agregar Ganador</button>
                      </form>


                    </div>
                  </div>
                <?php
                }
                ?>


              </div>

            </div>
            <div class="formWrapper ">
              <div class="w-full md:w-[550px] mb-6">
                <h3>LISTADO DE GANADORES</h3>
                <table class="tableWinner">
                  <thead>
                    <tr>
                      <th>Gana<br>dor#</th>
                      <th>Nombre Completo</th>
                      <th>Número<br>de celular</th>
                      <th>Premio</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    if (count($tableWinners) > 0) {
                      foreach ($tableWinners as $key => $item) {
                    ?>
                        <tr>
                          <td><?= $key + 1 ?></td>
                          <td><?= $item->nombre ?></td>
                          <td><?= $item->phone ?></td>
                          <td><?= $item->premio ?></td>
                        </tr>
                    <?php
                      }
                    } else {
                      echo '<tr><td colspan="4" class="text-center">No hay ganadores</td></tr>';
                    }

                    ?>

                  </tbody>
                </table>


              </div>

            </div>
          </div>
        </div>
      <?php
      } else {
      ?>
        <div class="flex justify-center">
          <h1 class="text-white text-2xl">No hay sorteos activos </h1>
        </div>
      <?php
      }
      ?>
    </div>


  </div>

</section>
<script>
  function showModalFactura() {

    const modal = document.querySelector('#modal_factura')

    modal.showModal()
  }

  function closeModalFactura() {

    const modal = document.querySelector('#modal_factura')

    modal.close()
  }
  const getWinnerFk = document.querySelector('#getWinnerFk')
  getWinnerFk.addEventListener('click', () => {
    const dialog = document.querySelector('dialog')
    dialog.showModal()

    //create body overlay black
    const overlay = document.createElement('div')
    overlay.classList.add('overlay')
    document.body.appendChild(overlay)

  })

  const closeModalFK = document.querySelector('#closeModalFK')
  closeModalFK.addEventListener('click', () => {
    const dialog = document.querySelector('dialog')
    dialog.close()

    const overlay = document.querySelector('.overlay')
    overlay.remove()

  })
</script>