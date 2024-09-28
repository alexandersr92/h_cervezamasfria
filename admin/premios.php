<?php
function getPremios()
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'super_express_premios';
  $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY orderP ASC");
  return $results;
}
if (isset($_POST['regPremio'])) {
  include_once get_template_directory() . '/admin/regPremio.php';
  $premios = getPremios();
} else {
  $premios = getPremios();
}
if (isset($_POST['updateQuantity'])) {
  global $wpdb;
  $table_name = $wpdb->prefix . 'super_express_premios';
  $id = $_POST['id'];
  $quantity = $_POST['quantity'];
  $wpdb->update(
    $table_name,
    array('quantity' => $quantity),
    array('id' => $id)
  );
  $premios = getPremios();
}

if (isset($_POST['deletePremio'])) {
  global $wpdb;
  $table_name = $wpdb->prefix . 'super_express_premios';
  $id = $_POST['id'];
  $wpdb->delete(
    $table_name,
    array('id' => $id)
  );
  $premios = getPremios();
}
?>
<h1>Registre un Premios</h1>
<form action="#" method="post" enctype="multipart/form-data">
  Nombre: <input type="text" name="name" />
  Cantidad: <input type="number" name="quantity" />
  Orden: <input type="number" name="order" />
  Imagen: <input type="file" name="profile_picture" />
  <input class="button" type="submit" name="regPremio" value="Guardar" />
</form>

<h1>Lista de Premios</h1>

<table class="widefat fixed" cellspacing="0">
  <thead>
    <tr>
      <th id="columnname" class="manage-column column-columnname num" scope="col">Orden</th>
      <th id="columnname" class="manage-column column-columnname num" scope="col">Premio</th>
      <th id="columnname" class="manage-column column-columnname num" scope="col">Cantidad</th>
      <th id="columnname" class="manage-column column-columnname num" scope="col">Imagen</th>
      <th id="columnname" class="manage-column column-columnname num" scope="col">Eliminar</th>
    </tr>
  </thead>

  <tbody>
    <?php
    foreach ($premios as $key => $item) {
      $alternate = $key % 2 == 0 ? 'alternate' : '';
    ?>
      <tr class="<?= $alternate ?>">
        <td class="column-columnname"><?= $item->orderP ?></td>
        <td class="column-columnname"><?= $item->name ?></td>
        <td class="column-columnname">
          <form action="#" method="post">
            <input type="hidden" name="id" value="<?= $item->id ?>" />
            <input type="number" name="quantity" value="<?= $item->quantity ?>" />
            <input type="submit" name="updateQuantity" value="Actualizar" />
          </form>

        </td>
        <td class="column-columnname"><img height="100px" src="<?= $item->image ?>"></td>
        <td>
          <form action="#" method="post">
            <input type="hidden" name="id" value="<?= $item->id ?>" />
            <input type="submit" name="deletePremio" class="button" value="Eliminar" />
          </form>
        </td>

      </tr>
    <?php
    }
    ?>

  </tbody>


</table>