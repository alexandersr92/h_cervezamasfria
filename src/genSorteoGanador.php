


<?php
require get_template_directory() . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\File;




$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$tableWinners = [];
global $wpdb;

$tableSorteos = $wpdb->prefix . 'super_express_sorteos';

$tableParticipantes = $wpdb->prefix . 'super_express_participantes';
$tableGanadores = $wpdb->prefix . 'super_express_ganadores';
$tablePremios = $wpdb->prefix . 'super_express_premios';
$sorteos = $wpdb->get_results("SELECT winners FROM $tableSorteos WHERE id = $idSorteo");
$winnersList = explode(',', $sorteos[0]->winners);


if ($winnersList[0] !== '') {
  foreach ($winnersList as $item) {

    $winDB = $wpdb->get_results("SELECT 
    $tableParticipantes.name as nombre, 
    $tableParticipantes.cedula,
    $tableParticipantes.phone, 
    $tablePremios.name as premio,
    $tableGanadores.time as timeWinner
      FROM 
      $tablePremios, 
      $tableParticipantes, 
      $tableGanadores  
      WHERE 
      $tableGanadores .id_premio = $tablePremios.id AND
      $tableParticipantes.id = $tableGanadores .id_participante AND
      $tableParticipantes.id =  $item");

    if (count($winDB) > 0) {

      $winDB = $winDB[0];
    }

    array_push($tableWinners, $winDB);
  }
}


$sheet->setCellValue('A1', 'Nombre Completo');
$sheet->setCellValue('B1', 'Telefono');
$sheet->setCellValue('C1', 'Cedula');
$sheet->setCellValue('D1', 'Premio');
$sheet->setCellValue('E1', 'Hora y Fecha');



$index = 2;

foreach ($tableWinners as $row) {

  $sheet->setCellValue('A' . $index, $row->nombre);
  $sheet->setCellValue('B' . $index, $row->phone);
  $sheet->setCellValue('C' . $index, $row->cedula);
  $sheet->setCellValue('D' . $index, $row->premio);
  $sheet->setCellValue('E' . $index, $row->timeWinner);

  $index++;
}

$writer = new Xlsx($spreadsheet);


$writer->save('SorteoPremio.xlsx');




//move to the root folder
if (!file_exists(get_template_directory() . '/reports')) {
  mkdir(get_template_directory() . '/reports', 0777, true);
}
if (file_exists(get_template_directory() . '/reports/SorteoPremio.xlsx')) {
  unlink(get_template_directory() . '/reports/SorteoPremio.xlsx');
}

rename('SorteoPremio.xlsx', get_template_directory() . '/reports/SorteoPremio.xlsx');

//comprove is the file is created
if (file_exists(get_template_directory() . '/reports/SorteoPremio.xlsx')) {
  $report_url = get_template_directory_uri() . '/reports/SorteoPremio.xlsx';
}
