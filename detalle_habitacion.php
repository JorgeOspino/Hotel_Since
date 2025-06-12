<?php

$habitaciones = [
  201 => [
    'titulo' => 'Habitación 201 Deluxe',
    'imagen_url' => 'recursos/imagen201.jpeg ',
    'descripcion' => 'Habitación cómoda con capacidad para 2 personas.',
    'capacidad' => '2',
    'estado' => 'disponible'
  ],
  202 => [
    'titulo' => 'Habitación 202 Individual',
    'imagen_url' => 'recursos/img202.jpeg',
    'descripcion' => 'Habitación para 1 persona con todas las comodidades.',
    'capacidad' => '1',
    'estado' => 'ocupada'
  ],
  203 => [
    'titulo' => 'Habitación 203 Familiar',
    'imagen_url' => 'recursos/img203.jpeg',
    'descripcion' => 'Habitación para 3 o 4 personas con baño externo exclusivo.',
    'capacidad' => '4',
    'estado' => 'disponible'
  ],

  204 => [
    'titulo' => 'Habitación 204 Familiar',
    'imagen_url' => 'recursos/img204.jpeg',
    'descripcion' => 'Habitación para 3 o 4 personas con baño externo exclusivo.',
    'capacidad' => '4',
    'estado' => 'disponible'
  ],
  205 => [
    'titulo' => 'Habitación 205 Familiar',
    'imagen_url' => 'recursos/img205.jpeg',
    'descripcion' => 'Habitación para 3 o 4 personas con baño externo exclusivo.',
    'capacidad' => '4',
    'estado' => 'disponible'
  ],
  206 => [
    'titulo' => 'Habitación 206 Familiar',
    'imagen_url' => 'recursos/img206.jpeg',
    'descripcion' => 'Habitación para 3 o 4 personas con baño externo exclusivo.',
    'capacidad' => '4',
    'estado' => 'disponible'
  ],
  207 => [
    'titulo' => 'Habitación 207 Familiar',
    'imagen_url' => 'recursos/img207.jpeg',
    'descripcion' => 'Habitación para 3 o 4 personas con baño externo exclusivo.',
    'capacidad' => '4',
    'estado' => 'disponible'
  ],
  208 => [
    'titulo' => 'Habitación 208 Familiar',
    'imagen_url' => 'recursos/img208.jpeg',
    'descripcion' => 'Habitación para 3 o 4 personas con baño externo exclusivo.',
    'capacidad' => '4',
    'estado' => 'disponible'
  ],
  209 => [
    'titulo' => 'Habitación 209 Familiar',
    'imagen_url' => 'recursos/img209.jpeg',
    'descripcion' => 'Habitación para 3 o 4 personas con baño externo exclusivo.',
    'capacidad' => '4',
    'estado' => 'disponible'
  ],
  210 => [
    'titulo' => 'Habitación 210 Familiar',
    'imagen_url' => 'recursos/img210.jpeg',
    'descripcion' => 'Habitación para 3 o 4 personas con baño externo exclusivo.',
    'capacidad' => '4',
    'estado' => 'disponible'
  ],
  211 => [
    'titulo' => 'Habitación 211 Familiar',
    'imagen_url' => 'recursos/img211.jpeg',
    'descripcion' => 'Habitación para 3 o 4 personas con baño externo exclusivo.',
    'capacidad' => '4',
    'estado' => 'disponible'
  ],
  212 => [
    'titulo' => 'Habitación 212 Familiar',
    'imagen_url' => 'recursos/img212.jpeg',
    'descripcion' => 'Habitación para 3 o 4 personas con baño externo exclusivo.',
    'capacidad' => '4',
    'estado' => 'disponible'
  ]
];


$numero = $_GET['numero'] ?? null;


$habitacion = $habitaciones[$numero] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Detalle Habitación</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      padding: 20px;
      min-height: 100vh;
      display: flex;
      justify-content: center;
    }

    .detalle-container {
      max-width: 700px;
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .btn-back {
      background: #aaa;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
      margin-bottom: 20px;
    }

    .btn-back:hover {
      background: #888;
    }

    h1, h2 {
      color: #222;
      margin-bottom: 15px;
    }

    #imagen-habitacion {
      width: 100%;
      max-height: 300px;
      object-fit: cover;
      margin-bottom: 20px;
      border-radius: 8px;
    }

    ul {
      list-style: disc inside;
      margin-bottom: 20px;
    }

    .btn-whatsapp {
      background-color: #25D366;
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 25px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
      box-shadow: 0 4px 10px rgba(37, 211, 102, 0.5);
    }

    .btn-whatsapp:hover {
      background-color: #1ebe57;
    }
  </style>
</head>
<body>
  <div class="detalle-container">
    <button onclick="window.history.back()" class="btn-back">← Volver</button>

    <?php if ($habitacion): ?>
      <h1><?php echo htmlspecialchars($habitacion['titulo']); ?></h1>
      <img id="imagen-habitacion" src="<?php echo htmlspecialchars($habitacion['imagen_url']); ?>" alt="Imagen habitación" />

      <section id="descripcion">
        <h2>Descripción</h2>
        <p><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
      </section>

      <section id="caracteristicas">
        <h2>Características</h2>
        <ul>
          <li>Capacidad: <?php echo htmlspecialchars($habitacion['capacidad']); ?> personas</li>
          <li>Estado: <?php echo ucfirst(htmlspecialchars($habitacion['estado'])); ?></li>
        </ul>
      </section>

      <div style="text-align:center; margin-top:20px;">
        <button onclick="window.open('https://wa.me/573053009557', '_blank')" class="btn-whatsapp">
          Contactar por WhatsApp
        </button>
      </div>
    <?php else: ?>
      <h2>Habitación no encontrada</h2>
    <?php endif; ?>
  </div>
</body>
</html>
