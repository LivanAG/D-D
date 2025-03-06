
<?php
session_start();


    function getDominantColor($hexColor) {
            // Extraer los valores de Rojo, Verde y Azul
            list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

            // Determinar el color dominante
            if ($r > $g && $r > $b) {
                return "Rojo";
            } elseif ($g > $r && $g > $b) {
                return "Verde";
            } elseif ($b > $r && $b > $g) {
                return "Azul";
            } elseif ($r == $g && $r > $b) {
                return "Amarillo";
            } elseif ($r == $b && $r > $g) {
                return "Magenta";
            } elseif ($g == $b && $g > $r) {
                return "Cian";
            } else {
                return "Gris/Neutro";
            }
    }


    function seleccionarClase($res1,$res2,$res3,$res4){

        // Inicializar variables de puntuación para cada clase
        $clases = [
            "Mago" => 0, "Monje" => 0, "Brujo" => 0, "Guerrero" => 0, "Paladín" => 0, 
            "Explorador" => 0, "Bárbaro" => 0, "Pícaro" => 0, "Hechicero" => 0, 
            "Clérigo" => 0, "Druida" => 0, "Bardo" => 0
        ];

        // Pregunta 1: Estrategia de combate
        $resp_pregunta1 = (int)$res1;

        if ($resp_pregunta1 >= 1 && $resp_pregunta1 <= 3) { 
            $clases["Mago"] += 2; $clases["Monje"] += 2; $clases["Brujo"] += 1;
        } elseif ($resp_pregunta1 >= 4 && $resp_pregunta1 <= 7) { 
            $clases["Guerrero"] += 2; $clases["Paladín"] += 2; $clases["Explorador"] += 1;
        } elseif ($resp_pregunta1 >= 8 && $resp_pregunta1 <= 10) { 
            $clases["Bárbaro"] += 2; $clases["Pícaro"] += 2; $clases["Hechicero"] += 1;
        }

        // Pregunta 2: Años de entrenamiento
        $resp_pregunta2 = (int)$res2;

        if ($resp_pregunta2 >= 1 && $resp_pregunta2 <= 10) {
            $clases["Hechicero"] += 2; $clases["Pícaro"] += 1; $clases["Bárbaro"] += 1;
        } elseif ($resp_pregunta2 >= 11 && $resp_pregunta2 <= 30) { 
            $clases["Explorador"] += 2; $clases["Guerrero"] += 1; $clases["Bardo"] += 1;
        } elseif ($resp_pregunta2 >= 31 && $resp_pregunta2 <= 50) { 
            $clases["Mago"] += 2; $clases["Paladín"] += 1; $clases["Monje"] += 1;
        }

        // Pregunta 3: Color de aura
        $resp_pregunta3 = $res3;
        $colorDominante = getDominantColor($resp_pregunta3);

        $colorPuntos = [
            "Rojo" => ["Bárbaro" => 2, "Paladín" => 1, "Guerrero" => 1],
            "Azul" => ["Hechicero" => 2, "Mago" => 1, "Clérigo" => 1],
            "Verde" => ["Druida" => 2, "Explorador" => 1, "Monje" => 1],
            "Negro" => ["Brujo" => 2, "Pícaro" => 1, "Mago" => 1],
            "Amarillo" => ["Bardo" => 2, "Clérigo" => 1, "Explorador" => 1],
            "Magenta" => ["Hechicero" => 2, "Brujo" => 1, "Mago" => 1],
            "Cian" => ["Pícaro" => 2, "Explorador" => 1, "Monje" => 1],
            "Gris/Neutro" => ["Guerrero" => 1, "Bardo" => 1, "Monje" => 1]
        ];

        if (isset($colorPuntos[$colorDominante])) {
            foreach ($colorPuntos[$colorDominante] as $clase => $puntos) {
                $clases[$clase] += $puntos;
            }
        }

        // Pregunta 4: Fecha de nacimiento
        $resp_pregunta4 = $_REQUEST["fecha_nacimiento"];
        $dia_nacimiento = (int)date("d", strtotime($resp_pregunta4));

        if ($dia_nacimiento >= 1 && $dia_nacimiento <= 10) {
            $clases["Guerrero"] += 2; $clases["Bárbaro"] += 1; $clases["Explorador"] += 1;
        } elseif ($dia_nacimiento >= 11 && $dia_nacimiento <= 20) {
            $clases["Pícaro"] += 2; $clases["Monje"] += 1; $clases["Bardo"] += 1;
        } elseif ($dia_nacimiento >= 21 && $dia_nacimiento <= 31) {
            $clases["Hechicero"] += 2; $clases["Clérigo"] += 1; $clases["Druida"] += 1;
        }

        // Determinar la clase con más puntos
        $claseFinal = array_keys($clases, max($clases))[0];

        return $claseFinal;

        
    }

    

    function seleccionarArma($claseFinal){
        // Lista de armas por clase
        $armasPorClase = [
            "Bárbaro" => ["Hacha de batalla", "Espada grande", "Martillo de guerra", "Lanza"],
            "Bardo" => ["Espada corta", "Ballesta ligera", "Daga", "Látigo"],
            "Clérigo" => ["Maza", "Martillo de guerra", "Alabarda", "Bastón"],
            "Druida" => ["Bastón", "Honda", "Daga", "Cimitarra"],
            "Guerrero" => ["Espada larga", "Lanza", "Arco largo", "Hacha de batalla"],
            "Hechicero" => ["Bastón", "Daga", "Honda"],
            "Explorador" => ["Arco largo", "Espada corta", "Daga", "Lanza"],
            "Paladín" => ["Espada larga", "Martillo de guerra", "Lanza", "Alabarda"],
            "Pícaro" => ["Daga", "Espada corta", "Ballesta ligera", "Látigo"],
            "Mago" => ["Bastón", "Daga", "Honda"],
            "Monje" => ["Bastón", "Nunchakus", "Shurikens", "Lanza"],
            "Brujo" => ["Bastón", "Daga", "Honda"]
        ];


        // Seleccionar un arma al azar para la clase final
        $armaSeleccionada = $armasPorClase[$claseFinal][array_rand($armasPorClase[$claseFinal])];

        return $armaSeleccionada;

    }



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

    $error="";

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        if (!isset($_POST["estrategia_combate"]) || !isset($_POST["anos_entrenamiento"]) || !isset($_POST["color_aura"]) || !isset($_POST["fecha_nacimiento"])){
            $error = "Por favor, rellena todos los campos del formulario";
        }

        else if ((int)$_POST["anos_entrenamiento"]<0 && (int)$_POST["anos_entrenamiento"]>50 ){
            $error = "El valor de los años de entrenamiento tiene que estar entre 0 y 50";
        }

        else if ((int)$_POST["estrategia_combate"]<0 && (int)$_POST["estrategia_combate"]>10 ){
            $error = "El valor de la estrategia de combate debe estar entre 0 y 10";
        }
        else{
            

            $claseFinal= seleccionarClase($_POST["estrategia_combate"],$_POST["anos_entrenamiento"],$_POST["color_aura"],$_POST["fecha_nacimiento"]);
            $armaSeleccionada=seleccionarArma($claseFinal);

            // Mostrar el resultado final
            echo "<h1>Tu clase en D&D es: <strong>$claseFinal</strong></h1>";
            echo "<h2>Tu arma seleccionada es: <strong>$armaSeleccionada</strong></h2>";



            // ** Guardar la raza en una cookie **
            setcookie("c_clase", $claseFinal);
            $_SESSION["s_clase"] = $claseFinal;


            setcookie("c_arma", $armaSeleccionada);
            $_SESSION["s_arma"] = $armaSeleccionada;


            // Redirigir a Pagina2.php
            header("Location: Pagina3.php");
            exit();
        }

    }



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clases y Armas en D&D</title>
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
        .formulario h3 {
            text-align: center;
        }
        .formulario input, .formulario select {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 2px solid gold;
            background: black;
            color: white;
            border-radius: 10px;
            box-sizing: border-box;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
        input[type="color"] {
            height: 50px;
            padding: 5px;
            border-radius: 10px;
            border: 2px solid gold;
        }
        input[type="range"] {
            -webkit-appearance: none;
            width: 100%;
            height: 10px;
            background: linear-gradient(90deg, #b8860b, #daa520);
            border-radius: 5px;
            outline: none;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            background: gold;
            border-radius: 50%;
            cursor: pointer;
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
    <h1>Clases de Dungeons & Dragons y sus armas</h1>

<h2>Bárbaro</h2>
<p>Guerreros salvajes que luchan con furia descontrolada.</p>
<strong>Armas comunes:</strong> Hachas de batalla, espadas grandes, martillos de guerra, lanzas.

<h2>Bardo</h2>
<p>Artistas y encantadores que usan la música y la magia para inspirar aliados y confundir enemigos.</p>
<strong>Armas comunes:</strong> Espadas cortas, ballestas ligeras, dagas, látigos.

<h2>Clérigo</h2>
<p>Guerreros santos que canalizan el poder divino de los dioses.</p>
<strong>Armas comunes:</strong> Mazas, martillos de guerra, alabardas, bastones.

<h2>Druida</h2>
<p>Guardianes de la naturaleza con el poder de transformarse en animales.</p>
<strong>Armas comunes:</strong> Bastones, hondas, dagas, cimitarras.

<h2>Guerrero</h2>
<p>Maestros del combate con gran versatilidad en el uso de armas.</p>
<strong>Armas comunes:</strong> Espadas largas, lanzas, arcos largos, hachas de batalla.

<h2>Hechicero</h2>
<p>Usuarios de magia innata con sangre de criaturas místicas.</p>
<strong>Armas comunes:</strong> Bastones, dagas, hondas.

<h2>Explorador (Ranger)</h2>
<p>Cazadores expertos con habilidades marciales y conexión con la naturaleza.</p>
<strong>Armas comunes:</strong> Arcos largos, espadas cortas, dagas, lanzas.

<h2>Paladín</h2>
<p>Guerreros sagrados con un fuerte código de honor y poderes divinos.</p>
<strong>Armas comunes:</strong> Espadas largas, martillos de guerra, lanzas, alabardas.

<h2>Pícaro</h2>
<p>Sigilosos y astutos, expertos en ataques sorpresa y evasión.</p>
<strong>Armas comunes:</strong> Dagas, espadas cortas, ballestas ligeras, látigos.

<h2>Mago</h2>
<p>Eruditos de la magia con un amplio repertorio de conjuros.</p>
<strong>Armas comunes:</strong> Bastones, dagas, hondas.

<h2>Monje</h2>
<p>Maestros de las artes marciales que canalizan energía mística en sus ataques.</p>
<strong>Armas comunes:</strong> Bastones, nunchakus, shurikens, lanzas.

<h2>Brujo</h2>
<p>Magos que obtienen su poder a través de pactos con seres sobrenaturales.</p>
<strong>Armas comunes:</strong> Bastones, dagas, hondas.


        <div class="formulario">
            <h1>Elige tu destino</h1>
            <form method="post">
                <h3>¿Cómo prefieres enfrentarte a tus enemigos <?php echo $_SESSION["s_nombre"]." el ".$_SESSION["s_raza"];?>?</h3>
                <p>(1 = Paciente y estratégico, 10 = Agresivo y audaz)</p>
                <input type="range" name="estrategia_combate" min="1" max="10" value="5" oninput="this.nextElementSibling.value = this.value">
                <output>5</output>
                
                
                <h3>¿Cuántos años entrenaste antes de aventurarte <?php echo $_SESSION["s_nombre"]." el ".$_SESSION["s_raza"];?>?</h3>
                <p>(Elije un numero entre el 1 y el 50)</p>
                <input type="number" name="anos_entrenamiento" min="1" max="50" required>
                
                <h3>¿Qué color representa mejor tu energía mágica o tu aura de combate <?php echo $_SESSION["s_nombre"]." el ".$_SESSION["s_raza"];?>?</h3>
                <input type="color" name="color_aura">
                
                <h3>¿Cuál es tu fecha de nacimiento <?php echo $_SESSION["s_nombre"]." el ".$_SESSION["s_raza"];?>?</h3>
                <input type="date" name="fecha_nacimiento" required>
                
                <br><br>
                <?php if (!empty($error)): ?>
                    <p style="color: red;"><strong><?php echo $error; ?></strong></p>
                <?php endif; ?>
                <input type="submit" value="Descubrir mi Clase">
            </form>
        </div>
    </div>
</body>
</html>