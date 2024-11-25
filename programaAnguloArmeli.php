<?php
include_once("wordix.php");

/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/* Angulo Alejo - FAI-5288 - Tecnicatura en Desarrollo Web - alejojoaquin011@gmail.com - Usuario: AnguloJoaquin */
/* Armeli Enzo  - FAI-4038 - Tecnicatura en Desarrollo Web - enzoarmeli@outlook.com - Usuario: enzoarmeli */

/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/

/**
 * Obtiene una colección de palabras
 * @return array $coleccionPalabras
 */
function cargarColeccionPalabras()
{
    $coleccionPalabras = [
        "MUJER", "QUESO", "FUEGO", "CASAS", "RASGO",
        "GATOS", "GOTAS", "HUEVO", "TINTO", "NAVES",
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS",
        "MOTOS", "COLOR", "ACTOR", "AGUDO", "MUNDO",
    ];

    return ($coleccionPalabras);
}

/**
 * Inicializara una coleccion de partidas con ejemplos de partidas y que retornara la coleccion de partidas
 * @return array $coleccionPartidas
 */
function cargarPartidas(){
    
    $coleccionPartidas = [
        ["palabraWordix" => "BEBER", "jugador" => "Lautaro", "intentos" => 5, "puntaje" => 14],
        ["palabraWordix" => "NUBES", "jugador" => "Marcos", "intentos" => 1, "puntaje" => 16],
        ["palabraWordix" => "JUGAR", "jugador" => "Enzo", "intentos" => 2, "puntaje" => 20],
        ["palabraWordix" => "RAMAS", "jugador" => "Lucas", "intentos" => 5, "puntaje" => 5],
        ["palabraWordix" => "CAMPO", "jugador" => "Nahue", "intentos" => 3, "puntaje" => 15],
        ["palabraWordix" => "PLUMA", "jugador" => "Federico", "intentos" => 3, "puntaje" => 13],
        ["palabraWordix" => "PERROS", "jugador" => "Juan", "intentos" => 1, "puntaje" => 25],
        ["palabraWordix" => "HUEVO", "jugador" => "Juliana", "intentos" => 3, "puntaje" => 12],
        ["palabraWordix" => "SALSA", "jugador" => "Antonela", "intentos" => 0, "puntaje" => 0],
        ["palabraWordix" => "RANAS", "jugador" => "Agustin", "intentos" => 3, "puntaje" => 15],
    ];

    return $coleccionPartidas;
}

/**
 * MODULO que muestra al usuario el menu de opciones y le solicitara una opcion valida
 * @param string $usuario
 * @return int $opcion
 */
function seleccionarOpcion(){
    do {
        echo "********** Menu de opciones, seleccione una opcion del 1 al 8 **********\n";
        echo "1. Jugar al wordix con una palabra elegida\n";
        echo "2. Jugar al wordix con una palabra aleatoria\n";
        echo "3. Mostrar partida\n";
        echo "4. Mostrar la primer partida ganada\n";
        echo "5. Mostrar resumen de Jugador\n";
        echo "6. Mostrar listado de partidas ordenadas por jugador y por palabra\n";
        echo "7. Agregar una palabra de 5 letras a Wordix\n";
        echo "8. Salir del menu\n";
        
        $opcion = trim(fgets(STDIN));
    
        if (!is_numeric($opcion) || $opcion < 1 || $opcion > 8){
            echo "Error al elegir un numero, por favor ingrese un numero valido que aparece en el menu";
        }

    } while (!is_numeric($opcion) || $opcion < 1 || $opcion > 8);

    return $opcion;
}

/**
 * MODULO que dado un numero de partidas, mostrara al usuario en pantalla los datos de la partida
 * @param int $numPartida
 * @param array $coleccionPartidas
 */
function mostrarPartida($numPartida, $coleccionPartidas){
    //int $indice
    $indice = $numPartida - 1;

    if ($indice >= 0 && $indice < count($coleccionPartidas)) {
        $partida = $coleccionPartidas[$indice];
        echo "Palabra Wordix: " . $partida['palabraWordix'] . "\n";
        echo "Jugador: " . $partida['jugador'] . "\n";
        echo "Puntaje: " . $partida['puntaje'] . "\n";
        echo "Intentos: " . $partida['intentos'] . "\n";
    } else {
        echo "El numero que ingreso es invalido. Por favor, ingrese un número entre 1 y " . count($coleccionPartidas) . ".\n";
    }
}

