<?php

include('conexion.php');


$mensaje_error = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM administradores WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
      
        session_start();
        $_SESSION['username'] = $username; 
        header("Location: panel_admin.php");
        exit;
    } else {
        $mensaje_error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Administrador - Hotel San Luis de Sincé</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background: #f0f0f0;
    display: flex;
    height: 100vh;
    justify-content: center;
    align-items: center;
}

.login-container {
    background: white;
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 6px 20px rgba(45, 44, 44, 0.15);
    width: 320px;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #333;
}

label {
    display: block;
    text-align: left;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 1rem;
}

button {
    background: #764ba2;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 25px;
    font-size: 1.1rem;
    cursor: pointer;
    width: 100%;
    transition: background 0.3s ease;
}

button:hover {
    background: #667eea;
}

.error {
    color: red;
    margin-top: -15px;
    margin-bottom: 15px;
    font-size: 0.9rem;
}

.btn-container {
  width: 50%;
  margin-top: 20px;
  text-align: center; 
}

.btn-volver {
  display: inline-block; 
  background: #aaa;
  color: white;
  border: none;
  padding: 12px 25px;
  border-radius: 25px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.3s ease;
}

.btn-volver:hover {
  background: #888;
}



    </style>
</head>
<body>
    <div class="login-container">
        <h2>Ingreso Administrador</h2>
      
        <?php if ($mensaje_error): ?>
            <p><?php echo $mensaje_error; ?></p>
        <?php endif; ?>

        <form id="loginForm" method="POST">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" placeholder="Número de identificación" required />

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Contraseña" required />

            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>
