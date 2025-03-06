<?php

/*
$_SERVER es una variable global de PHP que almacena información sobre la solicitud del servidor.
$_SERVER["REQUEST_METHOD"] contiene el método HTTP utilizado en la solicitud.
"POST" → Si el usuario ha enviado el formulario.
"GET" → Si el usuario simplemente ha cargado la página sin enviar el formulario.
=== "POST" verifica si el formulario fue enviado con el método POST.
Si el usuario abre la página sin haber enviado el formulario, el código dentro del if no se ejecutará.
Ejemplo:

Cuando un usuario abre la página desde el navegador (GET), la condición no se cumple y el código dentro del if no se ejecuta.
Cuando el usuario llena el formulario y presiona "Enviar", la solicitud se hace con POST, y ahora sí se ejecuta el código dentro del if.
*/


session_start();

$error = ""; // Inicializamos $error para evitar problemas

// Solo procesamos el formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST["nombre"]) || trim($_POST["nombre"]) === "") {
        $error = "Por favor, escribe tu nombre";
    } else {

        // Limpiamos el input eliminando etiquetas HTML y espacios
        $nombre = strip_tags($_POST["nombre"]); 
        $nombre = trim($nombre); 
        
        // Validamos el nombre (debe tener entre 2 y 50 caracteres y solo contener letras y espacios)
        if (strlen($nombre) < 2 || strlen($nombre) > 50) {
            $error = "El nombre debe tener entre 2 y 50 caracteres.";
        } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/u", $nombre)) {
            $error = "El nombre solo puede contener letras y espacios.";
        } 

        // Si no hay errores, aplicamos htmlspecialchars y guardamos en la sesión
        if (empty($error)) {
            $_SESSION["s_nombre"] = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
            header("Location: Pagina1.php");
            exit();
        }
    }
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a D&D</title>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('imgs/1.webp') no-repeat center center/cover;
            font-family: 'MedievalSharp', cursive;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.8);
            animation: glow 2s infinite alternate;
        }
        @keyframes glow {
            0% { box-shadow: 0 0 20px rgba(255, 215, 0, 0.6); }
            100% { box-shadow: 0 0 30px rgba(255, 215, 0, 1); }
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 1.2em;
            border: 2px solid gold;
            border-radius: 10px;
            width: 80%;
            max-width: 300px;
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 1.2em;
            border: 2px solid gold;
            border-radius: 10px;
            cursor: pointer;
            background: linear-gradient(90deg, #b8860b, #daa520);
            color: white;
            margin-top: 10px;
            transition: 0.3s;
        }
        input[type="submit"]:hover {
            background: linear-gradient(90deg, #daa520, #b8860b);
            transform: scale(1.1);
        }
        .error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido al Reino de D&D</h1>
        <form method="post">
            <input type="text" name="nombre" placeholder="Introduce tu nombre" required/>
            <br>
            <input type="submit" value="Entrar en la Aventura"/>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>

