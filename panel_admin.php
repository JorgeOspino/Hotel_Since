<?php
session_start();
include('conexion.php');

// Proteger la página: si no hay sesión de admin, redirigir al login.
if (!isset($_SESSION['username'])) {
    header("Location: login_admin.php");
    exit();
}

// --- OBTENER DATOS PARA EL DASHBOARD ---

// 1. Conteo de habitaciones por estado
$sql_disponibles = "SELECT COUNT(*) as total FROM habitaciones WHERE estado = 'disponible'";
$total_disponibles = $conn->query($sql_disponibles)->fetch_assoc()['total'] ?? 0;

$sql_ocupadas = "SELECT COUNT(*) as total FROM habitaciones WHERE estado = 'ocupada'";
$total_ocupadas = $conn->query($sql_ocupadas)->fetch_assoc()['total'] ?? 0;

// 2. Conteo total de clientes registrados
$sql_clientes = "SELECT COUNT(*) as total FROM registro_cliente";
$total_clientes = $conn->query($sql_clientes)->fetch_assoc()['total'] ?? 0;

// 3. Conteo total de reservas
$sql_reservas = "SELECT COUNT(*) as total FROM reservas";
$total_reservas = $conn->query($sql_reservas)->fetch_assoc()['total'] ?? 0;

// 4. Obtener las últimas 5 reservas para la tabla de actividad reciente
$ultimas_reservas = [];
$sql_ultimas = "SELECT r.id, r.fecha_entrada, r.fecha_salida, r.habitacion_reservada, c.nombre_completo 
                FROM reservas r
                JOIN registro_cliente c ON r.cliente_id = c.id
                ORDER BY r.id DESC 
                LIMIT 5";
$resultado_ultimas = $conn->query($sql_ultimas);
if ($resultado_ultimas) {
    while($row = $resultado_ultimas->fetch_assoc()) {
        $ultimas_reservas[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Hotel San Luis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --color-primario: #264653;
            --color-secundario: #2a9d8f;
            --color-acento: #e9c46a;
            --color-peligro: #e76f51;
            --color-fondo: #f8f9fa;
            --color-texto: #495057;
            --color-blanco: #ffffff;
            --sombra-caja: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--color-fondo);
            color: var(--color-texto);
            margin: 0;
            display: flex;
        }

        /* --- Barra Lateral de Navegación --- */
        .sidebar {
            width: 260px;
            background-color: var(--color-primario);
            color: var(--color-blanco);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
        }
        .sidebar-header {
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-header .fa-hotel {
            margin-right: 10px;
        }
        .sidebar-nav {
            flex-grow: 1;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 18px 25px;
            color: var(--color-blanco);
            text-decoration: none;
            transition: background-color 0.3s, padding-left 0.3s;
            border-left: 4px solid transparent;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--color-acento);
            padding-left: 30px;
        }
        .sidebar-nav a i {
            width: 25px;
            margin-right: 15px;
            font-size: 1.1rem;
        }
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* --- Contenido Principal --- */
        .main-content {
            margin-left: 260px; /* Mismo ancho que el sidebar */
            width: calc(100% - 260px);
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        /* --- Tarjetas de Estadísticas --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        .stat-card {
            background-color: var(--color-blanco);
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--sombra-caja);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .stat-card .icon {
            font-size: 2.5rem;
            padding: 15px;
            border-radius: 50%;
            color: var(--color-blanco);
        }
        .stat-card .info .number {
            font-size: 2rem;
            font-weight: bold;
            display: block;
        }
        .stat-card .info .label {
            color: #6c757d;
        }

        /* Tabla de Actividad Reciente */
        .activity-table {
            background-color: var(--color-blanco);
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--sombra-caja);
        }
        .activity-table h2 {
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        table th {
            font-weight: bold;
        }

    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <i class="fa-solid fa-hotel"></i>
            <span>Hotel San Luis</span>
        </div>
        <ul class="sidebar-nav">
            <li><a href="panel_admin.php" class="active"><i class="fa-solid fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="info_habitaciones.php"><i class="fa-solid fa-door-open"></i> Habitaciones</a></li>
            <li><a href="registro_cliente.php"><i class="fa-solid fa-user-plus"></i> Registrar Cliente</a></li>
            <li><a href="registro_reserva.php"><i class="fa-solid fa-calendar-check"></i> Registrar Reserva</a></li>
            <li><a href="registro_factura.php"><i class="fa-solid fa-file-invoice-dollar"></i> Registrar Factura</a></li>
        </ul>
        <div class="sidebar-footer">
             <a href="index.php" style="text-decoration:none; color: white; display:flex; align-items:center; gap: 15px; padding: 10px; background: rgba(255,255,255,0.1); border-radius: 8px;"><i class="fa-solid fa-right-from-bracket">

             </i> Cerrar Sesión</a>
        </div>
    </aside>

    <main class="main-content">
        <header class="header">
            <h1>Dashboard</h1>
            <div class="user-info">
                Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
            </div>
        </header>

        <section class="stats-grid">
            <div class="stat-card">
                <div class="icon" style="background-color: #28a745;">
                    <i class="fa-solid fa-bed"></i>
                </div>
                <div class="info">
                    <span class="number"><?php echo $total_disponibles; ?></span>
                    <span class="label">Habitaciones Disponibles</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon" style="background-color: #dc3545;">
                    <i class="fa-solid fa-person-shelter"></i>
                </div>
                <div class="info">
                    <span class="number"><?php echo $total_ocupadas; ?></span>
                    <span class="label">Habitaciones Ocupadas</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon" style="background-color: #17a2b8;">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="info">
                    <span class="number"><?php echo $total_clientes; ?></span>
                    <span class="label">Total de Clientes</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon" style="background-color: #ffc107;">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
                <div class="info">
                    <span class="number"><?php echo $total_reservas; ?></span>
                    <span class="label">Total de Reservas</span>
                </div>
            </div>
        </section>

        