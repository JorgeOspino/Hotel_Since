<?php
// --- MEJORA 1: SEGURIDAD Y CONEXIÓN ---
include('conexion.php');
session_start();

// Verificar si el administrador ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login_admin.php");
    exit();
}

$error = ''; // Variable para almacenar mensajes de error

// --- MEJORA 2: OBTENER LISTA DE HABITACIONES DINÁMICAMENTE ---
$habitaciones = [];
$sql_habitaciones = "SELECT numero FROM habitaciones WHERE estado = 'disponible' ORDER BY numero";
$resultado_habitaciones = $conn->query($sql_habitaciones);
if ($resultado_habitaciones) {
    while($row = $resultado_habitaciones->fetch_assoc()) {
        $habitaciones[] = $row;
    }
}

// --- PROCESAMIENTO DEL FORMULARIO ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre_completo = $_POST['nombre_completo'];
    $numero_identificacion = $_POST['numero_identificacion'];
    $telefono = $_POST['telefono'];
    $profesion = $_POST['profesion'];
    $numero_habitacion = (int)$_POST['numero_habitacion'];  
    $monto = (int)$_POST['monto'];

    // --- MEJORA 3: VALIDACIÓN DEL LADO DEL SERVIDOR ---
    if ($monto < 35000) {
        $error = "El monto debe ser de al menos 35,000 pesos.";
    } else {
        // Proceder con la inserción si no hay errores
        $sql = "INSERT INTO registro_cliente (nombre_completo, numero_identificacion, telefono, profesion, numero_habitacion, monto)
                VALUES (?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssii", $nombre_completo, $numero_identificacion, $telefono, $profesion, $numero_habitacion, $monto);
            
            if ($stmt->execute()) {
                echo "<script>alert('Cliente registrado correctamente.'); window.location.href='panel_admin.php';</script>";
                exit();
            } else {
                $error = "Error al registrar al cliente: " . htmlspecialchars($stmt->error);
            }
            $stmt->close();
        } else {
            $error = "Error al preparar la consulta: " . htmlspecialchars($conn->error);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registro de Cliente - Hotel San Luis de Sincé</title>
    <style>
        /* --- MEJORA 4: CSS REFINADO Y ROBUSTO --- */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 40px 20px;
        }

        .form-container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            color: #333;
            text-align: center;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input, select {
            box-sizing: border-box;
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        button, .btn-panel {
            box-sizing: border-box;
            display: block;
            width: 100%;
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        button {
            background-color: #2a9d8f;
            margin-bottom: 15px;
        }
        button:hover { background-color: #1f7f6c; }

        .btn-panel {
            background-color: #6c757d;
        }
        .btn-panel:hover { background-color: #5a6268; }

        .error {
            color: white;
            background-color: #e74c3c;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
    <script>
        function validarFormulario() {
            const monto = document.getElementById("monto").value;
            if (monto < 35000) {
                alert("El monto debe ser de al menos 35,000 pesos.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Registro de Cliente</h1>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="registro_cliente.php" onsubmit="return validarFormulario()">
            <label for="nombre_completo">Nombre Completo:</label>
            <input type="text" id="nombre_completo" name="nombre_completo" required />

            <label for="numero_identificacion">Número de Identificación:</label>
            <input type="text" id="numero_identificacion" name="numero_identificacion" required />

            <label for="telefono">Número de Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required />

            <label for="profesion">Profesión:</label>
            <input type="text" id="profesion" name="profesion" required />

            <label for="numero_habitacion">Número de Habitación:</label>
            <select id="numero_habitacion" name="numero_habitacion" required>
                <option value="">-- Seleccione una habitación disponible --</option>
                <?php foreach ($habitaciones as $habitacion): ?>
                    <option value="<?php echo htmlspecialchars($habitacion['numero']); ?>">
                        Habitación <?php echo htmlspecialchars($habitacion['numero']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="monto">Monto:</label>
            <input type="number" id="monto" name="monto" min="35000" required />

            <button type="submit">Guardar Cliente</button>
        </form>

        <a href="panel_admin.php" class="btn-panel">Volver al Panel</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>