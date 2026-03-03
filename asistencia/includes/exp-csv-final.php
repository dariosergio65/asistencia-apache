<?php
/**
 * EXPORTAR CSV - VERSIÓN FINAL CORREGIDA
 * @param mysqli $conn Conexión MySQLi
 * @param string $sql Consulta SQL
 * @param string $nombre_base Nombre base del archivo
 */
function exportarCSV_FINAL($conn, $sql, $nombre_base = 'reporte') {
    // ========== PASO 1: NADA DE OUTPUT ANTES ==========
    // No echo, no print, no espacios, nada
    
    // ========== PASO 2: HEADERS PRIMERO ==========
    // ¡Esto debe ir ANTES de cualquier output!
    $nombre_archivo = $nombre_base . '-' . date('d-m-Y') . '.csv';
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // ========== PASO 3: BOM UTF-8 ==========
    echo "\xEF\xBB\xBF";
    
    // ========== PASO 4: SEP=; PARA EXCEL ARGENTINO ==========
    echo "sep=;\n";
    
    // ========== PASO 5: EJECUTAR CONSULTA ==========
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        // Si hay error, salir limpio
        exit;
    }
    
    // ========== PASO 6: ENCABEZADOS ==========
    $fields = mysqli_fetch_fields($result);
    $first = true;
    foreach ($fields as $field) {
        if (!$first) echo ';';
        echo '"' . str_replace('"', '""', $field->name) . '"';
        $first = false;
    }
    echo "\n";
    
    // ========== PASO 7: DATOS ==========
    while ($row = mysqli_fetch_assoc($result)) {
        $first = true;
        foreach ($row as $value) {
            if (!$first) echo ';';
            $value = $value ?? ''; // Convertir NULL a string vacío
            echo '"' . str_replace('"', '""', $value) . '"';
            $first = false;
        }
        echo "\n";
    }
    
    // ========== PASO 8: LIMPIAR Y SALIR ==========
    mysqli_free_result($result);
    exit;
}
?>