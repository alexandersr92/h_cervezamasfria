<?php
require get_template_directory() . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\File;



$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
global $wpdb;
$table_name = $wpdb->prefix . 'super_express_participantes';
$results = $wpdb->get_results("SELECT * FROM $table_name ");
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nombre Completo');
$sheet->setCellValue('C1', 'Telefono');
$sheet->setCellValue('D1', 'Correo');
$sheet->setCellValue('E1', 'Cedula');
$sheet->setCellValue('F1', 'Factura');
$sheet->setCellValue('G1', 'Premio');
$sheet->setCellValue('H1', 'Sorteo');

$index = 2;
foreach ($results as $row) {
  $sheet->setCellValue('A' . $index, $row->id);
  $sheet->setCellValue('B' . $index, $row->name);
  $sheet->setCellValue('C' . $index, $row->phone);
  $sheet->setCellValue('D' . $index, $row->email);
  $sheet->setCellValue('E' . $index, $row->cedula);
  $sheet->setCellValue('F' . $index, $row->factura);
  $sheet->setCellValue('G' . $index, $row->status);
  $sheet->setCellValue('H' . $index, $row->time);
  $index++;
}

$writer = new Xlsx($spreadsheet);


$writer->save('Participantes.xlsx');




//move to the root folder
if (!file_exists(get_template_directory() . '/reports')) {
  mkdir(get_template_directory() . '/reports', 0777, true);
}
if (file_exists(get_template_directory() . '/reports/Participantes.xlsx')) {
  unlink(get_template_directory() . '/reports/Participantes.xlsx');
}

rename('Participantes.xlsx', get_template_directory() . '/reports/Participantes.xlsx');

//comprove is the file is created
if (file_exists(get_template_directory() . '/reports/Participantes.xlsx')) {
  $report_url = get_template_directory_uri() . '/reports/Participantes.xlsx';
}
