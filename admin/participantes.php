<?php
global $wpdb;
$table_name = $wpdb->prefix . 'super_express_participantes';
$resultsTotal = $wpdb->get_results("SELECT * FROM $table_name ");
$count = count($resultsTotal);

if (isset($_POST['approve'])) {
  //update statis Aprobado
  $id = $_POST['id'];
  $wpdb->update(
    $table_name,
    array('status' => 'Aprobado'),
    array('id' => $id)
  );

  echo "<script>location.reload();</script>";
}
if (isset($_POST['rechazar'])) {
  //update statis Aprobado
  $id = $_POST['id'];
  $wpdb->update(
    $table_name,
    array('status' => 'Rechazado'),
    array('id' => $id)
  );
  echo "<script>location.reload();</script>";
}
if (isset($_POST['action'])) {
  $arrParticipantes = explode(',', $_POST['arrParticipantes']);
  $typeOfAction = $_POST['action'];

  foreach ($arrParticipantes as $id) {
    $wpdb->update(
      $table_name,
      array('status' => $typeOfAction),
      array('id' => $id, 'status' => 'Pendiente')
    );
  }



  echo "<script>location.reload();</script>";
}
if (isset($_POST['generarExcel'])) {


  //import SimpleXLSXGen
  require get_template_directory() . '/src/generateExcel.php';
}


//create pagination with 50 per page
$per_page = 50;
$page = isset($_GET['cpage']) ? abs((int) $_GET['cpage']) : 1;
$offset = ($page * $per_page) - $per_page;
$results = $wpdb->get_results("SELECT * FROM $table_name LIMIT $offset, $per_page");


?>
<style>
  .content-wrapper {
    padding-right: 20px;
  }

  .modal {
    max-width: 800px;
  }

  .modal .two-col {
    display: flex;
    flex-direction: row;
  }

  .modal .two-col>div {
    width: 50%;
  }

  .modal .two-col>div img {
    max-width: 100%;
  }

  .modal .buttons_list {
    display: flex;
    gap: 10px;

  }

  .pagination {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }

  a.page-numbers,
  span.page-numbers {

    display: flex;
    padding: 4px;
    background: #2271b1;
    color: white;
    width: 20px;
    height: 20px;
    border-radius: 4px;
    justify-content: center;
    align-items: center;
    cursor: pointer;
  }

  span.page-numbers.current {
    background: #f1f1f1;
    color: #2271b1;
    cursor: default;
  }

  .flexrow {
    display: flex;
    flex-direction: row;
    gap: 10px;
    align-self: center;
    margin-top: 20px;
  }

  .flexrow a {
    display: inline-block;
    max-height: 30px;

  }
</style>

