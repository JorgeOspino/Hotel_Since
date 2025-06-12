<?php

$instagram_url = "https://www.instagram.com/hotelsince?igsh=MWoxaGw5aDA3dHdwdA==";
$facebook = "https://www.facebook.com/share/16M4VRJYSn/";
?>
<style>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    height: 100vh;
    background-image: url('recursos/imagen1.jpeg'); 
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    position: relative;
    overflow: hidden;
}

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
}

.container {
    position: relative;
    z-index: 2;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 20px;
}

.welcome-title {
    color: white;
    font-size: 3.5rem;
    font-weight: bold;
    text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.8);
    margin-bottom: 3rem;
    letter-spacing: 2px;
    animation: fadeInDown 1s ease-out;
}

.buttons-container {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    align-items: center;
}

.btn {
    padding: 18px 40px;
    font-size: 1.3rem;
    font-weight: bold;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    letter-spacing: 1px;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    animation: fadeInUp 1s ease-out 0.3s both;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
}

.btn-admin {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    font-size: 1rem;
    padding: 15px 30px;
    animation: fadeInRight 1s ease-out 0.6s both;
}

.btn-admin:hover {
    background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(245, 87, 108, 0.4);
}


@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}


@media (max-width: 768px) {
    .welcome-title {
        font-size: 2.5rem;
        margin-bottom: 2rem;
    }

    .btn {
        padding: 15px 30px;
        font-size: 1.1rem;
    }

    .btn-admin {
        bottom: 20px;
        right: 20px;
        padding: 12px 25px;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .welcome-title {
        font-size: 2rem;
        letter-spacing: 1px;
    }

    .btn {
        padding: 12px 25px;
        font-size: 1rem;
    }
}


.particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}

.particle {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s infinite ease-in-out;
}

.particle:nth-child(1) {
    width: 10px;
    height: 10px;
    left: 10%;
    animation-delay: 0s;
}

.particle:nth-child(2) {
    width: 8px;
    height: 8px;
    left: 20%;
    animation-delay: 1s;
}

.particle:nth-child(3) {
    width: 12px;
    height: 12px;
    left: 70%;
    animation-delay: 2s;
}

.particle:nth-child(4) {
    width: 6px;
    height: 6px;
    left: 80%;
    animation-delay: 3s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(100vh) rotate(0deg);
        opacity: 0;
    }
    10%, 90% {
        opacity: 1;
    }
    50% {
        transform: translateY(-10vh) rotate(180deg);
    }

    
}

.welcome-message {
    color: white;
    font-size: 1.8rem;
    margin-bottom: 3rem;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.7);
    max-width: 600px;
    line-height: 1.4;
}

.social-media {
    margin-top: 40px;
    text-align: center;
    color: white;
    z-index: 2;
    position: relative;
}

.social-media h2 {
    font-size: 1.8rem;
    margin-bottom: 20px;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.7);
}

.social-icons {
    display: flex;
    justify-content: center;
    gap: 40px;
}

.social-icons a img {
    width: 45px;
    height: 45px;
    filter: drop-shadow(0 0 2px rgba(0,0,0,0.6));
    transition: transform 0.3s ease;
}

.social-icons a:hover img {
    transform: scale(1.1);
    filter: drop-shadow(0 0 5px rgba(255,255,255,0.9));
}


</style>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel San Luis de Sincé</title>
   
</head>

<body>
    <!-- Partículas flotantes para efecto visual -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="container">
        <h1 class="welcome-title">Bienvenido al Hotel San Luis de Sincé</h1>
        
        <h2 class="welcome-message">
            Estamos encantados de recibirte. <br>
            Disfruta de una estadía cómoda y segura con nosotros.
        </h2>

        <button class="btn btn-primary" onclick="window.location.href='ver_habitaciones.php'">
            Ver Habitaciones
        </button>

        <button class="btn btn-admin" onclick="window.location.href='login_admin.php'">
            Administrador
        </button>
        
        <div>
            <section class="social-media">
                <h2>Siguenos en nuestras redes</h2>
                <div class="social-icons">
                    <a href="<?php echo $instagram_url; ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <img src="recursos/Instagram.svg" alt="Instagram" />
                    </a>
                    <a href="<?php echo $facebook; ?>" target="_blank" aria-label="facebook">
                        <img src="recursos/facebook.png" alt="facebook" />
                    </a>
                </div>
            </section>
        </div>
   
    </div>

</body>
</html>