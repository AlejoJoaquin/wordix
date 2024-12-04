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
 * Muestra estadísticas de un jugador basado en las partidas jugadas.
 * @param string $nombreJugador Nombre del jugador
 * @param array $partidas Colección de partidas
 */
// Función para calcular estadísticas
function obtenerEstadisticasJugador($nombreJugador, $partidas)
{
    $estadisticas = [
        "nombre" => ucfirst($nombreJugador),
        "partidas" => 0,
        "puntajeTotal" => 0,
        "victorias" => 0,
        "adivinadas" => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
        "porcentajeVictorias" => 0
    ];

    foreach ($partidas as $partida) {
        if (strtolower($partida["jugador"]) === strtolower($nombreJugador)) {
            $estadisticas["partidas"]++;
            $estadisticas["puntajeTotal"] += $partida["puntaje"];
            
            if ($partida["puntaje"] > 0) {
                $estadisticas["victorias"]++;
                $intentos = $partida["intentos"];
                if ($intentos <= 5) {
                    $estadisticas["adivinadas"][$intentos]++;
                }
            }
        }
    }

    if ($estadisticas["partidas"] > 0) {
        $estadisticas["porcentajeVictorias"] = round(($estadisticas["victorias"] / $estadisticas["partidas"]) * 100);
    }

    return $estadisticas;
}

