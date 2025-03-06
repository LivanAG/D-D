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
    }


    // Verificar si no estan las habilidades en nuestra sesion volver a la pagina 4
    if (!isset($_SESSION["s_caracteristicas"])) {
        // Si no hay habilidades en nuestra sesion redirigir a Pagina4.php
        header("Location: Pagina4.php");
        exit();
    }





    function generarHistoria($nombre, $raza, $clase, $arma) {


        $generoArmas = [
            
            "Espada grande" => "f",
            "Lanza" => "f",
            "Espada corta" => "f",
            "Ballesta ligera" => "f",
            "Daga" => "f",
            "Maza" => "f",
            "Alabarda" => "f",
            "Bastón" => "m",
            "Honda" => "f",
            "Cimitarra" => "f",
            "Espada larga" => "f",


            "Hacha de batalla" => "m",
            "Arco largo" => "m",
            "Nunchakus" => "m",
            "Shurikens" => "m",
            "Látigo" => "m",
            "Martillo de guerra" => "m"
        ];


        $articuloArma = (isset($generoArmas[$arma]) && $generoArmas[$arma] == "f") ? "la" : "el";

        // Introducciones
    $introducciones = [
        "$nombre, un valiente $raza $clase, nació en una aldea remota, donde aprendió a manejar $articuloArma $arma desde joven.",
        "$nombre, un misterioso $raza $clase, descubrió su destino al encontrar una antigua $arma en las ruinas de un templo perdido.",
        "Criado en las sombras, $nombre, un astuto $raza $clase, perfeccionó su dominio con $articuloArma $arma en la clandestinidad.",
        "Las leyendas cuentan que $nombre, un audaz $raza $clase, empuñó su $arma antes de aprender a hablar.",
        "Desde su infancia, $nombre, un talentoso $raza $clase, mostró gran destreza con $articuloArma $arma.",
        "$nombre, un intrépido $raza $clase, perfeccionó su dominio con $articuloArma $arma en los bosques sombríos.",
        "$nombre, un prodigioso $raza $clase, juró que con $articuloArma $arma traería honor a su linaje caído.",
        "A las puertas de un castillo maldito, $nombre, un feroz $raza $clase, encontró su destino junto a su fiel $arma.",
        "El desierto forjó el espíritu de $nombre, un implacable $raza $clase, cuyo vínculo con $articuloArma $arma es inquebrantable.",
        "Acompañado por las historias de sus ancestros, $nombre, un legendario $raza $clase, aprendió a dominar $articuloArma $arma para enfrentar su destino."
    ];

    // Conflictos
    $conflictos = [
        "Una tragedia golpeó su vida cuando una banda de saqueadores le arrebató su hogar y su preciada $arma.",
        "Tras una traición inesperada, $nombre se vio obligado a huir, dejando atrás todo excepto su fiel $arma.",
        "Un antiguo enemigo, celoso del talento de $nombre con $articuloArma $arma, juró cazarlo hasta el fin del mundo.",
        "Marcado por una maldición ancestral, $nombre solo puede romper su destino usando $articuloArma $arma contra un enemigo legendario.",
        "$nombre, un desterrado $raza $clase, busca venganza por el robo de su preciada $arma, la única herencia de su familia.",
        "$articuloArma $arma de $nombre ha sido robada y ahora debe recuperarla antes de que caiga en manos equivocadas.",
        "$nombre descubrió que su propia sangre está ligada a la magia de su $arma, pero ahora alguien intenta arrebatarle ese poder.",
        "El reino ha prohibido el uso de $articuloArma $arma, y $nombre debe luchar en las sombras para demostrar la justicia de su causa.",
        "El destino de $nombre cambió cuando un sabio le advirtió que su $arma estaba maldita y debía ser destruida antes de consumir su alma.",
        "El enemigo de su pueblo ha desafiado a $nombre, obligándolo a demostrar su valía como $raza $clase empuñando su $arma en un duelo mortal."
    ];

    // Desenlaces
    $desenlaces = [
        "Ahora, con $articuloArma $arma en mano, $nombre viaja por el mundo buscando restaurar el equilibrio.",
        "A pesar de su pasado doloroso, $nombre sigue adelante, usando $articuloArma $arma para proteger a los inocentes.",
        "Cada batalla lo acerca más a descubrir la verdad detrás del misterio de $articuloArma $arma.",
        "Mientras el mundo observa, $nombre blande $articuloArma $arma una vez más, enfrentando su prueba final.",
        "El eco de su nombre se extiende por las tierras, pues su destreza con $articuloArma $arma es inigualable.",
        "$nombre, un inquebrantable $raza $clase, sigue su viaje con $articuloArma $arma, buscando justicia y honor.",
        "$nombre y su $arma han escrito su nombre en la historia, pero su viaje aún no ha terminado.",
        "$nombre ha encontrado su propósito como $raza $clase, blandiendo su $arma en nombre de la libertad.",
        "Las estrellas observan a $nombre mientras su $arma brilla en la oscuridad, esperando el momento de la verdad.",
        "Con un último golpe de $articuloArma $arma, $nombre finalmente cierra un capítulo de su vida y comienza otro." 
    ];


        // Selección aleatoria de fragmentos
        $introduccion = $introducciones[array_rand($introducciones)];
        $conflicto = $conflictos[array_rand($conflictos)];
        $desenlace = $desenlaces[array_rand($desenlaces)];

        // Construcción de la historia final
        return "$introduccion $conflicto $desenlace";
    };



    $_SESSION["texto"]=generarHistoria($_SESSION["s_nombre"],$_SESSION["s_raza"], $_SESSION["s_clase"], $_SESSION["s_arma"]);
    

    // Si el usuario presiona el botón "Volver a empezar", limpiar la sesión
    if (isset($_GET["reset"]) && $_GET["reset"] == "true") {
        session_unset();  // Elimina todas las variables de sesión
        session_destroy(); // Destruye la sesión actual
        header("Location: index.php"); // Redirige a la página inicial
        exit();
    }



