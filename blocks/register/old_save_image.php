<?php
/*   $factura_imagen_name = $factura_imagen['name'];
  $factura_imagen_tmp = $factura_imagen['tmp_name'];
  $factura_imagen_size = $factura_imagen['size'];
  $factura_imagen_type = $factura_imagen['type'];


  $factura_imagen_ext = str_replace('image/', '', $factura_imagen['type']);
  $factura_imagen_actual_ext = strtolower(end($factura_imagen_ext));

  $allowed = array('jpg', 'jpeg', 'png'); */
$path_destination = get_template_directory() . "/uploads/";
if (in_array($factura_imagen_actual_ext, $allowed)) {
  if ($factura_imagen_size[0] < 20000000) {


    $factura_imagen_name_new = str_replace(' ', '_', $nombre) . "_" . $factura . "_" . rand(0, 999) . "." . $factura_imagen_actual_ext;
    //comprove if file exists in the directory and change the name of the file
    while (file_exists($path_destination . $factura_imagen_name_new)) {
      $factura_imagen_name_new = str_replace(' ', '_', $nombre) . "_" . $factura . "_" . rand(999, 99999) . "." . $factura_imagen_actual_ext;
    }

    $factura_imagen_destination = $path_destination . $factura_imagen_name_new;
    if (move_uploaded_file($factura_imagen_tmp[0], $factura_imagen_destination)) {

      $factura_imagen_url = '/wp-content/themes/superexpress/uploads/' . $factura_imagen_name_new;
      $wasUploaded = true;
      //chmod($factura_imagen_destination, 0755);
    }
  } else {
    //echo "El archivo es muy grande";
  }
} else {
  //echo "El archivo no es valido";
}
