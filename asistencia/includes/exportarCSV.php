<?php
/**
 * EXPORTAR A CSV/EXCEL - FUNCIÓN COMPLETA
 * @param mysqli $conn Conexión MySQLi
 * @param string $sql Consulta SQL
 * @param string $nombre_base Nombre base del archivo (sin extensión)
 * @param array $opciones Configuraciones adicionales
 * @return void Descarga el archivo directamente
 */
function exportarCSV($conn, $sql, $nombre_base = 'reporte', $opciones = []) {
    // ================= CONFIGURACIÓN POR DEFECTO =================
    $defaults = [
        'delimitador' => ';',           // Para Argentina/España
        'incluir_bom' => true,          // BOM UTF-8
        'incluir_sep' => true,          // línea "sep=;" para Excel
        'formato_fecha' => 'd-m-Y',     // Formato fecha en nombre
        'escapar_valores' => true,      // Escapar comillas y delimitadores
        'charset' => 'utf-8',           // Encoding
        'limpiar_buffers' => true,      // Limpiar buffers de salida
        'verificar_conexion' => true,   // Verificar conexión activa
        'max_filas' => null,            // Límite de filas (null = sin límite)
    ];
    
    // Fusionar opciones
    $config = array_merge($defaults, $opciones);
    
    // ================= VALIDACIONES =================
    if ($config['verificar_conexion'] && !$conn) {
        throw new Exception("Conexión a BD no válida");
    }
    
    if (empty($sql)) {
        throw new Exception("Consulta SQL vacía");
    }
    
    // ================= LIMPIAR BUFFERS =================
    if ($config['limpiar_buffers']) {
        while (ob_get_level()) {
            ob_end_clean();
        }
    }
    
    // ================= EJECUTAR CONSULTA =================
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        throw new Exception("Error en consulta SQL: " . mysqli_error($conn));
    }
    
    // ================= GENERAR NOMBRE ARCHIVO =================
    $fecha = date($config['formato_fecha']);
    $nombre_archivo = $nombre_base . '-' . $fecha . '.csv';
    
    // Sanitizar nombre de archivo
    $nombre_archivo = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $nombre_archivo);
    
    // ================= ENVIAR HEADERS =================
    header('Content-Type: text/csv; charset=' . $config['charset']);
    header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    
    // ================= GENERAR CSV =================
    $output = fopen('php://output', 'w');
    
    // BOM UTF-8 (opcional)
    if ($config['incluir_bom']) {
        fputs($output, "\xEF\xBB\xBF");
    }
    
    // Línea "sep=;" para Excel (opcional)
    if ($config['incluir_sep']) {
        fputs($output, "sep=" . $config['delimitador'] . "\n");
    }
    
    // ================= ENCABEZADOS =================
    $fields = mysqli_fetch_fields($result);
    $headers = [];
    
    foreach ($fields as $field) {
        $headers[] = $field->name;
    }
    
    fputcsv($output, $headers, $config['delimitador']);
    
    // ================= DATOS =================
    $contador_filas = 0;
    
    while ($fila = mysqli_fetch_assoc($result)) {
        // Limitar filas si se especificó
        if ($config['max_filas'] !== null && $contador_filas >= $config['max_filas']) {
            break;
        }
        
        // Procesar valores si es necesario
        if ($config['escapar_valores']) {
            $fila_procesada = [];
            
            foreach ($fila as $clave => $valor) {
                // Convertir NULL a string vacío
                if ($valor === null) {
                    $valor = '';
                }
                
                // Si es string y contiene delimitador o comillas, escapar
                if (is_string($valor)) {
                    if (strpos($valor, $config['delimitador']) !== false || 
                        strpos($valor, '"') !== false ||
                        strpos($valor, "\n") !== false ||
                        strpos($valor, "\r") !== false) {
                        $valor = '"' . str_replace('"', '""', $valor) . '"';
                    }
                }
                
                $fila_procesada[$clave] = $valor;
            }
            
            fputcsv($output, $fila_procesada, $config['delimitador']);
        } else {
            // Sin procesamiento especial
            fputcsv($output, $fila, $config['delimitador']);
        }
        
        $contador_filas++;
        
        // Liberar memoria cada 100 filas (para datasets grandes)
        if ($contador_filas % 100 === 0) {
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }
        }
    }
    
    // ================= LIMPIAR =================
    fclose($output);
    mysqli_free_result($result);
    
    // Finalizar script
    exit;
}

// ================= FUNCIÓN AUXILIAR DE CONEXIÓN =================
/*
function conectarBD($host = 'localhost', $usuario = '', $password = '', $basedatos = '') {
    $conn = mysqli_connect($host, $usuario, $password, $basedatos);
    
    if (!$conn) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    
    mysqli_set_charset($conn, 'utf8mb4');
    return $conn;
}
*/
?>