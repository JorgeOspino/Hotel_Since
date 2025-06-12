<?php
// Incluir la conexión y verificar la sesión del administrador
include('conexion.php');
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login_admin.php");
    exit();
}

// Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha'];
    $cliente_nombre = $_POST['cliente_nombre'];
    $cliente_documento = $_POST['cliente_documento'];
    $direccion_cliente = $_POST['direccion_cliente'];
    $telefono_cliente = $_POST['telefono_cliente'];
    $cantidad = $_POST['cantidad'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $valor_unitario = $_POST['valor_unitario'];
    $valor_total = $_POST['valor_total'];
    $recibo_conforme = isset($_POST['recibo_conforme']) ? 1 : 0;  

    $sql = "INSERT INTO factura_venta (fecha, cliente_nombre, cliente_documento, direccion_cliente, telefono_cliente, cantidad, descripcion_producto, valor_unitario, valor_total, recibo_conforme)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        // El tipo para cliente_documento debe ser string 's' si puede contener letras o empezar con cero
        $stmt->bind_param("ssssisdddi", $fecha, $cliente_nombre, $cliente_documento, $direccion_cliente, $telefono_cliente, $cantidad, $descripcion_producto, $valor_unitario, $valor_total, $recibo_conforme);
        
        if ($stmt->execute()) {
            echo "<script>alert('¡Factura registrada con éxito!'); window.location.href='registro_factura.php';</script>";
            exit();
        } else {
            echo "<p class='error'>Error al registrar la factura. Error: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p class='error'>Error al preparar la consulta: " . htmlspecialchars($conn->error) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registro de Factura - Hotel San Luis de Sincé</title>
    <style>
        /* --- INICIO DE CAMBIOS PRINCIPALES --- */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 40px 20px; /* Añade espacio arriba/abajo y a los lados */
        }

        .form-container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px; /* Ancho máximo para el formulario */
            margin: 0 auto; /* Centra el contenedor */
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Espacio entre las columnas */
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1; /* Hace que cada grupo ocupe el mismo espacio */
            min-width: 250px; /* Ancho mínimo para cada campo antes de que se apilen */
        }
        /* --- FIN DE CAMBIOS PRINCIPALES --- */

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

        input[type="text"], input[type="number"], input[type="tel"], input[type="date"], textarea {
            box-sizing: border-box;
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            text-align: left;
            margin-bottom: 20px;
        }

        .checkbox-group input {
            margin-right: 10px;
        }

        button, .btn-panel {
            box-sizing: border-box;
            width: 100%;
            padding: 12px 20px;
            border-radius: 25px;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            text-align: center;
            color: white;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }

        button {
            background-color: #2a9d8f;
            margin-bottom: 15px;
        }
        button:hover { background-color: #1f7f6c; }

        .btn-panel { background-color: #6c757d; }
        .btn-panel:hover { background-color: #5a6268; }

        .error { color: red; font-size: 0.9rem; text-align: center; }
    </style>
</head>
<body>
    
    <div class="form-container">
        <h1>Registro de Factura de Venta</h1>
        <form method="POST" action="registro_factura.php">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" required value="<?php echo date('Y-m-d'); ?>" />
                </div>
                <div class="form-group">
                    <label for="cliente_nombre">Nombre del Cliente:</label>
                    <input type="text" id="cliente_nombre" name="cliente_nombre" required />
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="cliente_documento">Número de Identificación (C.C./NIT):</label>
                    <input type="text" id="cliente_documento" name="cliente_documento" required />
                </div>
                <div class="form-group">
                    <label for="direccion_cliente">Dirección del Cliente:</label>
                    <input type="text" id="direccion_cliente" name="direccion_cliente" required />
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="telefono_cliente">Teléfono del Cliente:</label>
                    <input type="tel" id="telefono_cliente" name="telefono_cliente" required />
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" required />
                </div>
            </div>
            
            <div class="form-group">
                <label for="descripcion_producto">Descripción del Producto/Servicio:</label>
                <textarea id="descripcion_producto" name="descripcion_producto" required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="valor_unitario">Valor Unitario:</label>
                    <input type="number" id="valor_unitario" name="valor_unitario" step="0.01" required />
                </div>
                <div class="form-group">
                    <label for="valor_total">Valor Total:</label>
                    <input type="number" id="valor_total" name="valor_total" step="0.01" required />
                </div>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" id="recibo_conforme" name="recibo_conforme" value="1" />
                <label for="recibo_conforme" style="font-weight: normal; margin-bottom: 0;">He recibido los productos/servicios a entera satisfacción.</label>
            </div>
            
            <button type="submit">Guardar Factura</button>
            <a href="panel_admin.php" class="btn-panel">Volver al Panel</a>
        </form>
    </div>
</body>
</html>
<?php
if(isset($conn)) {
    $conn->close();
}
?>