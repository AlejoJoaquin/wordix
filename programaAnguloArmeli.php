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
    //inicializamos el arreglo que contendra las palabras
    $coleccionPalabras = [
        "MUJER", "QUESO", "FUEGO", "CASAS", "RASGO",
        "GATOS", "GOTAS", "HUEVO", "TINTO", "NAVES",
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS",
        "MOTOS", "COLOR", "ACTOR", "AGUDO", "MUNDO",
    ];
    return $coleccionPalabras;
}

/**
 * Inicializara una coleccion de partidas con ejemplos de partidas y que retornara la coleccion de partidas
 * @return array $coleccionPartidas
 */
function cargarPartidas(){
    //inicializamos el array que contendra las partidas 
    $coleccionPartidas = [
        ["palabraWordix" => "BEBER", "jugador" => "Lautaro", "intentos" => 5, "puntaje" => 14],
        ["palabraWordix" => "NUBES", "jugador" => "Marcos", "intentos" => 1, "puntaje" => 16],
        ["palabraWordix" => "JUGAR", "jugador" => "Enzo", "intentos" => 2, "puntaje" => 20],
        ["palabraWordix" => "RAMAS", "jugador" => "Lucas", "intentos" => 5, "puntaje" => 5],
        ["palabraWordix" => "CAMPO", "jugador" => "Nahuel", "intentos" => 3, "puntaje" => 15],
        ["palabraWordix" => "PLUMA", "jugador" => "Federico", "intentos" => 3, "puntaje" => 13],
        ["palabraWordix" => "PERROS", "jugador" => "Juan", "intentos" => 1, "puntaje" => 25],
        ["palabraWordix" => "HUEVO", "jugador" => "Juliana", "intentos" => 3, "puntaje" => 12],
        ["palabraWordix" => "SALSA", "jugador" => "Antonela", "intentos" => 0, "puntaje" => 0],
        ["palabraWordix" => "RANAS", "jugador" => "Agustin", "intentos" => 3, "puntaje" => 15],
    ];
    return $coleccionPartidas;
}

/**
 * Función que muestra estadísticas de un jugador basado en las partidas jugadas.
 * 
 * @param string $nombreJugador Nombre del jugador.
 * @param array $partidas Colección de partidas.
 * @return array Estadísticas del jugador.
 */
function obtenerEstadisticasJugador($nombreJugador, $partidas) {
    $estadisticas = [
        "nombre" => ucfirst($nombreJugador),
        "partidas" => 0,
        "puntajeTotal" => 0,
        "victorias" => 0,
        "adivinadas" => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
        "porcentajeVictorias" => 0
    ];

    foreach ($partidas as $partida) {
        // Verificamos si el jugador de la partida es el buscado
        if (strtolower($partida["jugador"]) === strtolower($nombreJugador)) {
            // Actualizamos las estadísticas de partidas y puntaje total
            $estadisticas["partidas"]++;
            $estadisticas["puntajeTotal"] += $partida["puntaje"];

            // Condición combinada para victoria y conteo de intentos
            if ($partida["puntaje"] > 0 && $partida["intentos"] <= 5) {
                $estadisticas["victorias"]++;
                $estadisticas["adivinadas"][$partida["intentos"]]++;
            }
        }
    }

    // Calculamos el porcentaje de victorias, si se han jugado partidas
    if ($estadisticas["partidas"] > 0) {
        $estadisticas["porcentajeVictorias"] = round(($estadisticas["victorias"] / $estadisticas["partidas"]) * 100);
    }

    return $estadisticas;
}

/**
 * Función para mostrar las estadisticas de un jugador
 * @param array $nombreJugador
 */
function mostrarEstadisticasJugador($estadisticas) {

    echo "*******************\n";
    echo "Jugador: " . $estadisticas["nombre"] . "\n";
    echo "Partidas: " . $estadisticas["partidas"] . "\n";
    echo "Puntaje total: " . $estadisticas["puntajeTotal"] . "\n";
    echo "Porcentaje victorias: " . $estadisticas["porcentajeVictorias"] . "%\n";
    echo "Adivinadas:\n";

    foreach ($estadisticas["adivinadas"] as $intento => $cantidad) {
        echo "    Intento $intento: $cantidad\n";
    }

    echo "********************\n";
}

