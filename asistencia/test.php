<?php
require_once __DIR__ . '/includes/funciones.php';

if (function_exists('useracceso')) {
    echo "✅ useracceso() SÍ existe";
} else {
    echo "❌ useracceso() NO existe";
}