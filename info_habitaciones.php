<?php

session_start();


include('conexion.php');


if (isset($_POST['guardar'])) {
 
    $numero = $_POST['numero'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];

   
    $sql = "UPDATE habitaciones SET descripcion = ?, estado = ? WHERE numero = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $descripcion, $estado, $numero);
    $stmt->execute();
}


$sql = "SELECT * FROM habitaciones";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel de Administración - Hotel San Luis de Sincé</title>
    <style>
       
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        
        .admin-container {
            width: 100%;
            max-width: 1200px;
            margin-top: 30px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        
        h1 {
            font-size: 2.5rem;
            color: #222;
            text-align: center;
            margin-bottom: 20px;
        }

       
        p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 30px;
            text-align: center;
        }

        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #2a9d8f;
            color: white;
        }

        table td {
            background-color: #f9f9f9;
        }

        
        a.btn-logout {
            display: inline-block;
            background-color: #e74c3c;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 1rem;
            text-align: center;
            margin-bottom: 20px;
            transition: background 0.3s ease;
        }

        a.btn-logout:hover {
            background-color: #c0392b;
        }

        a.btn-editar {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            text-align: center;
            margin: 5px 0;
        }

        a.btn-editar:hover {
            background-color: #45a049;
        }

        
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

       
        .form-editar {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        .form-editar label {
            display: block;
            margin-bottom: 10px;
        }

        .form-editar input, .form-editar select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .form-editar button {
            background-color: #2a9d8f;
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            border: none;
            cursor: pointer;
        }

        .form-editar button:hover {
            background-color: #1f7f6c;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Panel de Administración</h1>
        <p>Bienvenido, <?php echo $_SESSION['username']; ?>!</p>

        
        <a href="index.php" class="btn-logout">Cerrar sesión</a>

      
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado->num_rows > 0): ?>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['numero']; ?></td>
                            <td><?php echo $row['descripcion']; ?></td>
                            <td><?php echo ucfirst($row['estado']); ?></td>
                            <td>
                                <a href="?editar=<?php echo $row['numero']; ?>" class="btn-editar">Editar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay habitaciones registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php
       
        if (isset($_GET['editar'])) {
            $numero_habitacion = $_GET['editar'];

           
            $sql = "SELECT * FROM habitaciones WHERE numero = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $numero_habitacion);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $habitacion = $resultado->fetch_assoc();
                ?>

                
                <div class="form-editar">
                    <h2>Editar Habitación <?php echo $habitacion['numero']; ?></h2>
                    <form method="POST">
                        <input type="hidden" name="numero" value="<?php echo $habitacion['numero']; ?>" />
                        <label for="descripcion">Descripción:</label>
                        <input type="text" name="descripcion" value="<?php echo $habitacion['descripcion']; ?>" required />

                        <label for="estado">Estado:</label>
                        <select name="estado" required>
                            <option value="Disponible" <?php echo ($habitacion['estado'] == 'Disponible') ? 'selected' : ''; ?>>Disponible</option>
                            <option value="Ocupada" <?php echo ($habitacion['estado'] == 'Ocupada') ? 'selected' : ''; ?>>Ocupada</option>
                        </select>

                        <button type="submit" name="guardar">Guardar cambios</button>
                    </form>
                </div>

                <?php
            }
        }
        ?>
    </div>
</body>
</html>

<?php

$conn->close();
?>
