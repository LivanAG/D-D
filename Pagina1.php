

<?php

    function asignarRaza($res1,$res2,$res3){

            // Inicializar variables de puntuación para cada raza
            $razas = [
                "Gnomo" => 0, "Humano" => 0, "Elfo" => 0, "Semielfo" => 0,
                "Dracónido" => 0, "Mediano" => 0, "Semiorco" => 0,
                "Tiflin" => 0, "Enano" => 0
            ];

            // Pregunta 1: ¿Qué cualidad describe mejor tu personalidad o enfoque en la vida?
            $resp_pregunta1 = (int)$res1;

            if ($resp_pregunta1 == 1) { // Conexión con la magia o la naturaleza
                $razas["Humano"] += 2; $razas["Semielfo"] += 1; $razas["Tiflin"] += 1;
            } elseif ($resp_pregunta1 == 2) { // Ambición y versatilidad
                $razas["Elfo"] += 2; $razas["Dracónido"] += 1; $razas["Gnomo"] += 1;
            } elseif ($resp_pregunta1 == 3) { // Fuerza y resistencia
                $razas["Enano"] += 2; $razas["Semiorco"] += 2;
            } elseif ($resp_pregunta1 == 4) { // Sigilo y astucia
                $razas["Mediano"] += 2; $razas["Tiflin"] += 1; $razas["Gnomo"] += 1;
            }


            // Pregunta 2: ¿Qué aspectos de tu herencia consideras más importantes? (Selección múltiple)
            $resp_pregunta2 = array_map('intval',$res2);

            if (in_array(1, $resp_pregunta2)) { // Tradición y orgullo por mis ancestros
                $razas["Enano"] += 2; $razas["Elfo"] += 2; $razas["Dracónido"] += 1; $razas["Tiflin"] += 1;
            }
            if (in_array(2, $resp_pregunta2)) { // Un legado de fortaleza y supervivencia
                $razas["Enano"] += 1; $razas["Semiorco"] += 2; $razas["Dracónido"] += 1;
            }
            if (in_array(3, $resp_pregunta2)) { // Vínculo con la magia o poderes sobrenaturales
                $razas["Elfo"] += 1; $razas["Dracónido"] += 2; $razas["Tiflin"] += 2; $razas["Gnomo"] += 1;
            }
            if (in_array(4, $resp_pregunta2)) { // Espíritu libre, sin estar atado a un destino predefinido
                $razas["Humano"] += 1; $razas["Semielfo"] += 2; $razas["Mediano"] += 2; $razas["Gnomo"] += 1;
            }


            // Pregunta 3: ¿Cuál de estos valores es más importante para ti?    
            $resp_pregunta3 = (int)$res3;

            if ($resp_pregunta3 == 1) { // Honor y tradición
                $razas["Enano"] += 2; $razas["Dracónido"] += 2; $razas["Elfo"] += 1; $razas["Semiorco"] += 1;
            } elseif ($resp_pregunta3 == 2) {// Libertad e independencia 
                $razas["Mediano"] += 2; $razas["Gnomo"] += 1; $razas["Semielfo"] += 1; $razas["Humano"] += 1;
            } elseif ($resp_pregunta3 == 3) { // Poder y destino
                $razas["Tiflin"] += 2; $razas["Dracónido"] += 1; $razas["Elfo"] += 1;
            } elseif ($resp_pregunta3 == 4) { // Adaptabilidad y comunidad
                $razas["Humano"] += 2; $razas["Semielfo"] += 2; $razas["Mediano"] += 1;
            }

            // ** Determinar la raza con más puntos **
            $maxPuntaje = max($razas);
            $razasMaximas = array_keys($razas, $maxPuntaje);
            $razaFinal = $razasMaximas[array_rand($razasMaximas)];

            return $razaFinal;
    }

    session_start();
    
    // Verificar si el nombre está almacenado en la sesión
    if (!isset($_SESSION["s_nombre"])) {
        // Si no hay nombre en la sesión, redirigir a index.php
        header("Location: index.php");
        exit();
    }




    $error = ""; // Inicializamos $error para evitar problemas

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Si hay algun campo del formulario vacio devolvemos error
        if (!isset($_POST["radio_pregunta"]) || !isset($_POST["check_pregunta"]) || !isset($_POST["select_pregunta"])){
            $error = "Por favor, rellena todos los campos del formulario";
        }else{

            $raza_final = asignarRaza($_POST["radio_pregunta"],$_POST["check_pregunta"],$_POST["select_pregunta"]);

            // ** Guardar la raza en una cookie **
            setcookie("c_raza", $raza_final);
            $_SESSION["s_raza"] = $raza_final;

            // Redirigir a Pagina2.php
            header("Location: Pagina2.php");
            exit();
        }


    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razas de D&D</title>
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
            text-align: left;
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
            text-align: justify;
            margin: 10px 20px;
        }
        .formulario {
            width: 90%;
            max-width: 700px;
            margin: 20px auto 0 auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.8);
            text-align: left;
        }
        .formulario h3 {
            text-align: center;
        }
        .formulario div {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .formulario label {
            margin-left: 10px;
            font-size: 1.1em;
        }
        select, input[type="radio"], input[type="checkbox"] {
            margin-right: 10px;
        }
        select {
            padding: 10px;
            border: 2px solid gold;
            background: black;
            color: white;
            border-radius: 10px;
            width: 100%;
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
    </style>
</head>
<body>
    <div class="container">
    <h1>Razas de Dungeons & Dragons</h1>

<h2>Humano</h2>
<p>Versátiles y adaptables, los humanos son la raza más común. Sus ambiciones y diversidad los hacen destacar en cualquier rol.</p>

<h2>Elfo</h2>
<p>Elegantes y longevos, los elfos tienen una profunda conexión con la magia y la naturaleza. Se dividen en varias subrazas como elfos altos, elfos silvanos y drow.</p>

<h2>Enano</h2>
<p>Fuertes y resistentes, los enanos son famosos por su habilidad para la forja y su amor por la minería. Son guerreros duros y leales.</p>

<h2>Mediano (Halfling)</h2>
<p>Pequeños pero ágiles, los medianos son conocidos por su gran suerte y su capacidad para pasar desapercibidos. Son amables y sociables.</p>

<h2>Gnomo</h2>
<p>Ingeniosos y curiosos, los gnomos aman la exploración y la invención. Suelen ser optimistas y juguetones.</p>

<h2>Dracónido</h2>
<p>Descendientes de dragones, los dracónidos poseen una presencia imponente y un aliento dracónico basado en su linaje.</p>

<h2>Tiflin</h2>
<p>Con sangre infernal en sus venas, los tiflin tienen cuernos y una apariencia demoníaca, pero no necesariamente un corazón malvado.</p>

<h2>Semielfo</h2>
<p>Fruto de la unión entre humanos y elfos, los semielfos combinan lo mejor de ambas razas y tienen una gran capacidad de adaptación.</p>

<h2>Semiorco</h2>
<p>Nacidos entre orcos y humanos, los semiorcos son fuertes, resistentes y feroces en la batalla. Suelen ser marginados en la sociedad.</p>

        
        <div class="formulario">
            <h1>Preguntas</h1>
            <form method="post">
                <h3>¿Qué cualidad describe mejor tu personalidad <?php echo $_SESSION["s_nombre"];?>?</h3>
                <div><input type="radio" name="radio_pregunta" value="1"><label>Ambición y versatilidad</label></div>
                <div><input type="radio" name="radio_pregunta" value="2"><label>Conexión con la magia o la naturaleza</label></div>
                <div><input type="radio" name="radio_pregunta" value="3"><label>Fuerza y resistencia</label></div>
                <div><input type="radio" name="radio_pregunta" value="4"><label>Sigilo y astucia</label></div>
                
                <h3>¿Qué aspectos de tu herencia consideras más importantes <?php echo $_SESSION["s_nombre"];?>?</h3>
                <div><input type="checkbox" name="check_pregunta[]" value="1"><label>Tradición y orgullo por mis ancestros</label></div>
                <div><input type="checkbox" name="check_pregunta[]" value="2"><label>Un legado de fortaleza y supervivencia</label></div>
                <div><input type="checkbox" name="check_pregunta[]" value="3"><label>Vínculo con la magia o poderes sobrenaturales</label></div>
                <div><input type="checkbox" name="check_pregunta[]" value="4"><label>Espíritu libre, sin estar atado a un destino predefinido</label></div>
                
                <h3>¿Cuál de estos valores es más importante para ti <?php echo $_SESSION["s_nombre"];?>?</h3>
                <select name="select_pregunta">
                    <option value="1">Honor y tradición</option>
                    <option value="2">Libertad e independencia</option>
                    <option value="3">Poder y destino</option>
                    <option value="4">Adaptabilidad y comunidad</option>
                </select>
                <br><br>

                <?php if (!empty($error)): ?>
                    <p style="color: red;"><strong><?php echo $error; ?></strong></p>
                    <?php endif; ?>
                <input type="submit" value="Enviar" />
            </form>
        </div>
    </div>
</body>
</html>
