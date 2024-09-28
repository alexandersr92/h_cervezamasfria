<?php


function addWinner($id, $idSorteo, $idPremio)
{
  global $wpdb;
  $table_ganadores = $wpdb->prefix . 'super_express_ganadores';
  $table_participantes = $wpdb->prefix . 'super_express_participantes';
  $table_premios = $wpdb->prefix . 'super_express_premios';
  $table_sorteos = $wpdb->prefix . 'super_express_sorteos';

  //get winner data
  $participanteSeleccionado = $wpdb->get_results("SELECT * FROM $table_participantes WHERE id = $id");
  $participanteSeleccionado = $participanteSeleccionado[0];
  $phone = $participanteSeleccionado->phone;
  $cedula = $participanteSeleccionado->cedula;

  //save winner in ganadores table
  //comprobar si ya existe un ganador con el mismo id
  $ganador = $wpdb->get_results("SELECT * FROM $table_ganadores WHERE id_participante = $id");
  if (count($ganador) == 0) {



    $wpdb->insert(
      $table_ganadores,
      array(
        'time' => current_time('mysql', false),
        'id_participante' => $id,
        'id_premio' => $idPremio,
        'id_sorteo' => $idSorteo
      )
    );


    //update premio quantity
    $premio = $wpdb->get_results("SELECT * FROM $table_premios WHERE id = $idPremio");
    $premio = $premio[0];
    if ($premio->quantity !== 0) {
      $quantity = $premio->quantity - 1;
      $wpdb->update(
        $table_premios,
        array(
          'quantity' => $quantity
        ),
        array('id' => $idPremio)
      );
    }
  }

  //update participante status

  //update all participantes when phone or cedula is the same to the winner
  $wpdb->update(
    $table_participantes,
    array(
      'status' => 'Ganador'
    ),
    array('phone' => $phone,)
  );

  $wpdb->update(
    $table_participantes,
    array(
      'status' => 'Ganador'
    ),
    array('cedula' => $cedula)
  );
  $wpdb->update(
    $table_participantes,
    array(
      'status' => 'Ganador'
    ),
    array('id' => $id)
  );



  //insert winner in sorteos table just id first get previus winner and the add new winner to the list
  $sorteo = $wpdb->get_results("SELECT * FROM $table_sorteos WHERE id = $idSorteo");
  $sorteo = $sorteo[0];

  $winners = $sorteo->winners;
  if ($winners == null) {
    $winners = $id;
  } else {
    if (strpos($winners, $id) === false) {
      $winners = $winners . ',' . $id;
    }
  }

  $wpdb->update(
    $table_sorteos,
    array(
      'winners' => $winners
    ),
    array('id' => $idSorteo)
  );
}
