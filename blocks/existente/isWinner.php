<?php

$ph = $_GET['ph'];
function formateDate($date)
{
  $timestamp = strtotime($date);
  $fecha_formateada = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'EEEE, d \'de\' MMMM y');
  return ucfirst($fecha_formateada->format($timestamp));
}
global $wpdb;
$table_participantes  = $wpdb->prefix . 'super_express_participantes';
$winnerIDs = $wpdb->get_results("SELECT id FROM $table_participantes WHERE status = 'Ganador' AND phone = '$ph'");
$winnerIDs = array_map(function ($winner) {
  return $winner->id;
}, $winnerIDs);

$table_ganadores  = $wpdb->prefix . 'super_express_ganadores';
$winnerDB;
foreach ($winnerIDs as $idWinner) {
  $winner = $wpdb->get_row("SELECT * FROM $table_ganadores WHERE id_participante = $idWinner");
  if ($winner) {
    $winnerDB = $winner;
    break;
  }
}
$ganador = $wpdb->get_results("SELECT * FROM $table_participantes WHERE status = 'Ganador' AND phone = '$ph'");
$ganador = $ganador[0];

$table_premio = $wpdb->prefix . 'super_express_premios';
$premio = $wpdb->get_row("SELECT * FROM $table_premio WHERE id = $winnerDB->id_premio");
$table_sorteo = $wpdb->prefix . 'super_express_sorteos';
$getSorteo = $wpdb->get_row("SELECT * FROM $table_sorteo WHERE id = $winnerDB->id_sorteo");

$sorteoFecha = formateDate($getSorteo->date);







$premioImage = $premio->image;
$nombre = $ganador->name;
$premio = $premio->name;

$sorteoFecha = $sorteoFecha;
$finalText = get_field('premio_text', 'option');
?>

<div class="formWrapper md:w-[700px]">
  <div class="flex flex-col gap-2">
    <h3 style="font-size: 32px; " class="leading-[38px]">¡Felicidades,<br><?= $nombre ?></h3>
    <p>Has sido el ganador de un</p>
    <h3 style="font-size: 52px;" class="leading-[50px]"><?= $premio ?></h3>
    <p style="font-size: 18px;">en el sorteo realizado el día <?= $sorteoFecha ?></p>
    <div class="flex justify-center">
      <img class="h-[250px]" src="<?= $premioImage ?>" alt="<?= $premio ?>">
    </div>
    <p style="font-size: 18px;"> <?= $finalText ?></p>

  </div>

</div>