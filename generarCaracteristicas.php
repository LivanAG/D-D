<?php
session_start();

function generarCaracteristicas($razaSeleccionada) {
    $modificadoresRaza = [
        "Humano" => ["Fuerza" => 1, "Destreza" => 1, "Constitución" => 1, "Inteligencia" => 1, "Sabiduría" => 1, "Carisma" => 1],
        "Enano" => ["Fuerza" => 2, "Constitución" => 2],
        "Elfo" => ["Destreza" => 2, "Sabiduría" => 1],
        "Gnomo" => ["Inteligencia" => 2],
        "Semielfo" => ["Carisma" => 2, "Destreza" => 1, "Sabiduría" => 1],
        "Dracónido" => ["Fuerza" => 2, "Carisma" => 1],
        "Mediano" => ["Destreza" => 2],
        "Semiorco" => ["Fuerza" => 2, "Constitución" => 1],
        "Tiflin" => ["Carisma" => 2, "Inteligencia" => 1]
    ];

    $caracteristicas = ["Fuerza", "Destreza", "Constitución", "Inteligencia", "Sabiduría", "Carisma"];
    $valores = [];

    foreach ($caracteristicas as $carac) {
        $valores[$carac] = rand(8, 18);
    }

    foreach ($modificadoresRaza[$razaSeleccionada] as $caracteristica => $modificador) {
        $valores[$caracteristica] += $modificador;
    }

    $_SESSION["s_caracteristicas"] = $valores;

    return $valores;
    
}
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION["s_raza"])) {
        echo json_encode(["error" => "Raza no definida en la sesión."]);
        exit();
    }


    $caracteristicas = generarCaracteristicas($_SESSION["s_raza"]);

    // Devolver las características en formato JSON
    echo json_encode($caracteristicas);
    /*Convertimos el array en JSON y lo enviamos como respuesta al cliente 
    (JavaScript lo interpretará y actualizará la página dinámicamente).

    ¿Por qué echo y no return?

    /*

    Cuando un script PHP se ejecuta en respuesta a una solicitud HTTP (como una petición AJAX en nuestro caso), la forma en que el servidor responde al navegador es a través de la salida estándar.

        echo en PHP envía la salida al cliente (JavaScript en nuestro caso).
        return solo devolvería el valor dentro de la función en PHP, pero no lo enviaría al navegador.

    */
    
    
    

}
?>