// Función para mostrar las estadísticas
function mostrarEstadisticasJugador($estadisticas)
{
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
 * MODULO que muestra al usuario el menu de opciones y le solicitara una opcion valida
 * @param string $usuario
 * @return int $opcion
 */
function seleccionarOpcion(){
    //int $opcion
    do {
        //este es el menu de ususario que se le mostrara al usuario
        echo "********** Menu de opciones, seleccione una opcion del 1 al 8 **********\n";
        echo "1. Jugar al wordix con una palabra elegida\n";
        echo "2. Jugar al wordix con una palabra aleatoria\n";
        echo "3. Mostrar partida\n";
        echo "4. Mostrar la primer partida ganada\n";
        echo "5. Mostrar resumen de Jugador\n";
        echo "6. Mostrar listado de partidas ordenadas por jugador y por palabra\n";
        echo "7. Agregar una palabra de 5 letras a Wordix\n";
        echo "8. Salir del menu\n";
        
        //leera la opcion ingresada por el usuario
        $opcion = trim(fgets(STDIN));
        //se verifica si la opcion que fue ingresada es un numero y si esta en el rango requerido
        if (!is_numeric($opcion) || $opcion < 1 || $opcion > 8){
            //se le mostrara este mensaje al usuario si la opcion ingresada no es valida
            echo "Error al elegir un numero, por favor ingrese un numero valido que aparece en el menu\n";
        }
     //se le pedira al usuario que ingrese una opcion hasta que sea valida
    } while (!is_numeric($opcion) || $opcion < 1 || $opcion > 8);
    //devuelve la opcion seleccionada por el ususario
    return $opcion;
}

/**
 * MODULO que dado un numero de partidas, mostrara al usuario en pantalla los datos de la partida
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

        //muestra el mensaje por pantalla al usuario
        echo "Palabra Wordix: " . $partida['palabraWordix'] . "\n";
        echo "Jugador: " . $partida['jugador'] . "\n";
        echo "Puntaje: " . $partida['puntaje'] . "\n";
        echo "Intentos: " . $partida['intentos'] . "\n";
    } else {
        //este mensaje se le mostrara al usuario si el indice es invalido
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
    //int $cantPalabras
    //boolean $existe
    //obtenemos la cantidad de palabras
    $cantPalabras = count($coleccionPalabras);
    do {
        //inicializamos una variable que indicara si la palabra ya existe
        $existe = false;
        //recorremos la coleccion de palabras para verificar si la nueva palabra ya existe
        for ($i = 0; $i < $cantPalabras; $i++) {
            if ($coleccionPalabras[$i] === $nuevaPalabra) {
                //si la palabra existe, se cumple la condicion y se sale del bucle
                $existe = true;
                break;
            }
        }
        //si la palabra ya esta en la coleccion se le solicitara que agregue 
        if ($existe) {
            echo "Esta palabra ya está en la colección. Intente con otra palabra.\n";
            //leera la nueva palabra que ingrese el usuario y la convertira a mayusculas
            $nuevaPalabra = strtoupper(trim(fgets(STDIN)));
        } else {
            //si la palabra no existe en la coleccion, se agrega la nueva palabra
            $coleccionPalabras[] = $nuevaPalabra;
            echo "La nueva palabra '" . $nuevaPalabra . "' fue agregada exitosamente.\n";
            break; 
        }
        //continuara solicitandole al usuario hasta que agregue una palabra nueva
    } while (true);
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

    for ($i = 0; $i < count($coleccionPartidas); $i++) {
        if (strtolower($coleccionPartidas[$i]['jugador']) == strtolower($nombreJugador) && $coleccionPartidas[$i]['puntaje'] > 0) {
            $indice = $i;
            break; 
        }
    }
    return $indice;
}


/**
 * Se le solicitara al usuario que ingrese el nombre de un jugador y que retorne el nombre en minuscula
 * @return string
 */
function solicitarJugador(){
    
    do{
    echo "ingrese un nombre de un jugador: ";
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


/** 
 *Muestra un listado de partidas ordenadas por jugador y por palabra.
 *
 *@param array $coleccionPartidas 
*/
function ordenarPartidas($coleccionPartidas)
{
    uasort($coleccionPartidas, function ($a, $b) {
        // Ordenar por jugador alfabéticamente
        $comparacionJugador = strcmp($a['jugador'], $b['jugador']);
        if ($comparacionJugador === 0) {
            // Si los jugadores son iguales, ordenar por palabra
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

$indicesUtilizadas = [];
$partidas = cargarPartidas();
//Proceso:

//$partida = jugarWordix("MELON", strtolower("MaJo"));
//print_r($partida);
//imprimirResultado($partida);

do {

    $opcion = seleccionarOpcion();

    switch ($opcion) {
        case 1: 
            
            $nombreJugador = solicitarJugador();
            $cantPlabras = count($coleccionPalabras);
    
            if (!isset($partidasPorJugador[$nombreJugador])) {
                $partidasPorJugador[$nombreJugador] = [];
            }
    
            do {
                echo "Ingrese por favor el número de la palabra (1 a " . $cantPlabras . "): ";
                $eleccion = solicitarNumeroEntre(1, $cantPlabras);
    
                $indiceUtilizado = false;
                $cantidadPartidas = count($partidasPorJugador[$nombreJugador]);
    
                for ($i = 0; $i < $cantidadPartidas; $i++) {
                    if ($partidasPorJugador[$nombreJugador][$i] === $eleccion) {
                        $indiceUtilizado = true;
                        break;
                    }
                }
    
                if ($indiceUtilizado) {
                    echo "Ya has utilizado la palabra número " . $eleccion . ". Por favor, elige otro número.\n";
                }
            } while ($indiceUtilizado);
    
            $partidasPorJugador[$nombreJugador][] = $eleccion;
            $palabraElegida = $coleccionPalabras[$eleccion - 1];
            $partida = jugarWordix($palabraElegida, strtolower($nombreJugador));
    
            // Mostrar la partida jugada
            echo "Partida guardada: Jugador: " . $nombreJugador . "\n";
            echo "Palabra: " . $palabraElegida . "\n";
            echo "Intentos: " . $partida["intentos"] . "\n";
            echo "Puntaje: " . $partida["puntaje"] . "\n";
    
        break;
        case 2: 
            $jugador = solicitarJugador();

            $cantidadPartidas = count($coleccionPartidas);
            $palabraJugada = true;

            while($palabraJugada){
                $indiceAleatorio = rand(0, count($coleccionPalabras) - 1);
                $palabraSeleccionada = $coleccionPalabras[$indiceAleatorio];
    
                $palabraJugada = false;
                for ($i = 0; $i < count($coleccionPartidas); $i++){
                    if (strtolower($coleccionPartidas[$i]["jugador"]) === strtolower($jugador) && $coleccionPartidas[$i]["palabraWordix"] === $palabraSeleccionada){
                        $palabraJugada = true;
                        break;
                    }
                }
            }

            $partida = jugarWordix($palabraSeleccionada, strtolower($jugador));

            $intentos = $partida["intentos"];
            $puntaje = $partida["puntaje"];

            $coleccionPartidas[] = [
                "palabraWordix" => $partida["palabraWordix"],
                "jugador" => $partida["jugador"],
                "intentos" => $partida["intentos"],
                "puntaje" => $partida["puntaje"]
            ];

            echo "Partida guardada: Jugador: ". $jugador . "\n"; 
            echo "Palabra: " . $palabraSeleccionada . "\n"; 
            echo "Intentos: " . $intentos . "\n"; 
            echo "Puntaje: " . $puntaje . "\n";
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

            if($indicePartidaGanada != -1){
                $partidaGanada = $coleccionPartidas[$indicePartidaGanada];
                echo "********** Primera Partida Ganada **********\n";
                echo "Partida Wordix " . ($indicePartidaGanada + 1) . " palabra " . $partidaGanada['palabraWordix'] . "\n";
                echo "Jugador " . $nombreJugador . "\n";
                echo "Puntaje " . $partidaGanada['puntaje'] . " puntos \n";
                echo "Inento: Adivino la palabra en " .$partidaGanada['intentos'] . " intentos\n";
            } else {
                echo "El jugador " . $nombreJugador . " no gano ninguna partida";
            }
            break;
        case 5:                  
            echo "Ingrese el nombre del jugador: ";
            $nombreJugador = trim(fgets(STDIN));
            
            $estadisticas = obtenerEstadisticasJugador($nombreJugador, cargarPartidas());
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