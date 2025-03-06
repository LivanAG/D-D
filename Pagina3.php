<?php
session_start();

    // Verificar si el nombre no está almacenado en la sesión volvemos a index
    if (!isset($_SESSION["s_nombre"])) {
        // Si no hay nombre en la sesión, redirigir a index.php
        header("Location: index.php");
        exit();
    }

    // Verificar si el nombre está almacenado pero la raza no, volvemos a pagina 1
    if (isset($_SESSION["s_nombre"])&&!isset($_SESSION["s_raza"])) {
        // Si no hay raza en la sesión, redirigir a Pagina1.php
        header("Location: Pagina1.php");
        exit();
    }

    // Verificar si el arma y la clase no están almacenadas volvemos a pagina 2
    if (!isset($_SESSION["s_clase"])&& !isset($_SESSION["s_arma"])) {
        // Si no hay claes o arma seleccionada en la sesión, redirigir a Pagina2.php
        header("Location: Pagina2.php");
        exit();
    }

?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Características de D&D</title>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('imgs/1.webp') no-repeat center center fixed;
            background-size: cover;
            font-family: 'MedievalSharp', cursive;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 90%;
            max-width: 800px;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.8);
            animation: glow 2s infinite alternate;
            text-align: center;
        }
        @keyframes glow {
            0% { box-shadow: 0 0 20px rgba(255, 215, 0, 0.6); }
            100% { box-shadow: 0 0 30px rgba(255, 215, 0, 1); }
        }
        h1, h2 {
            color: gold;
            text-align: center;
        }
        p {
            font-size: 1.2em;
            text-align: center;
            margin: 10px 20px;
        }
        .botones {
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 1.2em;
            border: 2px solid gold;
            border-radius: 10px;
            cursor: pointer;
            background: linear-gradient(90deg, #b8860b, #daa520);
            color: white;
            transition: 0.3s;
        }
        button:hover {
            background: linear-gradient(90deg, #daa520, #b8860b);
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Características en Dungeons & Dragons</h1>
        <p>En D&D, las características representan las habilidades y aptitudes principales de un personaje. Cada una influye en diferentes aspectos del juego.</p>
        
        <h2>Fuerza</h2>
        <p>Representa el poder físico y la capacidad atlética del personaje. Es fundamental para los ataques cuerpo a cuerpo y levantar objetos pesados.</p>
        
        <h2>Destreza</h2>
        <p>Mide la agilidad, reflejos y precisión del personaje. Influye en la evasión, ataques a distancia y sigilo.</p>
        
        <h2>Constitución</h2>
        <p>Determina la resistencia física del personaje. Afecta los puntos de golpe y la resistencia contra venenos o fatiga.</p>
        
        <h2>Inteligencia</h2>
        <p>Representa la capacidad de aprendizaje, razonamiento y memoria del personaje. Es clave para lanzadores de conjuros como magos y la investigación de conocimientos.</p>
        
        <h2>Sabiduría</h2>
        <p>Refleja la percepción, intuición y sentido común del personaje. Es importante para clérigos, druidas y para detectar mentiras o trampas.</p>
        
        <h2>Carisma</h2>
        <p>Mide la presencia, liderazgo y capacidad de persuasión del personaje. Es esencial para bardos, hechiceros y negociaciones.</p>
        
        <div id="caracteristicas" style="margin-top:5%" >
            <?php
            if (isset($_SESSION["s_caracteristicas"])) {
                foreach ($_SESSION["s_caracteristicas"] as $carac => $valor) {
                    echo "<p><strong>$carac</strong>: $valor</p>";
                }
            }
            ?>
        </div>

        <div class="botones">
            <button id="generar-btn">Generar características</button>
            <button id="continuar" 
                style="display: <?php echo isset($_SESSION["s_caracteristicas"]) ? 'block' : 'none'; ?>" 
                onclick="location.href='Pagina4.php'">
                Continuar
            </button>
        </div>
    </div>

    <script>

        document.getElementById("generar-btn").addEventListener("click", function() {
        
            fetch("generarCaracteristicas.php", {
                method: "POST",
                //El header Content-Type indica que los datos están en formato estándar de formularios HTML.
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                }
            })
            //Cuando el servidor responde, convertimos la respuesta en un objeto JSON.
            .then(response => response.json())

            //data contendrá las características generadas o un mensaje de error.
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Actualizar el contenido de la página sin recargar
                let container = document.getElementById("caracteristicas");
                container.innerHTML = "";  // Limpiar datos anteriores

                for (let caracteristica in data) {
                    let p = document.createElement("p");
                    p.innerHTML = `<strong>${caracteristica}</strong>: ${data[caracteristica]}`;
                    container.appendChild(p);
                }

                // Mostrar el botón "Continuar"
                document.getElementById("continuar").style.display = "block";
            })
            .catch(error => console.error("Error:", error));
        });

    </script>
</body>
</html>
