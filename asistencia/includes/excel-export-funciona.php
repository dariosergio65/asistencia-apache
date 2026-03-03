<?php
function exportToExcelUniversal($conn, $sql, $filename_base = 'reporte') {
    $result = mysqli_query($conn, $sql);

    // FORMATO DE FECHA: dd-mm-yyyy
    $fecha_actual = date('d-m-Y'); // Ejemplo: 16-01-2026
    
    // Nombre del archivo: "reporte-16-01-2026.csv"
    $filename = $filename_base . '-' . $fecha_actual . '.csv';
    
    // DETERMINAR DELIMITADOR SEGÚN REGIÓN
    // En Argentina/España: punto y coma (;)
    // En USA/UK: coma (,)
    $delimiter = ';'; // Para Argentina
    
    // LIMPIAR BUFFERS
    while (ob_get_level()) ob_end_clean();
    
    // HEADERS - Usar .csv en vez de .xls
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    // GENERAR CONTENIDO
    $output = fopen('php://output', 'w');
    fputs($output, "\xEF\xBB\xBF"); // BOM UTF-8
    
    // 1. ENCABEZADOS
    $fields = mysqli_fetch_fields($result);
    $headers = [];
    foreach ($fields as $field) {
        $headers[] = $field->name;
    }
    fputcsv($output, $headers, $delimiter);
    
    // 2. DATOS
    while ($row = mysqli_fetch_assoc($result)) {
        // Procesar cada valor para CSV
        $csv_row = [];
        foreach ($row as $value) {
            // Si contiene el delimitador, envolver en comillas
            if (is_string($value) && strpos($value, $delimiter) !== false) {
                $value = '"' . str_replace('"', '""', $value) . '"';
            }
            // Si contiene salto de línea, también envolver
            if (is_string($value) && (strpos($value, "\n") !== false || strpos($value, "\r") !== false)) {
                $value = '"' . str_replace('"', '""', $value) . '"';
            }
            $csv_row[] = $value;
        }
        fputcsv($output, $csv_row, $delimiter);
    }
    
    fclose($output);
    mysqli_free_result($result);
    exit();
}

// USO
//$conn = mysqli_connect("localhost", "root", "", "test");
//exportToExcelUniversal($conn, "SELECT * FROM productos", "productos");
?>