<?php

$habitaciones = [
    [
        'numero' => 201,
        'imagen' => 'recursos/imagen201.jpeg',
        
    ],
    [
        'numero' => 202,
        'imagen' => 'recursos/img202.jpeg',
        
    ],
    [
        'numero' => 203,
        'imagen' => 'recursos/img203.jpeg',
        
    ],
    [
        'numero' => 204,
        'imagen' => 'recursos/img204.jpeg',
        
    ],
    [
        'numero' => 205,
        'imagen' => 'recursos/img205.jpeg',
        
    ],
    [
        'numero' => 206,
        'imagen' => 'recursos/img206.jpeg',
        
    ],
    [
        'numero' => 207,
        'imagen' => 'recursos/img207.jpeg',
       
    ],
    [
        'numero' => 208,
        'imagen' => 'recursos/img208.jpeg',
        
    ],
    [
        'numero' => 209,
        'imagen' => 'recursos/img209.jpeg',
        
    ],
    [
        'numero' => 210,
        'imagen' => 'recursos/img210.jpeg',
        
    ],
    [
        'numero' => 211,
        'imagen' => 'recursos/img211.jpeg',
        
    ],
    [
        'numero' => 212,
        'imagen' => 'recursos/img212.jpeg',
       
    ]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Habitaciones - Hotel San Luis de Sincé</title>
  <link rel="stylesheet" href="../CSS/habitaciones.css" />
  <style>
    .room-link {
      text-decoration: none;
      color: inherit;
    }
  
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background: #f5f5f5;
    color: #333;
    min-height: 100vh;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

header {
    width: 100%;
    max-width: 1100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

header h1 {
    font-size: 2.5rem;
    color: #222;
}

.btn-back {
    background: #0071e3;
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 25px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn-back:hover {
    background: #005bb5;
}

.rooms-container {
    max-width: 1100px;
    width: 100%;
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(220px,1fr));
    gap: 20px;
}


.room {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    cursor: pointer;
    transition: box-shadow 0.3s ease;
}

.room:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}


.room img {
    width: 100%;
    height: 140px;
    object-fit: cover;
}


.room-content {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.room-number {
    font-weight: bold;
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: #222;
}


.room-status {
    padding: 6px 12px;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 20px;
    text-align: center;
    width: fit-content;
    color: white;
}

.status-disponible {
    background-color: #2a9d8f; 
}

.status-ocupada {
    background-color: #e76f51; 
}


@media (max-width: 600px) {
    .room img {
        height: 110px;
    }

    .room-number {
        font-size: 1.1rem;
    }
}

  </style>
</head>
<body>
  <header>
    <h1>Habitaciones Hotel San Luis de Sincé</h1>
    <button onclick="window.history.back()" class="btn-back">← Volver</button>
  </header>

  <main class="rooms-container">
    <?php foreach ($habitaciones as $habitacion): ?>
      <a href="detalle_habitacion.php?numero=<?php echo $habitacion['numero']; ?>" class="room-link">
        <div class="room">
          <img src="<?php echo $habitacion['imagen']; ?>" alt="Habitación <?php echo $habitacion['numero']; ?>" />
          <div class="room-content">
            <div class="room-number">Habitación <?php echo $habitacion['numero']; ?></div>
          
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </main>
</body>
</html>
