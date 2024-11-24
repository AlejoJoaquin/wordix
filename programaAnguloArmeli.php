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
 * @return array
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
 * @return array
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
 * Le muestra al usuario el menu de opciones y le solicitara una opcion valida
 * 
 * @return int 
 */
function seleccionarOpcion(){
    do{
        echo "Menu de opciones\n";
        echo "1. Jugar al wordix con una palabra elegida\n";
        echo "2. Jugar al wordix con una palabra aleatoria\n";
        echo "3. Mostrar partida\n";
        echo "4. Mostrar la primer partida ganada\n";
        echo "5. Mostrar resumen de Jugador\n";
        echo "6. Mostrar listado de partidas ordenadas por jugador y por palabra\n";
        echo "7. Agregar una palabra de 5 letras a Wordix\n";
        echo "8. Salir del menu";
        
        $opcion = trim(fgets(STDIN));
    
        if(!is_numeric($opcion) || $opcion < 1 || $opcion > 5){
            echo "Error al elegir un numero, por favor ingrese un numero valido que aparece en el menu";

        }
    }while(!is_numeric($opcion) || $opcion < 1 || $opcion > 5);
    return $opcion;

}

/**
 * Dado un numero de partidas, mostrara al usuario en pantalla los datos de la partida
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
 * Generara un resumen de las partidas de un jugador
 * @param array $coleccionPartidas
 * @param string $nombreJugador
 * @return array
 */
function generarResumenPartida($coleccionPartidas, $nombreJugador){
        // array $resumenPartidaJugador
    $resumenPartidaJugador = [
        'jugador' => $nombreJugador, 'partidas' => 0, 'victorias' => 0, 'intento1' => 0, 'intento2' => 0, 'intento3' => 0, 'intento4' => 0, 'intento5' => 0,'intento6' => 0 
    ];

    foreach($coleccionPartidas as $partida){
        if ($partida['jugador'] == $nombreJugador){
            $resumenPartidaJugador['partidas']++;
            $resumenPartidaJugador['puntaje'] = $resumenPartidaJugador['puntaje'] + $partida['puntaje'];
        
            if($partida['puntaje'] > 0){
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
    });
}

/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:


//Inicialización de variables:


//Proceso:

$partida = jugarWordix("MELON", strtolower("MaJo"));
//print_r($partida);
//imprimirResultado($partida);



/*
do {
    $opcion = ...;

    
    switch ($opcion) {
        case 1: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 1

            break;
        case 2: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 2

            break;
        case 3: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3

            break;
        
            //...
    }
} while ($opcion != X);
*/
