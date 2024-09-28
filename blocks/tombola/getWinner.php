<?php
function getParticipantes()
{
  global $wpdb;
  $table  = $wpdb->prefix . 'super_express_participantes';
  $participantes = $wpdb->get_results("SELECT id FROM $table WHERE status = 'Aprobado'");
  return $participantes;
}

function validateWinner($id)
{
  global $wpdb;
  $IsWinner = true;
  $tableGanadores = $wpdb->prefix . 'super_express_ganadores';
  $tableParticipante  = $wpdb->prefix . 'super_express_participantes';

  $participanteSeleccionado = $wpdb->get_results("SELECT * FROM $tableParticipante WHERE id = $id");
  if (count($participanteSeleccionado) == 0) {
    $IsWinner = false;
  }
  $participanteSeleccionado = $participanteSeleccionado[0];
  // Si no se encuentra el participante, no puede ser ganador

  // Obtener todos los ganadores
  $ganadores = $wpdb->get_results("SELECT phone, cedula FROM $tableGanadores,  $tableParticipante WHERE $tableGanadores.id_participante = $tableParticipante.id");

  // Validar si el ganador ya ha sido seleccionado por teléfono o cédula
  foreach ($ganadores as $ganador) {

    if ($ganador->phone == $participanteSeleccionado->phone || $ganador->cedula == $participanteSeleccionado->cedula) {
      $IsWinner = false;
      break;
    }
  }

  return $IsWinner;
}

function getPremio()
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'super_express_premios';
  $premio = $wpdb->get_results("SELECT * FROM $table_name WHERE quantity > 0 ORDER BY orderP ASC  LIMIT 1");

  return $premio;
}


function getGanador()
{
  $listParticipantes = getParticipantes();
  $numParticipantes = count($listParticipantes);

  if ($numParticipantes === 0) {
    return null; // Manejar el caso de que no haya participantes
  }

  $maxAttempts = 10; // Número máximo de intentos para evitar bucle infinito
  $attempt = 0;

  while ($attempt < $maxAttempts) {
    $randomIndex = rand(0, $numParticipantes - 1);
    $idWinner = $listParticipantes[$randomIndex]->id;

    if (validateWinner($idWinner)) {
      global $wpdb;

      $tableParticipante  = $wpdb->prefix . 'super_express_participantes';
      $participanteSelecionado = $wpdb->get_results("SELECT * FROM $tableParticipante WHERE id = $idWinner");
      $participanteSelecionado = $participanteSelecionado[0];
      $arrGanador = [
        'id' => $participanteSelecionado->id,
        'name' => $participanteSelecionado->name,
        'phone' => $participanteSelecionado->phone,
        'cedula' => $participanteSelecionado->cedula,
        'factura' => $participanteSelecionado->factura,
        'factura_imagen' => $participanteSelecionado->factura_imagen,
        'premio' => getPremio()[0]
      ];

      return  $arrGanador; // Devolver el ganador encontrado
    }

    $attempt++;
  }

  return null; // Si no se encontró un ganador válido después de los intentos máximos
}
