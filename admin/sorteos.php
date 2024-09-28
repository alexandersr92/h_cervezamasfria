<?php
function getSorteos()
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'super_express_sorteos';
  $results = $wpdb->get_results("SELECT * FROM $table_name");
  return $results;
}
if (isset($_POST['registerSorteo'])) {

  global $wpdb;
  $table_name = $wpdb->prefix . 'super_express_sorteos';

  $status = 'Pendiente';
  $date = $_POST['dateSorteo'];
  $wpdb->insert(
    $table_name,
    array(
      'date' => $date,
      'status' => $status
    )
  );
  $sorteos = getSorteos();
}
if (isset($_POST['deleteSorteo'])) {

  global $wpdb;
  $table_name = $wpdb->prefix . 'super_express_sorteos';
  $id = $_POST['id'];
  $wpdb->delete($table_name, array('id' => $id));

  $premios = getSorteos();
}
if (isset($_POST['updateSorteo'])) {
  global $wpdb;
  $table_name = $wpdb->prefix . 'super_express_sorteos';
  $id = $_POST['id'];
  $status = $_POST['status'];
  $wpdb->update($table_name, array('status' => $status), array('id' => $id));
  $sorteos = getSorteos();
}
if (isset($_POST['gerExcelSorteo'])) {
  $idSorteo = $_POST['idSorteo'];
  require get_template_directory() . '/src/genSorteoGanador.php';
  $linkExcel[$idSorteo] = $report_url;
}

$sorteos = getSorteos();
?>
<style>
  .wrappActionSorteos {
    display: flex;
    gap: 20px;

  }
</style>

<h1>Registre un Sorteo</h1>
<form action="#" method="post">
  Fecha del Sorteo: <input type="date" name="dateSorteo" />
  <input class="button" type="submit" name="registerSorteo" value="Guardar" />
</form>

<h1>Lista de Sorteos</h1>

<?php
foreach ($sorteos as $key => $item) {


  $date = $item->date;
  $timestamp = strtotime($date);
  $fecha_formateada = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'EEEE, d \'de\' MMMM y');
  $fecha_formateada = ucfirst($fecha_formateada->format($timestamp));

?>
  <h2>Sorteo del día: <?= $fecha_formateada ?> estado: <?= $item->status ?> </h2>
  <div class="wrappActionSorteos">
    <form action="#" method="post">
      <input type="hidden" name="id" value="<?= $item->id ?>" />
      <input class="button" type="submit" name="deleteSorteo" value="Eliminar" />
    </form>
    <form action="#" method="post">
      <input type="hidden" name="id" value="<?= $item->id ?>" />
      <select name="status">
        <option value="Pendiente">Pendiente</option>
        <option value="Realizado">Realizado</option>
        <option value="Cancelado">Cancelado</option>
        <option value="Activo">Activo</option>
      </select>
      <input class="button" type="submit" name="updateSorteo" value="Actualizar" />
    </form>

  </div>


  <?php
  if ($item->winners !== '') {
  ?>
    <div style="display: flex gap: 10px;">
      <form style="margin-top: 20px; display: block" method="post" action="#">
        <input type="hidden" name="idSorteo" value="<?= $item->id ?>" />
        <input class="button" type="submit" name="gerExcelSorteo" value="Generar Excel" />
      </form>
      <?php
      if (isset($linkExcel[$item->id])) {
      ?>
        <a href="<?= $linkExcel[$item->id] ?>" style="margin-top: 10px;" class="button button-primary">Descargar Excel</a>
      <?php
      }
      ?>

    </div>
<?php
  }
}
?>