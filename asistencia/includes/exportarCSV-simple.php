<?php
// funcion_csv_segura.php
/**
 * Exportar datos a CSV/Excel - Versión simple
 */
//function exportarACSV($conn, $sql, $nombre_archivo = 'reporte') {

function exportarACSV($conn, $sql, $nombre = 'reporte') {
    // PASO 1: APAGAR todo output posible
    if (ob_get_length() > 0) {
        ob_clean();
    }
    
    // PASO 2: Ejecutar consulta
    $result = mysqli_query($conn, $sql);
    if (!$result) die("Error SQL");
    
    // PASO 3: Headers PRIMERO (nada antes de esto)
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $nombre . '.csv"');
    
    // PASO 4: Output directo (sin buffering complejo)
    echo "\xEF\xBB\xBF"; // BOM UTF-8
    echo "sep=;\n";      // Para Excel
    
    // Encabezados
    $fields = mysqli_fetch_fields($result);
    $first = true;
    foreach ($fields as $field) {
        if (!$first) echo ';';
        echo '"' . str_replace('"', '""', $field->name) . '"';
        $first = false;
    }
    echo "\n";
    
    // Datos
    while ($row = mysqli_fetch_assoc($result)) {
        $first = true;
        foreach ($row as $value) {
            if (!$first) echo ';';
            echo '"' . str_replace('"', '""', $value ?? '') . '"';
            $first = false;
        }
        echo "\n";
    }
    
    // Salir
    exit;
}
?>