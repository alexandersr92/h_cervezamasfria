<?php
global $wpdb;
$ph = $_GET['ph'];
$table_name = $wpdb->prefix . 'super_express_participantes';
$results = $wpdb->get_results("SELECT * FROM $table_name WHERE phone =$ph LIMIT 1 ");
$name = $results[0]->name;
$telefono = $results[0]->phone;
$email = $results[0]->email;
$cedula = $results[0]->cedula;

if ($_POST) {

  include_once(get_template_directory() . '/blocks/register/save.php');
}
//get register count for phone
$count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE phone = $ph");



?>

<div class="formWrapper md:w-[700px]">
  <div class="w-full md:w-[390px]">
    <h3>Bienvenido (a), llevas <?= $count ?> Registro<?= $count !== '1' ? 's' : '' ?></h3>
    <p>Subí tu factura de compra</p>
  </div>
  <form action="#" id="registerExistent" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="email" value="<?= $email ?>">
    <input type="hidden" name="cedula" value="<?= $cedula ?>">
    <div class="formWrapper__input disabled">
      <label for="nombre">Nombre Completo *</label>
      <input type="text" name="nombre" id="nombre" value="<?= $name ?>" readonly>
    </div>
    <div class="formWrapper__input disabled">
      <label for="telefono">Número de celular *</label>
      <input type="number" name="telefono" id="telefono" value="<?= $telefono ?>" readonly>
    </div>
    <div class="formWrapper__input <?= isset($error_factura) &&  $error_factura ? 'status_error' : '' ?>">
      <label for="factura">Número de Factura *</label>
      <input type="text" name="factura" id="factura" placeholder="123-12-12345678" require>
      <?= isset($error_factura) &&  $error_factura ? ' <span class="text-[#E31F1F] font-semibold text-base">*El número de factura ingresado ya se encuentra registrado.</span>' : '' ?>

    </div>
    <div class="formWrapper__input--file">
      <label for="factura_imagen">Subí la fotografía completa de tu ticket/factura *</label>
      <input type="file" name="factura_imagen[]" id="factura_imagen" require>
      <span>Tipos de archivos aceptados: jpg, jpeg, png, Tamaño máximo de archivo: 20 MB.</span>
    </div>
    <div class="formWrapper__input--check">
      <input type="checkbox" name="terminos" id="terminos" require>
      <label for="">Acepto los Términos y Condiciones de la promoción</label>
    </div>
    <div>
      <button class="btn-primary">Subir factura</button>
    </div>
  </form>
</div>