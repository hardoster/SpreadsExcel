<?php

require 'vendor/autoload.php';
require 'conexion.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$Placa = $mysqli->real_escape_string($_POST['Placa']);
$trabajo = $mysqli->real_escape_string($_POST['trabajo']);

$sql = "SELECT 
tb_mr_records.id_mr_records as 'Numerotrabajo', 
tb_mr_disposition.mr_dispositionName AS 'Trabajorealizado', 
tb_mr_categorydisposition.mr_CategoryDisposition_name AS 'Disposicion', 
tbvehiculos.placa AS 'placa', 
tbclientes.nombre_cuenta AS 'Cuenta', 
tb_mr_records.date_add AS 'Fecha',
tb_mr_records.TecCode AS 'Codigo', 
tb_mr_notes.usuario as 'Operador', 
tb_mr_notes.mr_note as 'Seguimientos'
FROM 
tb_mr_records
INNER JOIN 
tb_mr_disposition ON tb_mr_records.id_mr_disposition = tb_mr_disposition.id_mr_disposition
INNER JOIN 
tb_mr_categorydisposition ON tb_mr_disposition.id_mr_categoryDisposition = tb_mr_categorydisposition.id_mr_categoryDisposition
INNER JOIN 
tbvehiculos ON tb_mr_records.id_vehiculo = tbvehiculos.id_vehiculo
INNER JOIN 
tbclientes ON tb_mr_records.id_cliente = tbclientes.id_cliente
INNER JOIN 
tb_mr_notes ON tb_mr_records.id_mr_records = tb_mr_notes.id_mr_records
WHERE 
tbvehiculos.placa = '$Placa' 
AND tb_mr_categorydisposition.id_mr_categoryDisposition = '$trabajo'
GROUP BY 
tb_mr_records.id_mr_records, 
tb_mr_disposition.mr_dispositionName, 
tb_mr_categorydisposition.mr_CategoryDisposition_name, 
tbvehiculos.placa, 
tbclientes.nombre_cuenta, 
tb_mr_records.date_add, 
tb_mr_records.TecCode, 
tb_mr_notes.usuario, 
tb_mr_notes.mr_note;
";

$resultado = $mysqli->query($sql);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle('Reporte de trabajos realizados');

$hojaActiva->getColumnDimension('A')->setWidth(8);
$hojaActiva->setCellValue('A1','Registro');

$hojaActiva->getColumnDimension('B')->setWidth(25);
$hojaActiva->setCellValue('B1','Trabajo Realizado');

$hojaActiva->getColumnDimension('C')->setWidth(11);
$hojaActiva->setCellValue('C1','Disposicion');

$hojaActiva->getColumnDimension('D')->setWidth(10);
$hojaActiva->setCellValue('D1','Placa');

$hojaActiva->getColumnDimension('E')->setWidth(18);
$hojaActiva->setCellValue('E1','Cuenta');

$hojaActiva->getColumnDimension('F')->setWidth(23);
$hojaActiva->setCellValue('F1','Fecha');

$hojaActiva->getColumnDimension('G')->setWidth(27);
$hojaActiva->setCellValue('G1','Codigo');

$hojaActiva->getColumnDimension('H')->setWidth(9);
$hojaActiva->setCellValue('H1','Operador');

$hojaActiva->getColumnDimension('I')->setWidth(100);
$hojaActiva->setCellValue('I1','Seguimientos');

$fila = 2;

while ($rows = $resultado->fetch_assoc()){
    $hojaActiva->setCellValue('A'.$fila, $rows['Numerotrabajo']);
    $hojaActiva->setCellValue('B'.$fila, $rows['Trabajorealizado']);
    $hojaActiva->setCellValue('C'.$fila, $rows['Disposicion']);
    $hojaActiva->setCellValue('D'.$fila, $rows['placa']);
    $hojaActiva->setCellValue('E'.$fila, $rows['Cuenta']);
    $hojaActiva->setCellValue('F'.$fila, $rows['Fecha']);
    $hojaActiva->setCellValue('G'.$fila, $rows['Codigo']);
    $hojaActiva->setCellValue('H'.$fila, $rows['Operador']);
    $hojaActiva->setCellValue('I'.$fila, $rows['Seguimientos']);

    $fila++;

}

// redirect output to client browser
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="myfile.xls"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($excel, 'Xlsx');
$writer->save('php://output');
exit;
?>