<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Diagnóstico de conexión MySQL</h2>";

// TUS DATOS DE INFINITYFREE - REEMPLAZALOS
$host = 'sql201.infinityfree.com';  // El que aparece en tu panel
$user = 'if0_41297716';
$pass = 'Tempra876';
$db   = 'if0_41297716_asis';

echo "<h3>Intentando conectar con:</h3>";
echo "<ul>";
echo "<li>Host: $host</li>";
echo "<li>Usuario: $user</li>";
echo "<li>Base de datos: $db</li>";
echo "</ul>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green'>✅ ¡Conexión exitosa!</p>";
    
    // Probar una consulta simple
    $stmt = $pdo->query("SELECT 1");
    echo "<p style='color:green'>✅ Consulta de prueba exitosa</p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
    
    // Ayuda adicional según el error
    if (strpos($e->getMessage(), 'No such file or directory')) {
        echo "<p style='color:orange'>🔍 El host '$host' no es correcto. Verificá en tu panel de InfinityFree el host exacto.</p>";
    } elseif (strpos($e->getMessage(), 'Access denied')) {
        echo "<p style='color:orange'>🔍 Usuario o contraseña incorrectos.</p>";
    } elseif (strpos($e->getMessage(), 'Unknown database')) {
        echo "<p style='color:orange'>🔍 La base de datos '$db' no existe.</p>";
    }
}
?>