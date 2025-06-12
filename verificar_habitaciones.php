<?php
// Este script busca y devuelve las habitaciones disponibles para un rango de fechas.
include('conexion.php');
header('Content-Type: application/json'); // Indicamos que la respuesta será en formato JSON

// Obtener las fechas enviadas desde JavaScript
$fecha_entrada = $_POST['fecha_entrada'] ?? null;
$fecha_salida = $_POST['fecha_salida'] ?? null;

if (!$fecha_entrada || !$fecha_salida) {
    echo json_encode([]); // Si no hay fechas, devuelve un array vacío
    exit();
}

// La consulta SQL para encontrar habitaciones que NO están reservadas en el rango de fechas.
// Una habitación está ocupada si su reserva se cruza con el nuevo rango de fechas.
// La condición de cruce es: (EntradaExistente < NuevaSalida) Y (SalidaExistente > NuevaEntrada)
$sql = "SELECT numero, descripcion 
        FROM habitaciones 
        WHERE numero NOT IN (
            SELECT habitacion_reservada 
            FROM reservas 
            WHERE fecha_entrada < ? AND fecha_salida > ?
        )
        ORDER BY numero ASC";

if ($stmt = $conn->prepare($sql)) {
    // Vincular las fechas de la nueva reserva a la consulta
    $stmt->bind_param("ss", $fecha_salida, $fecha_entrada);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $habitaciones_disponibles = [];
    while ($row = $resultado->fetch_assoc()) {
        $habitaciones_disponibles[] = $row;
    }
    
    echo json_encode($habitaciones_disponibles); // Devolver la lista como JSON
    
    $stmt->close();
} else {
    // En caso de error en la consulta
    echo json_encode(['error' => 'Error al preparar la consulta.']);
}

$conn->close();
?>