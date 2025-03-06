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

    // Verificar si no estan las caracteristicas en nuestra sesion volver a la pagina 3
    if (!isset($_SESSION["s_caracteristicas"])) {
        // Si no hay caracteristicas en nuestra sesion redirigir a Pagina3.php
        header("Location: Pagina3.php");
        exit();
    };


    



    function generarHabilidades($habilidades){



        // Asignar valores aleatorios entre 2 y 5 a cada habilidad seleccionada
        $habilidadesSeleccionadas = [];
        foreach ($habilidades as $habilidad) {
            $habilidadesSeleccionadas[$habilidad] = rand(2, 5);
        };

        print_r($habilidadesSeleccionadas);
        
        return $habilidadesSeleccionadas;

    }

    // Lista de habilidades de D&D
    $habilidades = [
        "Acrobacias" => "Agilidad y equilibrio.",
        "Atletismo" => "Capacidad física, correr, saltar y trepar.",
        "Conocimiento Arcano" => "Comprensión de la magia y sus reglas.",
        "Engaño" => "Habilidad para mentir y manipular.",
        "Historia" => "Conocimiento de eventos pasados y civilizaciones.",
        "Intimidación" => "Forzar la voluntad de otros con presencia o amenazas.",
        "Investigación" => "Búsqueda de información en textos o pistas.",
        "Medicina" => "Conocimiento de curación y diagnóstico.",
        "Percepción" => "Detección de detalles y amenazas ocultas.",
        "Perspicacia" => "Evaluación de intenciones y mentiras.",
        "Persuasión" => "Influencia en conversaciones con carisma.",
        "Sigilo" => "Capacidad para moverse sin ser detectado.",
        "Supervivencia" => "Habilidad en la naturaleza, rastreo y orientación."
    ];



    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!isset($_POST["habilidades"]) || count($_POST["habilidades"]) < 4 || count($_POST["habilidades"]) > 8) {
            $error = "Por favor, selecciona entre 4 y 8 habilidades.";
        } else {


            $habilidadesSeleccionadas = generarHabilidades($_POST["habilidades"]);

            
            // Guardar en sesión
            $_SESSION["s_habilidades"] = $habilidadesSeleccionadas;

            // Redirigir a Resultado.php
            header("Location: resultado.php");

            
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecciona tus habilidades - D&D</title>
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
        h1, p {
            color: gold;
            text-align: center;
        }
        .formulario {
            width: 85%;
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.8);
            text-align: left;
        }
        label {
            display: block;
            font-size: 1.2em;
            margin: 10px 0;
        }
        input[type="checkbox"] {
            margin-right: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 1.2em;
            border: 2px solid gold;
            border-radius: 10px;
            cursor: pointer;
            background: linear-gradient(90deg, #b8860b, #daa520);
            color: white;
            transition: 0.3s;
            width: 100%;
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
    <div class="container" style="margin-top:3%;margin-bottom:3%">
        <h1>Selecciona tus habilidades en D&D</h1>
        <p>Elige entre 4 y 8 habilidades para tu personaje.</p>

        <div class="formulario">
            <form method="post">
                <?php foreach ($habilidades as $nombre => $descripcion): ?>
                    <label>
                        <input type="checkbox" name="habilidades[]" value="<?php echo $nombre; ?>">
                        <strong><?php echo $nombre; ?></strong> - <?php echo $descripcion; ?>
                    </label>
                <?php endforeach; ?>
                
                <br>
                <input type="submit" value="Guardar Habilidades">
            </form>
        </div>
        
        <?php if (isset($error)): ?>
            <p class="error"><strong><?php echo $error; ?></strong></p>
        <?php endif; ?>
    </div>
</body>
</html>
