<?php


function getWiner()
{
  global $wpdb;
  $table_name_ganadores = $wpdb->prefix . 'super_express_ganadores';
  $table_name_participantes = $wpdb->prefix . 'super_express_participantes';
  $table_premios = $wpdb->prefix . 'super_express_premios';

  $resultsGanadores = $wpdb->get_results("SELECT $table_name_participantes.name as name, phone, factura, cedula, email,   $table_premios.name as premio, factura_imagen FROM  $table_name_ganadores, $table_name_participantes,   $table_premios WHERE  $table_name_participantes.id = $table_name_ganadores.id_participante  AND $table_premios.id = $table_name_ganadores.id_premio");
  $totalGanadores = count($resultsGanadores);
  return $resultsGanadores;
}

function getTotalGanadores()
{
  global $wpdb;
  $table_name_ganadores = $wpdb->prefix . 'super_express_ganadores';
  $resultsGanadores = $wpdb->get_results("SELECT * FROM $table_name_ganadores");
  return count($resultsGanadores);
}
if (isset($_POST['genGanadoresExcel'])) {
  require get_template_directory() . '/src/genGanadoresExcel.php';
  $linkExcel = $report_url;
}

?>
<style>
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
</style>

<h1>Lista de Participantes</h1>
<form method="post" action="#">
  <input type="submit" style="margin: 10px 0;" class="button" name="genGanadoresExcel" value="Generar Excel" />
</form>
<?php
if (isset($linkExcel)) {
  echo "<a class='button button-primary' href='$linkExcel' download>Descargar Excel</a>";
}
?>

<table class="widefat fixed" cellspacing="0">
  <thead>
    <tr>

      <th id="columnname" class="manage-column column-columnname" scope="col">Nombre Completo</th>
      <th id="columnname" class="manage-column column-columnname num" scope="col">Teléfono</th>
      <th id="columnname" class="manage-column column-columnname num" scope="col">Correo Electrónico</th>
      <th id="columnname" class="manage-column column-columnname num" scope="col">Cédula</th>
      <th id="columnname" class="manage-column column-columnname num" scope="col">Factura</th>
      <th id="columnname" class="manage-column column-columnname num" scope="col">Premio</th>
      <th id="columnname" class="manage-column column-columnname num" scope="col">Factura</th>

    </tr>
  </thead>

  <tbody>
    <?php
    foreach (getWiner() as $key => $item) {
      $alternate = $key % 2 == 0 ? 'alternate' : '';
    ?>
      <tr class="<?= $alternate ?>">

        <td class="column-columnname"><?= $item->name ?></td>
        <td class="column-columnname"><?= $item->phone ?></td>
        <td class="column-columnname"><?= $item->email ?></td>
        <td class="column-columnname"><?= $item->cedula ?></td>
        <td class="column-columnname"><?= $item->factura ?></td>
        <td class="column-columnname"><?= $item->premio ?></td>
        <td class="column-columnname"><a class="button" href="<?= $item->factura_imagen ?>" download>Descargar</a></td>



      </tr>
    <?php
    }
    ?>

  </tbody>
  <tfoot>
    <tr>

      <th colspan="1" class="manage-column column-columnname" scope="col"><b>Total de Registro</b></th>
      <th colspan="5" class="manage-column column-columnname" scope="col"><?= getTotalGanadores() ?></th>


    </tr>
  </tfoot>


</table>
<script>
  function showModal(id) {

    const modal = document.querySelector(`#modal_${id}`)

    modal.showModal()
  }

  function closeModal(id) {

    const modal = document.querySelector(`#modal_${id}`)

    modal.close()
  }
</script>