?>







<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Personaje D&D</title>
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
            max-width: 900px;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.8);
            animation: glow 2s infinite alternate;
            text-align: center;
            margin-top: 20px;
        }
        @keyframes glow {
            0% { box-shadow: 0 0 20px rgba(255, 215, 0, 0.6); }
            100% { box-shadow: 0 0 30px rgba(255, 215, 0, 1); }
        }
        h1, h2 {
            color: gold;
        }
        .perfil {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .perfil img {
            width: 180px;
            height: 180px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.8);
        }
        .info-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .info, .lista {
            background: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 10px;
            text-align: left;
            flex: 1;
            margin: 10px;
            min-width: 250px;
        }
        .texto-adicional {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: center;
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
        <h1>¡Tu Personaje en Dungeons & Dragons!</h1>
        
        <div class="perfil">
            <img src="imgs/Razas Clases/<?php echo $_SESSION["s_raza"]?>/<?php echo $_SESSION["s_raza"]." ".$_SESSION["s_clase"]; ?>.webp" alt="Personaje">
            <img src="imgs/armas/<?php echo $_SESSION["s_arma"]; ?>.webp" alt="Arma">
        </div>  
        
        <div class="info-container">
            <div class="info">
                <h2>Información del Personaje</h2>
                <p><strong>Nombre:</strong> <?php echo $_SESSION["s_nombre"]; ?></p>
                <p><strong>Raza:</strong> <?php echo $_SESSION["s_raza"]; ?></p>
                <p><strong>Clase:</strong> <?php echo $_SESSION["s_clase"]; ?></p>
                <p><strong>Arma:</strong> <?php echo $_SESSION["s_arma"]; ?></p>
            </div>
            
            <div class="lista">
                <h2>Características</h2>
                <?php
                if (isset($_SESSION["s_caracteristicas"])) {
                    echo "<ul>";
                    foreach ($_SESSION["s_caracteristicas"] as $carac => $valor) {
                        echo "<li><strong>$carac:</strong> $valor</li>";
                    }
                    echo "</ul>";
                }
                ?>
            </div>
            
            <div class="lista">
                <h2>Habilidades</h2>
                <?php
                if (isset($_SESSION["s_habilidades"])) {
                    echo "<ul>";
                    foreach ($_SESSION["s_habilidades"] as $habilidad => $valor) {
                        echo "<li><strong>$habilidad:</strong> $valor</li>";
                    }
                    echo "</ul>";
                }
                ?>
            </div>
        </div>

        <div class="texto-adicional">
            <h2>Historia y Destino</h2>
            <p><?php echo $_SESSION["texto"]?></p>
        </div>

        <div class="botones">
            <button onclick="location.href='resultado.php?reset=true'">Volver a empezar</button>
        </div>
    </div>
</body>
</html>

