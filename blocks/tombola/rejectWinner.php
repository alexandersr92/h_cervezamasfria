<?php

function rejectWinner($idWinner)
{
  global $wpdb;
  $table  = $wpdb->prefix . 'super_express_participantes';
  $wpdb->update(
    $table,
    array(
      'status' => 'Rechazado'
    ),
    array('id' => $idWinner)
  );
}