<div class="content-wrapper">
  <h1>Lista de Participantes</h1>
  <div class="tablenav top">
    <form action="#" method="POST">
      <input type="hidden" name="arrParticipantes" id="arrParticipantes" value="super-express-participantes">
      <select name="action" id="action">
        <option value="-1">Acciones en lote</option>
        <option value="Aprobado">Aprobado</option>
        <option value="Rechazado">Rechazar</option>
        <option value="Pendiente">Pendiente</option>
      </select>
      <input type="submit" class="button" value="Aplicar">
    </form>


  </div>
  <table class="widefat fixed" cellspacing="0">
    <thead>
      <tr>
        <td id="cb" class="manage-column column-cb check-column">

          <input id="cb-select-all-1" type="checkbox">
        </td>
        <th id="columnname" class="manage-column column-columnname" scope="col">Nombre Completo</th>
        <th id="columnname" class="manage-column column-columnname num" scope="col">Teléfono</th>
        <th id="columnname" class="manage-column column-columnname num" scope="col">Correo Electrónico</th>
        <th id="columnname" class="manage-column column-columnname num" scope="col">Cédula</th>
        <th id="columnname" class="manage-column column-columnname num" scope="col">Factura</th>
        <th id="columnname" class="manage-column column-columnname num" scope="col">Estado</th>
        <th id="columnname" class="manage-column column-columnname num" scope="col">Validar</th>
      </tr>
    </thead>

    <tbody>
      <?php
      foreach ($results as $key => $item) {
        $alternate = $key % 2 == 0 ? 'alternate' : '';
      ?>
        <tr class="<?= $alternate ?>">
          <th scope="row" class="check-column">

            <input id="cb-select-1" type="checkbox" name="post[]" value="<?= $item->id ?>">

          </th>
          <td class="column-columnname"><?= $item->name ?></td>
          <td class="column-columnname"><?= $item->phone ?></td>
          <td class="column-columnname"><?= $item->email ?></td>
          <td class="column-columnname"><?= $item->cedula ?></td>
          <td class="column-columnname"><?= $item->factura ?></td>

          <td class="column-columnname"><?= $item->status ?></td>
          <td class="column-columnname">

            <buttom <?= $item->status !==  'Pendiente' ? 'disabled' : 'onclick="showModal(' . $key . ')"' ?> class="button button-primary">Validar</buttom>
            <dialog id="modal_<?= $key ?>">
              <div class="modal">
                <div class="two-col">
                  <div>
                    <h2>Nombre: <?= $item->name ?></h2>
                    <h2>Teléfono: <?= $item->phone ?></h2>
                    <h2>Factura: <?= $item->factura ?></h2>


                  </div>
                  <div>
                    <img loading="lazy" src=" <?= $item->factura_imagen ?>">
                  </div>
                </div>
                <div class="buttons_list">
                  <buttom onclick="closeModal(<?= $key ?>)" class="button button-info">Cancelar</buttom>
                  <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $item->id ?>">
                    <input type="submit" name="approve" value="Aprobar" class="button button-primary">
                  </form>
                  <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $item->id ?>">
                    <input type="submit" name="rechazar" value="Rechazar" class="button button-secondary">
                  </form>

                </div>

              </div>
            </dialog>
          </td>

        </tr>
      <?php
      }
      ?>

    </tbody>
    <tfoot>
      <tr>

        <th colspan="2" class="manage-column column-columnname" scope="col"><b>Total de Registro</b></th>
        <th colspan="1" class="manage-column column-columnname" scope="col"><?= $count ?></th>
        <th colspan="5">
          <?php

          $page_links = paginate_links(array(
            'base' => add_query_arg('cpage', '%#%'),
            'format' => '',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => ceil($count / $per_page),
            'current' => $page
          ));

          if ($page_links) {

            echo '<div class="pagination">' . $page_links . '</div>';
          }



          ?>
        </th>


      </tr>
    </tfoot>


  </table>
  <div class="flexrow">
    <form action="#" method="POST">

      <input type="submit" class="button" name="generarExcel" value="Generar Excel">
    </form>
    <?php
    if (isset($report_url) && !empty($report_url)) {
      echo "<a class='button button-primary' href='$report_url' download>Descargar Excel</a>";
    }
    ?>
  </div>
</div>
<script>
  function showModal(id) {

    const modal = document.querySelector(`#modal_${id}`)

    modal.showModal()
  }

  function closeModal(id) {

    const modal = document.querySelector(`#modal_${id}`)

    modal.close()
  }

  const selectAll = document.querySelector('#cb-select-all-1')
  const checkboxes = document.querySelectorAll('input[name="post[]"]')

  selectAll.addEventListener('change', (e) => {
    checkboxes.forEach(checkbox => {
      checkbox.checked = e.target.checked
    })
  })
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', (e) => {
      console.log(e.target.value)

    })
  })
  const inputHiddenArrParticipantes = document.querySelector('#arrParticipantes')
  const selectAction = document.querySelector('#action')
  const form = document.querySelector('.tablenav.top form')
  form.addEventListener('submit', (e) => {
    e.preventDefault()
    const selected = Array.from(checkboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value)
    console.log("selec", selected)
    inputHiddenArrParticipantes.value = selected
    console.log(inputHiddenArrParticipantes.value)
    form.submit()
  })
</script>