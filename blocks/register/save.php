<?php
//
var_dump('asdfasdf112233');
global $wpdb;
ob_start();

$isNewRegister = isset($_POST['isNewRegister']) ? true : false;
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$email = $_POST['email'] ? $_POST['email'] : 'No tiene';
$cedula = $_POST['cedula'];
$factura = $_POST['factura'];
$factura_imagen = $_FILES['factura_imagen'];
$terminos = $_POST['terminos'];
$table_name_participantes = $wpdb->prefix . 'super_express_participantes';
$error_phone = false;
$error_factura = false;

if ($isNewRegister) {
  global $wpdb;
  $results = $wpdb->get_results("SELECT * FROM $table_name_participantes WHERE phone = '$telefono'");
  if (count($results) > 0) {
    $error_phone = true;
  }
}

//comprove if facture is already in the database
$resultFactura = $wpdb->get_results("SELECT * FROM $table_name_participantes WHERE factura = '$factura'");


if (count($resultFactura) > 0) {
  $error_factura = true;
}
//comprove if the phone is already in the database


if (!$error_phone &&  !$error_factura && $nombre && $telefono && $cedula && $factura && $factura_imagen && $terminos) {
  $factura_imagen_type = $factura_imagen['type'];
  $factura_imagen_ext = str_replace('image/', '', $factura_imagen['type']);
  $factura_imagen_actual_ext = strtolower(end($factura_imagen_ext));
  $_FILES['factura_imagen']['name'] =  str_replace(' ', '_', $nombre) . "_" . $factura . "_" . rand(0, 999) . "." . $factura_imagen_actual_ext;

  include_once get_template_directory() . '/src/upload.php';
  $uploadImage = uploadImage($_FILES['factura_imagen']);

  //save in database
  if ($uploadImage['wasUploaded']) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'super_express_participantes';
    $register = $wpdb->insert(
      $table_name,
      array(
        'time' => current_time('mysql'),
        'name' => $nombre,
        'email' => $email,
        'phone' => $telefono,
        'cedula' => $cedula,
        'factura' => $factura,
        'factura_imagen' =>  $uploadImage['factura_imagen_url'],
        'status' => 'Pendiente'
      )
    );



    //get how many records are in the database by phone
    $table_name = $wpdb->prefix . 'super_express_participantes';
    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE phone = $telefono");
    $count = count($results);


    echo "<script>window.location.href='/registro-exitoso?count=$count&ph=$telefono';</script>";
  }
}
