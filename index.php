<?php  

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setCreator("Harrison Aguilar")->setTitle('prueba de excel');

$spreadsheet->setActiveSheetIndex(0);
$hojaActiva = $spreadsheet->getActiveSheet();

$spreadsheet->getDefaultStyle()->getFont()->setName('Tahoma');
$spreadsheet->getDefaultStyle()->getFont()->setSize(14);

$hojaActiva->getColumnDimension('A')->setWidth(40);
$hojaActiva->getColumnDimension('B')->setWidth(20);


$hojaActiva->setCellValue('A1','CODIGOS DE PROGRAMACION');
$hojaActiva->setCellValue('B1',200362);

$hojaActiva->setCellValue('C1', 'Marco Robles')->setCellValue('D1','CDP');


// redirect output to client browser
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="myfile.xls"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xls');
$writer->save('php://output');

/*
$writer = new Xlsx($spreadsheet);
$writer->save('nuevo prueba.xlsx');
*/


?>