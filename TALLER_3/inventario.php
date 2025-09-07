<?php


define('INVENTARIO_JSON', 'inventario.json');
define('STOCK_BAJO', 5);

// ---------------------------
//  Funciones del sistema
// ---------------------------

/**
 * Lee el inventario desde el archivo JSON y lo decodifica.
 *
 * @return array El array de productos o un array vacío si hay un error.
 */
function leerInventario(): array
{
    
    $inventario_json = file_get_contents(INVENTARIO_JSON);
    return json_decode($inventario_json, true) ?? [];
}

// Ordena el inventario alfabéticamente por el nombre del producto.

function ordenarInventario(array $inventario): array
{
    usort($inventario, function ($a, $b) {
        return strcmp($a['nombre'], $b['nombre']);
    });
    return $inventario;
}

/**
 * Muestra un resumen del inventario en formato de tabla.
 *
 * @param array $inventario El array de productos a mostrar.
 */
function mostrarResumen(array $inventario): void
{
    if (empty($inventario)) {
        echo "El inventario está vacío.</br>";
        return;
    }

    echo "--- Resumen del Inventario ---</br>";
    printf("%-20s %-10s %-10s</br>", 'Producto', 'Precio', 'Cantidad');
    echo str_repeat('-', 40) . "</br>";

    foreach ($inventario as $producto) {
        printf(
            "%-20s $%-9.2f %-10d</br>",
            $producto['nombre'],
            $producto['precio'],
            $producto['cantidad']
        );
    }
    echo str_repeat('-', 40) . "</br>";
}

/**
 * Calcula el valor total del inventario.
 *
 * @param array $inventario El array de productos.
 * @return float El valor total del inventario.
 */
function calcularValorTotal(array $inventario): float
{
    $valores_por_producto = array_map(function ($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $inventario);

    return array_sum($valores_por_producto);
}

/**
 * Genera un informe de productos con stock bajo.
 *
 * @param array $inventario El array de productos a filtrar.
 * @return array Un array de productos con stock bajo.
 */
function generarInformeStockBajo(array $inventario): array
{
    return array_filter($inventario, function ($producto) {
        return $producto['cantidad'] < STOCK_BAJO;
    });
}

// ---------------------------
//  Script principal
// ---------------------------

// 1. Leer y decodificar el inventario
$inventario = leerInventario();

if (!empty($inventario)) {
    // 2. Ordenar el inventario alfabéticamente
    $inventario_ordenado = ordenarInventario($inventario);
    
    // 3. Mostrar el resumen del inventario
    mostrarResumen($inventario_ordenado);

    // 4. Calcular y mostrar el valor total del inventario
    $valor_total = calcularValorTotal($inventario);
    echo "Valor total del inventario: $" . number_format($valor_total, 2) . "</br>";

    // 5. Generar y mostrar el informe de stock bajo
    $stock_bajo = generarInformeStockBajo($inventario_ordenado);
    if (!empty($stock_bajo)) {
        echo "--- Informe de Productos con Stock Bajo ---</br>";
        mostrarResumen($stock_bajo);
    } else {
        echo "No hay productos con stock bajo (< " . STOCK_BAJO . " unidades).</br>";
    }
}


?>

