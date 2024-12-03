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
function mostrarEstadisticasJugador($nombreJugador, $partidas)
{
    $totalPartidas = 0;
    $puntajeTotal = 0;
    $victorias = 0;
    $adivinadas = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

    $i = 0;
    $cantidadPartidas = count($partidas);

    while($i < $cantidadPartidas) {
        if (strtolower($partidas[$i]["jugador"]) === strtolower($nombreJugador)) {
            $totalPartidas++;
            $puntajeTotal += $partidas[$i]["puntaje"];
            if ($partidas[$i]["intentos"] > 0) {
                $adivinadas[$partidas[$i]["intentos"]]++;
                $victorias++;
                if ($partidas[$i]["intentos"] <= 6) { 
                    $adivinadas[$partidas[$i]["intentos"]]++;
                }
            }
        }
        $i++;

    }

    $porcentajeVictorias = ($totalPartidas > 0) ? round(($victorias / $totalPartidas) * 100) : 0;
    // Mostrar resultados
    echo "*******************\n";
    echo "Jugador: " . ucfirst($nombreJugador) . "\n";
    echo "Partidas: " . $totalPartidas . "\n";
    echo "Puntaje total: " . $puntajeTotal . "\n";
    echo "Victorias: " . $victorias . "\n";
    echo "Porcentaje victorias: " . round($porcentajeVictorias) . "%\n";
    echo "Adivinadas:\n";
    for ($j = 1; $j <= count($adivinadas); $j++) {
        echo "    Intento $j: " . $adivinadas[$j] . "\n";
    }
    echo "*******************\n";
}

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
    return $coleccionPalabras;
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
            echo "Error al elegir un numero, por favor ingrese un numero valido que aparece en el menu\n";
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
   
    $cantPlabras = count($coleccionPalabras);
    do {
        $existe = false;

        for ($i = 0; $i < $cantPlabras; $i++) {
            if ($coleccionPalabras[$i] === $nuevaPalabra) {
                $existe = true;
                break;
            }
        }

        if ($existe) {
            echo "Esta palabra ya está en la colección. Intente con otra palabra.\n";
            $nuevaPalabra = strtoupper(trim(fgets(STDIN)));
        } else {
            $coleccionPalabras[] = $nuevaPalabra;
            echo "La nueva palabra '" . $nuevaPalabra . "' fue agregada exitosamente.\n";
            break; 
        }
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
            //Jugar al wordix con una palabra elegida
            $nombreJugador = solicitarJugador();
            $cantPlabras = count($coleccionPalabras);

           if (!isset($partidaJugador)) {
            $partidaJugador = []; 
           }

           if (!isset($partidasPorJugador[$nombreJugador])) {
            $partidasPorJugador[$nombreJugador] = [];    
        }
        
        do{  
            echo "Ingrese por favor el numero de la palabra (1 a " . $cantPlabras . "): "; 
            $eleccion = solicitarNumeroEntre(1, $cantPlabras);

            $indiceUtilizado = false;
            $cantidadPartidas = count($partidasPorJugador[$nombreJugador]);
             
             for ($i = 0; $i < $cantidadPartidas; $i++){            
                if ($partidasPorJugador[$nombreJugador][$i] === $eleccion) {
                    $indiceUtilizado = true; 
                    break;
                }
              }

              if ($indiceUtilizado) {
                 echo "Ya has utilizado la palabra número " . $eleccion . ". Por favor, elige otro número.\n";
                }
            } while($indiceUtilizado);
            $partidasPorJugador[$nombreJugador][] = $eleccion;
            $palabraElegida = $coleccionPalabras[$eleccion - 1];
            $partida = jugarWordix($palabraElegida, strtolower($nombreJugador));
            print_r($partida);
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
            $partidas = cargarPartidas();
            
            echo "Ingrese el nombre del jugador: ";
            $nombreJugador = trim(fgets(STDIN));
            
            mostrarEstadisticasJugador($nombreJugador, $partidas);            
            break;
        case 6:
            function ordenarPartidas($partidas)
            {
                uasort($partidas, function ($a, $b) {
                    // Ordenar por jugador alfabéticamente
                    $comparacionJugador = strcmp($a['jugador'], $b['jugador']);
                    if ($comparacionJugador === 0) {
                        // Si los jugadores son iguales, ordenar por palabra
                        return strcmp($a['palabraWordix'], $b['palabraWordix']);
                    }
                    return $comparacionJugador;
                });
            
                return $partidas;
            }
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