/**
 * Agregara la palabra que ingreso el usuario a la coleccion si es que no esta repetida
 * @param array $coleccionPalabras
 * @param string $nuevaPalabra
 * @return array
 */
function agregarPalabra($coleccionPalabras, $nuevaPalabra){
    $nuevaPalabra = strtoupper($nuevaPalabra);

    if (in_array($nuevaPalabra, $coleccionPalabras)){
        echo "Esta palabra ya esta en la coleccion\n";
    }else{
        $coleccionPalabras[]= $nuevaPalabra;
        echo "La nueva palabra " . $nuevaPalabra . " fue agregad\n";
    }
    
    return $coleccionPalabras;
}

/*inciso 8*/
/** 
 *Retorna el indice de la primera partida ganada por el jugador o retornara -1 si no gano ninguna partida
 *@param array $coleccionPartidas
 *@param string $nombreJugador
 *@return int
*/
function obtenerIndiceDePrimeraPartidaGanada($coleccionPartidas, $nombreJugador){
    //int $indice
    $indice = -1;

    foreach($coleccionPartidas as $gano => $partida){
        if ($partida['jugador'] == $nombreJugador && $partida['puntaje'] > 0){
            $indice = $gano;
            break;
        }

    }
    return $indice;
}

/**
 * MODULO que genera un resumen de las partidas de un jugador
 * @param array $coleccionPartidas
 * @param string $nombreJugador
 * @return array 
 */
function generarResumenPartida($coleccionPartidas, $nombreJugador) {
    // array $resumenPartidaJugador
    $resumenPartidaJugador = [
        'jugador' => $nombreJugador, 'partidas' => 0, 'victorias' => 0, 'intento1' => 0, 'intento2' => 0, 'intento3' => 0, 'intento4' => 0, 'intento5' => 0,'intento6' => 0 
    ];

    foreach($coleccionPartidas as $partida) {
        if ($partida['jugador'] == $nombreJugador) {
            $resumenPartidaJugador['partidas']++;
            $resumenPartidaJugador['puntaje'] = $resumenPartidaJugador['puntaje'] + $partida['puntaje'];
        
            if ($partida['puntaje'] > 0) {
                $resumenPartidaJugador['victorias']++;
            }
        }

        $intentoKey = "intento" . $partida["intentos"];
        $resumenPartidaJugador[$intentoKey]++;
    }

    return $resumenPartidaJugador;
}

/**
 * Se le solicitara al usuario que ingrese el nombre de un jugador y que retorne el nombre en minuscula
 * @return string
 */
function solicitarJugador(){
    
    do{
    echo "ingrese un nombre de un jugador";
    $nombreJugador = trim(fgets(STDIN));
    
      if (!ctype_alpha($nombreJugador[0])){
        echo "Error. debe ingresar un nombre que empieze con una letra";
      }

    }while(!ctype_alpha($nombreJugador[0]));

     return strtolower($nombreJugador);
}

/**
 * ordena y muestra la coleccion de partidas por nombre de jugador y por palabra
 * @param array $coleccionPartidas
 */
function mostrarPartidasEnOrden($coleccionPartidas){
    uasort($coleccionPartidas, function ($a, $b) {
        $comparacionJugador = strcmp($a['jugador'], $b['jugador']);

        if ($comparacionJugador === 0) {
            return strcmp($a['palabraWordix'], $b['palabraWordix']);
        }

        return $comparacionJugador;
    });
    print_r($coleccionPartidas);
}

/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:
//int $opcion
//int $eleccion
//
$coleccionPalabras = cargarColeccionPalabras();
$coleccionPartidas = cargarPartidas();

//Inicialización de variables:
$opcion = seleccionarOpcion();
$indicesUtilizadas = [];
//Proceso:

//$partida = jugarWordix("MELON", strtolower("MaJo"));
//print_r($partida);
//imprimirResultado($partida);