/**
 * funcion que muestra al usuario el menu de opciones y le solicitara una opcion valida
 * @param string $usuario
 * @return int $opcion
 */
function seleccionarOpcion(){
    //int $opcion
    echo "********** Menu de opciones, seleccione una opcion del 1 al 8 **********\n";
    echo "1. Jugar al wordix con una palabra elegida\n";
    echo "2. Jugar al wordix con una palabra aleatoria\n";
    echo "3. Mostrar partida\n";
    echo "4. Mostrar la primer partida ganada\n";
    echo "5. Mostrar resumen de Jugador\n";
    echo "6. Mostrar listado de partidas ordenadas por jugador y por palabra\n";
    echo "7. Agregar una palabra de 5 letras a Wordix\n";
    echo "8. Salir del menu\n";
        
    $opcion = solicitarNumeroEntre(1,8);
    
    return $opcion;
}

/**
 * funcion que dado un numero de partidas, mostrara al usuario en pantalla los datos de la partida
 * @param int $numPartida
 * @param array $coleccionPartidas
 */
function mostrarPartida($numPartida, $coleccionPartidas){
    //int $indice
    //array $partida
    //calcula el indice correspondiente al numero de partida ingresado
    $indice = $numPartida - 1;

    //verifica si el indice esta dentro del rango valido
    if ($indice >= 0 && $indice < count($coleccionPartidas)) {
        //se obtiene la partida correspondiente al indice calculado
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
 * Agrega la palabra que ingresó el usuario a la colección si no está repetida
 * @param array $coleccionPalabras
 * @param string $nuevaPalabra
 * @return array
 */
function agregarPalabra($coleccionPalabras, $nuevaPalabra) {
    // Variable para verificar si la palabra ya existe si ponemos "true" es como que esta desde un principio desde los tiempos
    $existe = false;

    // Usamos un ciclo for para recorrer la colección
    for ($i = 0; $i < count($coleccionPalabras); $i++) {
        if ($coleccionPalabras[$i] === $nuevaPalabra) {
            $existe = true;
            // Si encontramos que la palabra existe, salimos del ciclo y no agregamos la palabra
        }
    }

    // Si la palabra no existe en la colección
    if (!$existe) {
        // Agregar la nueva palabra a la colección
        $coleccionPalabras[] = $nuevaPalabra;
        echo "La palabra " . $nuevaPalabra . " fue agregada exitosamente a la colección.\n";
    } else {
        // Si la palabra ya existe, pedimos una nueva palabra
        echo "Esta palabra ya está en la colección. Intente con otra palabra:\n";
        $nuevaPalabra = leerPalabra5Letras(); // Le solicitamos una nueva palabra
        // Volver a llamar a la función con la nueva palabra
        $coleccionPalabras = agregarPalabra($coleccionPalabras, $nuevaPalabra);
    }

    return $coleccionPalabras;
}

/**
 * Retorna el índice de la primera partida ganada por el jugador o retornará -1 si no ganó ninguna partida
 * @param array $coleccionPartidas
 * @param string $nombreJugador
 * @return int
 */
function obtenerIndiceDePrimeraPartidaGanada($coleccionPartidas, $nombreJugador) {
    // Inicializamos el índice en -1, que indica que no se ha encontrado ninguna partida ganada
    $indice = -1;

    // Recorremos sobre cada partida
    for ($i = 0; $i < count($coleccionPartidas); $i++) {
        // Comprobamos si el jugador es el mismo que ingresamos y si su puntaje es mayor a 0
        if (strtolower($coleccionPartidas[$i]['jugador']) == strtolower($nombreJugador) && $coleccionPartidas[$i]['puntaje'] > 0) {
            // Se ha encontrado una victoria del jugador, almacenamos el índice y salimos del bucle
            $indice = $i;
        }
    }
    
    // Retorna el índice si encontró una partida ganada, si no retornará -1
    return $indice;
}

/**
 * Se le solicitara al usuario que ingrese el nombre de un jugador y que retorne el nombre en minuscula
 * @return string
 */
function solicitarJugador(){
    //string $nombreJugador
    
    do {
    echo "ingrese un nombre de un jugador: ";
    $nombreJugador = trim(fgets(STDIN));
    
    //verificamos si el primer caracter del nombre del jugador es una letra
        if (!ctype_alpha($nombreJugador[0])){
        //si no es un caracter, mostrara este mensaje a continuacion
        echo "Error. debe ingresar un nombre que empieze con una letra\n";
      }
     //se estara repitiendo hasta que ingrese un nombre valido
    }while(!ctype_alpha($nombreJugador[0]));
     //retorna el nombre en minusculas
     return strtolower($nombreJugador);
}


/** 
 *Muestra un listado de partidas ordenadas por jugador y por palabra.
 *
 *@param array $coleccionPartidas 
*/
function ordenarPartidas($coleccionPartidas){
    //ordenamos la coleccion de partidas
    uasort($coleccionPartidas, function ($a, $b) {
        // Ordenar por jugador alfabéticamente
        $comparacionJugador = strcmp($a['jugador'], $b['jugador']);
        if ($comparacionJugador === 0) {
            // Si los jugadores son iguales, ordenar por palabra
            return strcmp($a['palabraWordix'], $b['palabraWordix']);
        }
        //retorna el resultado de la comparacion de los jugadores
        return $comparacionJugador;
    });

    //imprimimos la coleccion de partidas
    print_r($coleccionPartidas);     
}

/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:
//int $opcion
//int $eleccion
//int $indice
//string $nombreJugador
//string $palabraElegida
//array $estadisticas
//array $partidaJugador
//array $coleccionPalabras
//array $PartidasPorJugador
//array $coleccionPartidas
//Inicialización de variables:
$coleccionPalabras = cargarColeccionPalabras();
$coleccionPartidas = cargarPartidas();
$indicesUtilizadas = [];
$partidas = cargarPartidas();
//Proceso:

//$partida = jugarWordix("MELON", strtolower("MaJo"));
//print_r($partida);
//imprimirResultado($partida);

do {
    //mostrara el menu y se le pedira al usuario que ingrese una opcion
    $opcion = seleccionarOpcion();

    switch ($opcion) {
        case 1:
// Solicita al jugador que elija una palabra para jugar
$nombreJugador = solicitarJugador(); // Solicitará el nombre del jugador
$cantPlabras = count($coleccionPalabras); // Número total de palabras disponibles

// Inicializamos un bucle para asegurarnos de que se elija una palabra no utilizada previamente
do {
    // Se solicita al jugador un número de índice válido para elegir la palabra
    echo "Ingrese por favor el número de la palabra (1 a " . $cantPlabras . "): ";
    $eleccion = solicitarNumeroEntre(1, $cantPlabras); // Validamos la elección

    $indiceUtilizado = false; // Inicializamos la variable para verificar si la palabra fue usada

    // Recorremos la colección de partidas para verificar si la palabra ya fue utilizada por el jugador
    foreach ($coleccionPartidas as $partida) {
        if (
            strtolower($partida['jugador']) === strtolower($nombreJugador) && $partida['palabraWordix'] === $coleccionPalabras[$eleccion - 1]) {
            $indiceUtilizado = true; // Marcamos como utilizada si coincide
        }
    }

    // Si ya se usó la palabra, informamos al jugador
    if ($indiceUtilizado) {
        echo "Ya has utilizado la palabra número " . $eleccion . ". Por favor, elige otro número.\n";
    }
} while ($indiceUtilizado); // Repetimos si la palabra ya fue usada

// Una vez seleccionada una palabra válida, jugamos la partida
$palabraElegida = $coleccionPalabras[$eleccion - 1];
$partida = jugarWordix($palabraElegida, strtolower($nombreJugador));

// Agregamos los datos de la nueva partida a la colección
$coleccionPartidas[] = [
    "palabraWordix" => $partida["palabraWordix"],
    "jugador" => $partida["jugador"],
    "intentos" => $partida["intentos"],
    "puntaje" => $partida["puntaje"]
];

        break;
        case 2: 
            // Se solicita al usuario que ingrese el nombre del jugador
            $jugador = solicitarJugador();
            // Obtenemos la cantidad de partidas
            $cantidadPartidas = count($coleccionPartidas);
            // Variable que verifica si la palabra que seleccionó el usuario ya ha sido jugada anteriormente
            $palabraJugada = true;

            // Bucle que funciona para seleccionar una palabra que no haya elegido el jugador
            while ($palabraJugada) {
                // Se selecciona un índice aleatorio dentro del rango de palabras disponibles
                $indiceAleatorio = rand(0, count($coleccionPalabras) - 1);
                // Obtenemos la palabra seleccionada respecto al índice
                $palabraSeleccionada = $coleccionPalabras[$indiceAleatorio];
                // Inicializamos la variable en falso, asumiendo que la palabra no ha sido jugada
                $palabraJugada = false;

                // Verificamos si la palabra seleccionada ya ha sido jugada por el jugador
                $i = 0;
                while ($i < count($coleccionPartidas) && !$palabraJugada) {
                // Comparamos el nombre del jugador y la palabra jugada
                if (
                strtolower($coleccionPartidas[$i]["jugador"]) === strtolower($jugador) &&
                $coleccionPartidas[$i]["palabraWordix"] === $palabraSeleccionada
                ) {
                // Si la palabra ya fue jugada, marcamos la variable como true para repetir el proceso
                $palabraJugada = true;
                }   
                $i++;
            }   
        }

        // Llamamos a la función jugarWordix
        $partida = jugarWordix($palabraSeleccionada, strtolower($jugador));
        // Obtenemos el número de intentos y el puntaje de la partida
        $intentos = $partida["intentos"];
        $puntaje = $partida["puntaje"];
        // Guardamos los resultados de la partida en la colección
        $coleccionPartidas[] = [
            "palabraWordix" => $partida["palabraWordix"],
            "jugador" => $partida["jugador"],
            "intentos" => $partida["intentos"],
            "puntaje" => $partida["puntaje"],
        ];
        // Mostramos un mensaje al usuario con los resultados de la partida
        echo "Partida guardada: Jugador: " . $jugador . "\n";
        echo "Palabra: " . $palabraSeleccionada . "\n";
        echo "Intentos: " . $intentos . "\n";
        echo "Puntaje: " . $puntaje . "\n";

            break;
        case 3: 
            do {
                // Solicitar número de partida al usuario
                echo "Ingrese el número de partida: ";
                $numPartida = intval(trim(fgets(STDIN)));
                //mostrara los datos correspondiente al numero ingresado
                mostrarPartida($numPartida, $coleccionPartidas);
    
                // Validar si existe la partida
                $indice = $numPartida - 1;//ajusta el numero de partida para que coincida con l indice d arreglo
            } while ($indice < 0 || $indice >= count($coleccionPartidas));//se repetira si el numero esta fura de rango
            break;
        case 4:
            $nombreJugador = solicitarJugador();//se le solicita el nombre al usuario 
            $indicePartidaGanada = obtenerIndiceDePrimeraPartidaGanada($coleccionPartidas, $nombreJugador);//obtenemos el indice de la partida ganada
            
            if ($indicePartidaGanada != -1) {
                //si se encontro una partida ganada, se obtiene la informacion de esa partida
                //muestra los datos de la partida ganada
                $partidaGanada = $coleccionPartidas[$indicePartidaGanada];
                echo "********** Primera Partida Ganada **********\n";
                echo "Partida Wordix " . ($indicePartidaGanada + 1) . " palabra " . $partidaGanada['palabraWordix'] . "\n";
                echo "Jugador " . $nombreJugador . "\n";
                echo "Puntaje " . $partidaGanada['puntaje'] . " puntos \n";
                echo "Intentos: Adivino la palabra en " .$partidaGanada['intentos'] . " intentos\n";
            } else {
                //se le mostrata este mensaje al usuario si el jugador no gano ninguna partida
                echo "El jugador " . $nombreJugador . " no gano ninguna partida\n";
            }
            break;
        case 5:                  
            $jugador = solicitarJugador();
            $estadisticas = obtenerEstadisticasJugador($jugador, $coleccionPartidas);
            mostrarEstadisticasJugador($estadisticas);
            break;
        case 6:
            ordenarPartidas($coleccionPartidas);
            break;
        case 7:
             $nuevaPalabra = leerPalabra5Letras();
             $coleccionPalabras = agregarPalabra($coleccionPalabras, $nuevaPalabra);
            break;
        case 8:
            echo "Saliendo del Programa...";
            break; 
    }

} while ($opcion != 8);

?>