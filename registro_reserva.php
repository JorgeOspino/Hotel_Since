<?php
include('conexion.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login_admin.php");
    exit();
}

$error = '';
$clientes = [];
$sql_clientes = "SELECT id, nombre_completo, numero_identificacion FROM registro_cliente ORDER BY nombre_completo";
$resultado_clientes = $conn->query($sql_clientes);
if ($resultado_clientes && $resultado_clientes->num_rows > 0) {
    while($row = $resultado_clientes->fetch_assoc()) {
        $clientes[] = $row;
    }
}
// Ya no cargamos las habitaciones aquí, se hará con JavaScript

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];
    $cliente_id = $_POST['cliente_id'];
    $habitacion_reservada = $_POST['habitacion_reservada'];

    // Aquí podrías añadir una validación final del lado del servidor para asegurar que la habitación
    // no fue reservada por alguien más mientras el formulario estaba abierto.
    
    $sql = "INSERT INTO reservas (fecha_entrada, fecha_salida, cliente_id, habitacion_reservada) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssii", $fecha_entrada, $fecha_salida, $cliente_id, $habitacion_reservada);
        if ($stmt->execute()) {
            echo "<script>alert('¡Reserva registrada con éxito!'); window.location.href='panel_admin.php';</script>";
            exit();
        } else {
            $error = "Error al registrar la reserva: " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    } else {
        $error = "Error al preparar la consulta: " . htmlspecialchars($conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registro de Reserva Inteligente - Hotel San Luis</title>
    <style>
        /* (Tu CSS existente va aquí - sin cambios) */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; margin: 0; padding: 40px 20px; }
        .form-container { background-color: white; padding: 30px 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 800px; margin: 0 auto; }
        .form-row { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 15px; }
        .form-group { flex: 1; min-width: 250px; }
        h1 { font-size: 1.8rem; margin-bottom: 25px; color: #333; text-align: center; }
        label { display: block; text-align: left; margin-bottom: 5px; font-weight: bold; color: #555; }
        input, select { box-sizing: border-box; width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #ccc; font-size: 1rem; }
        button, .btn-panel { box-sizing: border-box; width: 100%; padding: 12px 20px; border-radius: 25px; border: none; cursor: pointer; font-size: 1.1rem; text-align: center; color: white; text-decoration: none; display: block; transition: background-color 0.3s; }
        button { background-color: #2a9d8f; margin-bottom: 15px; }
        button:hover { background-color: #1f7f6c; }
        .btn-panel { background-color: #6c757d; }
        .btn-panel:hover { background-color: #5a6268; }
        .error { color: red; font-size: 0.9rem; text-align: center; margin-bottom: 15px; }
        select:disabled { background-color: #e9ecef; cursor: not-allowed; }
    </style>
</head>
<body>
    
    <div class="form-container">
        <h1>Registro de Reserva Inteligente</h1>
        
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="registro_reserva.php" onsubmit="return validarFormulario()">
            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_entrada">Fecha de Entrada:</label>
                    <input type="date" id="fecha_entrada" name="fecha_entrada" required value="<?php echo date('Y-m-d'); ?>" />
                </div>
                <div class="form-group">
                    <label for="fecha_salida">Fecha de Salida:</label>
                    <input type="date" id="fecha_salida" name="fecha_salida" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" />
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="cliente_id">Cliente:</label>
                    <select id="cliente_id" name="cliente_id" required>
                        <option value="">-- Seleccione un cliente --</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo htmlspecialchars($cliente['id']); ?>">
                                <?php echo htmlspecialchars($cliente['nombre_completo']) . ' (C.C. ' . htmlspecialchars($cliente['numero_identificacion']) . ')'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="habitacion_reservada">Habitación Disponible:</label>
                    <select id="habitacion_reservada" name="habitacion_reservada" required disabled>
                        <option value="">-- Primero seleccione las fechas --</option>
                    </select>
                </div>
            </div>

            <button type="submit">Guardar Reserva</button>
            <a href="panel_admin.php" class="btn-panel">Volver al Panel</a>
        </form>
    </div>

    <script>
        // --- NUEVO SCRIPT PARA CARGAR HABITACIONES DINÁMICAMENTE ---
        document.addEventListener('DOMContentLoaded', function() {
            const fechaEntradaEl = document.getElementById('fecha_entrada');
            const fechaSalidaEl = document.getElementById('fecha_salida');
            const habitacionSelectEl = document.getElementById('habitacion_reservada');

            // Función para cargar las habitaciones disponibles
            function cargarHabitacionesDisponibles() {
                const fechaEntrada = fechaEntradaEl.value;
                const fechaSalida = fechaSalidaEl.value;

                // Validar que ambas fechas estén seleccionadas y que la de salida sea mayor
                if (fechaEntrada && fechaSalida && fechaSalida > fechaEntrada) {
                    habitacionSelectEl.disabled = true;
                    habitacionSelectEl.innerHTML = '<option>Buscando habitaciones...</option>';

                    // Crear los datos para enviar
                    const formData = new FormData();
                    formData.append('fecha_entrada', fechaEntrada);
                    formData.append('fecha_salida', fechaSalida);
                    
                    // Petición AJAX con fetch al nuevo script
                    fetch('verificar_habitaciones.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        habitacionSelectEl.innerHTML = ''; // Limpiar opciones anteriores
                        if (data.length > 0) {
                            habitacionSelectEl.disabled = false;
                            habitacionSelectEl.innerHTML += '<option value="">-- Seleccione una habitación --</option>';
                            data.forEach(habitacion => {
                                const option = document.createElement('option');
                                option.value = habitacion.numero;
                                option.textContent = `Hab. ${habitacion.numero} - ${habitacion.descripcion}`;
                                habitacionSelectEl.appendChild(option);
                            });
                        } else {
                            habitacionSelectEl.innerHTML = '<option value="">No hay habitaciones disponibles</option>';
                            habitacionSelectEl.disabled = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        habitacionSelectEl.innerHTML = '<option value="">Error al cargar habitaciones</option>';
                    });
                } else {
                    // Si las fechas no son válidas, deshabilitar y resetear el select
                    habitacionSelectEl.innerHTML = '<option value="">-- Primero seleccione las fechas --</option>';
                    habitacionSelectEl.disabled = true;
                }
            }
            
            // Añadir los 'event listeners' a los campos de fecha
            fechaEntradaEl.addEventListener('change', cargarHabitacionesDisponibles);
            fechaSalidaEl.addEventListener('change', cargarHabitacionesDisponibles);

            // Cargar las habitaciones al cargar la página por primera vez con las fechas por defecto
            cargarHabitacionesDisponibles();
        });

        // Tu función de validación del formulario se mantiene
        function validarFormulario() {
            const fechaEntrada = document.getElementById("fecha_entrada").value;
            const fechaSalida = document.getElementById("fecha_salida").value;
            const habitacion = document.getElementById("habitacion_reservada").value;

            if (fechaEntrada && fechaSalida && fechaSalida <= fechaEntrada) {
                alert("La fecha de salida debe ser mayor que la fecha de entrada.");
                return false;
            }
            if (!habitacion) {
                alert("Debe seleccionar una habitación disponible.");
                return false;
            }
            return true;
        }
    </script>

</body>
</html>
<?php
$conn->close();
?>