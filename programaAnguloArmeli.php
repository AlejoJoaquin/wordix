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
