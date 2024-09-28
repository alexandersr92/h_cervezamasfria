<?php
require get_template_directory() . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\File;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
global $wpdb;
$table_name_ganadores = $wpdb->prefix . 'super_express_ganadores';
$table_name_participantes = $wpdb->prefix . 'super_express_participantes';
$table_premios = $wpdb->prefix . 'super_express_premios';

$resultsGanadores = $wpdb->get_results("SELECT $table_name_participantes.name as name, phone, factura, cedula, email, $table_name_ganadores.time as timeWinner,   $table_premios.name as premio FROM  $table_name_ganadores, $table_name_participantes,   $table_premios WHERE  $table_name_participantes.id = $table_name_ganadores.id_participante  AND $table_premios.id = $table_name_ganadores.id_premio");


$sheet->setCellValue('A1', 'Nombre Completo');
$sheet->setCellValue('B1', 'Teléfono');
$sheet->setCellValue('C1', 'Factura');
$sheet->setCellValue('D1', 'Cedula');
$sheet->setCellValue('E1', 'Correo');
$sheet->setCellValue('F1', 'Premio');
$sheet->setCellValue('G1', 'Hora y Fecha');


$index = 2;
foreach ($resultsGanadores as $row) {
  $sheet->setCellValue('A' . $index, $row->name);
  $sheet->setCellValue('B' . $index, $row->phone);
  $sheet->setCellValue('C' . $index, $row->factura);
  $sheet->setCellValue('D' . $index, $row->cedula);
  $sheet->setCellValue('E' . $index, $row->email);
  $sheet->setCellValue('F' . $index, $row->premio);
  $sheet->setCellValue('G' . $index, $row->timeWinner);

  $index++;
}

$writer = new Xlsx($spreadsheet);


$writer->save('Ganadores.xlsx');




//move to the root folder
if (!file_exists(get_template_directory() . '/reports')) {
  mkdir(get_template_directory() . '/reports', 0777, true);
}
if (file_exists(get_template_directory() . '/reports/Ganadores.xlsx')) {
  unlink(get_template_directory() . '/reports/Ganadores.xlsx');
}

rename('Ganadores.xlsx', get_template_directory() . '/reports/Ganadores.xlsx');

//comprove is the file is created
if (file_exists(get_template_directory() . '/reports/Ganadores.xlsx')) {
  $report_url = get_template_directory_uri() . '/reports/Ganadores.xlsx';
}
