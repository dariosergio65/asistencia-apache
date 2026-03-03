<?php
//require 'vendor/autoload.php'; // Necesitas instalar PHPSpreadsheet
$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/vendor/autoload.php';
require ($rutaf);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color; // ← AÑADIR ESTA LÍNEA
use PhpOffice\PhpSpreadsheet\Style\Border;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


function exportarExcelConNegritas($conn, $sql, $nombre_base = 'reporte') {
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        die("Error en consulta: " . mysqli_error($conn));
    }
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Fecha para nombre de archivo
    $fecha = date('d-m-Y');
    $nombre_archivo = $nombre_base . '-' . $fecha . '.xlsx';
    
    // 1. ENCABEZADOS CON ESTILO - VERSIÓN CORREGIDA
    $col = 1;
    $fields = mysqli_fetch_fields($result);
    
    // Crear objeto Color para el texto blanco
    $colorBlanco = new Color();
    $colorBlanco->setRGB('FFFFFF');

    $colorNegro = new Color();
    $colorNegro->setRGB('000000');

    
    // Color para fondo azul
    $colorAzul = new Color();
    $colorAzul->setRGB('4472C4');
    
    foreach ($fields as $field) {
        $columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
        
        // Valor de la celda
        $sheet->setCellValueByColumnAndRow($col, 1, $field->name);
        
        // APLICAR ESTILO - FORMA CORRECTA
        $style = $sheet->getStyle($columnaLetra . '1');
        
        // Fuente en negrita y blanca
        $style->getFont()
              ->setBold(true)
              ->setSize(11)
              ->setColor($colorNegro); // ← Usar objeto Color, NO array
        
        // Fondo azul
        $style->getFill()
              ->setFillType(Fill::FILL_SOLID)
              ->setStartColor($colorAzul); // ← Usar objeto Color
        
        // Alineación centrada
        $style->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER)
              ->setVertical(Alignment::VERTICAL_CENTER);
        
        $col++;
    }
    
    // 2. DATOS
    $row = 2;
    while ($data = mysqli_fetch_assoc($result)) {
        $col = 1;
        foreach ($data as $key => $value) {
            // Convertir NULL a string vacío
            if ($value === null) {
                $value = '';
            }

            if ($key === 'Fecha') {
            $dt = new DateTime($value);
            $excelDate = Date::PHPToExcel($dt);

            $sheet->setCellValueByColumnAndRow($col, $row, $excelDate);
            $sheet->getStyleByColumnAndRow($col, $row)
                  ->getNumberFormat()
                  ->setFormatCode('dd/mm/yyyy hh:mm:ss');
            } else {
                $sheet->setCellValueByColumnAndRow($col, $row, $value);
            }
            
            $col++;
        }
        $row++;
    }
    
    // 3. AUTO-AJUSTAR ANCHO DE COLUMNAS
    $ultimaColumna = $sheet->getHighestColumn();
    for ($col = 'A'; $col <= $ultimaColumna; $col++) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
    
    // 4. ALTURA FIJA PARA ENCABEZADOS
    $sheet->getRowDimension(1)->setRowHeight(25);
    
    // 5. BORDES PARA TODA LA TABLA (solo si hay datos)
    if ($row > 2) { // Si hay al menos una fila de datos
        $ultimaFila = $sheet->getHighestRow();
        $sheet->getStyle('A1:' . $ultimaColumna . $ultimaFila)
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);
    }
    
    // 6. CONGELAR ENCABEZADOS (opcional)
    $sheet->freezePane('A2');
    
    // 7. GUARDAR Y DESCARGAR
    $writer = new Xlsx($spreadsheet);
    
    // Limpiar buffers
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');
    header('Cache-Control: max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    $writer->save('php://output');
    
    mysqli_free_result($result);
    exit();
}

// USO:
//$conn = mysqli_connect("localhost", "root", "", "test");
//exportarExcelConNegritas($conn, "SELECT * FROM productos", "productos");
?>