do {
    switch ($opcion) {
        case 1: 
                // Jugar al Wordix con una palabra elegida
                $coleccionPalabras = cargarColeccionPalabras();
                $nombreJugador = solicitarJugador(); // Solicitar nombre del jugador
                $indicesUtilizadas = []; // Inicializamos un array para guardar los índices de palabras ya utilizadas

                echo "Bienvenido al juego, " . $nombreJugador . "!\n"; // Confirmar el nombre del jugador

                do {
                    echo "Por favor, seleccione el número de la palabra del listado a continuación:\n";
                    foreach ($coleccionPalabras as $index => $palabra) {
                        echo ($index + 1) . ". " . $palabra . "\n"; // Mostrar las palabras disponibles
                    }
                    $eleccion = trim(fgets(STDIN));

                    // Validamos que la elección esté dentro del rango permitido
                    if ($eleccion < 1 || $eleccion > count($coleccionPalabras)) {
                        echo "Opción inválida. Debe elegir un número entre 1 y " . count($coleccionPalabras) . ".\n";
                        continue; // Volver a pedir la opción si la elección es inválida
                    }

                    // Verificamos si la palabra ya fue utilizada
                    if (in_array($eleccion, $indicesUtilizadas)) {
                        echo "Ya has utilizado la palabra número " . $eleccion . ". Por favor, elige otro número.\n";
                        continue; // Volver a pedir la opción si la palabra ya fue utilizada
                    }

                    // Si la opción es válida y la palabra no fue utilizada, la guardamos
                    $indicesUtilizadas[] = $eleccion;
                    $palabraElegida = $coleccionPalabras[$eleccion - 1];

                    // Aquí llamas a la función jugarWordix para iniciar la partida
                    $partida = jugarWordix($palabraElegida, strtolower($nombreJugador));
                    print_r($partida);
                    break; // Salir del bucle y terminar el case 1 después de jugar

                } while (true);
            break;
        case 2: 
            $jugador = solicitarJugador();

            $palabrasJugadas = array_column($coleccionPartidas, "palabraWordix");
                do {
            $palabraSeleccionada = $coleccionPalabras[array_rand($coleccionPalabras)];
                } while (in_array($palabraSeleccionada, $palabrasJugadas));

            echo "La palabra seleccionada para jugar es: $palabraSeleccionada\n";

            $puntaje = obtenerPuntajeWordix($intentos, $adivina, $palabraAdivinada);

            $coleccionPartidas[] = [
            "palabraWordix" => $palabraSeleccionada,
            "jugador" => $jugador,
            "intentos" => $intentos,
            "puntaje" => $puntaje
            ];

            echo "Partida guardada: Jugador: $jugador, Palabra: $palabraSeleccionada, Intentos: $intentos, Puntaje: $puntaje\n";
            break;
        case 3: 
            do {
                // Solicitar número de partida al usuario
                echo "Ingrese el número de partida: ";
                $numPartida = intval(trim(fgets(STDIN)));
                
                mostrarPartida($numPartida, $coleccionPartidas);
    
                // Validar si existe la partida
                $indice = $numPartida - 1;
            } while ($indice < 0 || $indice >= count($coleccionPartidas));
            break;
        case 4:
            $nombreJugador = solicitarJugador();
            $indicePartidaGanada = obtenerIndiceDePrimeraPartidaGanada($coleccionPartidas, $nombreJugador);

            if($primeraPartidaGanada != -1){
                $partidaGanada = $coleccionPartidas[$indicePartidaGanada];
                echo "Primera partida ganada por " . $nombreJugador . ":\n";
                echo "Palabra Wordix: " . $partidaGanada['palabraWordix'] . "\n";
                echo "Intentos: " . $partidaGanada['intentos'] . "\n";
                echo "Puntaje: " . $partidaGanada['puntaje'] . "\n";
            } else {
                echo "No se pudo encontrar una partida que haya sido ganada por " . $nombreJugador . "\n";
            }


            break;
        case 5:

            break;
        case 6:

            break;
        case 7:

            break;
        case 8:
            echo "saliendo del programa";
            break; 
    }

} while ($opcion != 8);